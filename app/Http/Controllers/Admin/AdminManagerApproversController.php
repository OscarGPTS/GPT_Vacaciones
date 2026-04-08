<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagerApprover;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminManagerApproversController extends Controller
{
    /**
     * Mostrar el panel de gestión de jefes directos personalizados.
     */
    public function index()
    {
        // Obtener todos los aprobadores con sus relaciones
        $approvers = ManagerApprover::with(['user', 'user.job', 'departamento', 'employee', 'employee.job'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('boss_id');
        
        // Obtener usuarios activos para el select
        $users = User::with('job')->where('active', 1)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Obtener todos los departamentos
        $departamentos = Departamento::orderBy('name')->get();
        
        return view('admin.manager-approvers.index', compact('approvers', 'users', 'departamentos'));
    }

    /**
     * Asignar un usuario como jefe directo.
     * NUEVA LÓGICA: 
     * - Si se selecciona un departamento, se crean MÚTIPLES registros (uno por empleado).
     * - Si se selecciona un usuario específico, se crea UN solo registro.
     * - Cada registro tiene: boss_id (aprobador), employee_id (empleado), departamento_id (para filtros).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assignment_type' => 'required|in:departamento,usuario',
            'departamentos' => 'required_if:assignment_type,departamento|array|min:1',
            'departamentos.*' => 'exists:departamentos,id',
            'usuarios_especificos' => 'required_if:assignment_type,usuario|array|min:1',
            'usuarios_especificos.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);
            $assigned = 0;
            $skipped = 0;

            if ($request->assignment_type === 'departamento') {
                // Asignación por DEPARTAMENTO: crear un registro por cada empleado del departamento
                foreach ($request->departamentos as $departamentoId) {
                    // Obtener todos los empleados activos del departamento
                    $empleados = User::whereHas('job', function($query) use ($departamentoId) {
                        $query->where('depto_id', $departamentoId);
                    })->where('active', 1)->get();
                    
                    foreach ($empleados as $empleado) {
                        // Verificar si ya existe esta asignación
                        $exists = ManagerApprover::where('employee_id', $empleado->id)
                            ->where('boss_id', $request->user_id)
                            ->exists();
                        
                        if (!$exists) {
                            ManagerApprover::create([
                                'boss_id' => $request->user_id,
                                'employee_id' => $empleado->id,
                                'departamento_id' => $departamentoId,
                                'is_active' => true,
                            ]);
                            $assigned++;
                        } else {
                            $skipped++;
                        }
                    }
                }
                $message = "Se asignaron {$assigned} empleado(s) a {$user->first_name} {$user->last_name} como jefe directo.";
            } else {
                // Asignación por USUARIO ESPECÍFICO
                foreach ($request->usuarios_especificos as $employeeId) {
                    $empleado = User::findOrFail($employeeId);
                    $departamentoId = $empleado->job->depto_id;
                    
                    $exists = ManagerApprover::where('employee_id', $employeeId)
                        ->where('boss_id', $request->user_id)
                        ->exists();
                    
                    if (!$exists) {
                        ManagerApprover::create([
                            'boss_id' => $request->user_id,
                            'employee_id' => $employeeId,
                            'departamento_id' => $departamentoId,
                            'is_active' => true,
                        ]);
                        $assigned++;
                    } else {
                        $skipped++;
                    }
                }
                $message = "Se asignaron {$assigned} usuario(s) específico(s) a {$user->first_name} {$user->last_name} como jefe directo.";
            }

            if ($skipped > 0) {
                $message .= " ({$skipped} ya estaban asignados)";
            }

            DB::commit();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error asignando jefe directo: ' . $e->getMessage());
            return back()->with('error', 'Error al asignar jefe directo: ' . $e->getMessage());
        }
    }

    /**
     * Activar/Desactivar una asignación específica.
     */
    public function toggle(Request $request, $id)
    {
        try {
            $approver = ManagerApprover::findOrFail($id);
            $approver->is_active = !$approver->is_active;
            $approver->save();

            $status = $approver->is_active ? 'activado' : 'desactivado';
            return back()->with('success', "Jefe directo {$status} correctamente.");

        } catch (\Exception $e) {
            Log::error('Error cambiando estado de jefe directo: ' . $e->getMessage());
            return back()->with('error', 'Error al cambiar estado: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una asignación.
     */
    public function destroy($id)
    {
        try {
            $approver = ManagerApprover::with(['user', 'departamento', 'employee'])->findOrFail($id);
            $userName = $approver->user->first_name . ' ' . $approver->user->last_name;
            $employeeName = $approver->employee->first_name . ' ' . $approver->employee->last_name;
            $deptName = $approver->departamento->name;
            
            $message = "Se eliminó la asignación de {$userName} para el empleado {$employeeName} (Depto: {$deptName}).";
            
            $approver->delete();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error eliminando jefe directo: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar asignaciones de un jefe directo.
     */
    public function update(Request $request, $bossId)
    {
        $request->validate([
            'new_boss_id' => 'required|exists:users,id',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $newBossId = $request->new_boss_id;
            $employeeIds = $request->employee_ids ?? [];

            $currentRecords = ManagerApprover::where('boss_id', $bossId)->get();
            $currentEmployeeIds = $currentRecords->pluck('employee_id')->toArray();

            // Eliminar empleados que ya no están en la lista
            $toRemove = array_diff($currentEmployeeIds, $employeeIds);
            if (!empty($toRemove)) {
                ManagerApprover::where('boss_id', $bossId)->whereIn('employee_id', $toRemove)->delete();
            }

            // Agregar nuevos empleados
            $toAdd = array_diff($employeeIds, $currentEmployeeIds);
            foreach ($toAdd as $empId) {
                $emp = User::with('job')->find($empId);
                if ($emp) {
                    ManagerApprover::create([
                        'boss_id' => $newBossId,
                        'employee_id' => $empId,
                        'departamento_id' => $emp->job->depto_id ?? null,
                        'is_active' => true,
                    ]);
                }
            }

            // Si cambió el jefe, actualizar registros restantes
            if ($bossId != $newBossId) {
                ManagerApprover::where('boss_id', $bossId)->update(['boss_id' => $newBossId]);
            }

            DB::commit();
            return back()->with('success', 'Asignaciones actualizadas correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error actualizando asignaciones: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar todas las asignaciones de un jefe directo.
     */
    public function destroyAll($bossId)
    {
        try {
            $boss = User::findOrFail($bossId);
            $count = ManagerApprover::where('boss_id', $bossId)->count();
            ManagerApprover::where('boss_id', $bossId)->delete();

            return back()->with('success', "Se eliminaron {$count} asignaciones de {$boss->first_name} {$boss->last_name}.");
        } catch (\Exception $e) {
            Log::error('Error eliminando asignaciones: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Obtener departamentos de un usuario en formato JSON.
     */
    public function getUserDepartments($userId)
    {
        $departments = ManagerApprover::where('boss_id', $userId)
            ->with('departamento')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'departamento_id' => $item->departamento_id,
                    'departamento_name' => $item->departamento->name,
                    'is_active' => $item->is_active,
                ];
            });

        return response()->json($departments);
    }
}

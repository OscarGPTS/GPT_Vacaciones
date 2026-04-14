<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectionApprover;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DirectionApproversController extends Controller
{
    /**
     * Mostrar el panel de gestión de aprobadores de dirección.
     */
    public function index()
    {
        // PASO 1: Obtener aprobadores SIN relaciones cross-database
        $approversRaw = DirectionApprover::orderBy('created_at', 'desc')->get();
        
        // PASO 2: Extraer IDs para queries separadas (evitar cross-database)
        $userIds = $approversRaw->pluck('boss_id')
            ->merge($approversRaw->pluck('employee_id'))
            ->unique()
            ->filter()
            ->values();
        $departamentoIds = $approversRaw->pluck('departamento_id')->unique()->filter()->values();
        
        // PASO 3: Cargar datos de la base de datos principal (mysql)
        $usersData = User::with('job')
            ->whereIn('id', $userIds)
            ->get()
            ->keyBy('id');
        $departamentosData = Departamento::whereIn('id', $departamentoIds)
            ->get()
            ->keyBy('id');
        
        // PASO 4: Mapear manualmente las relaciones
        $approversRaw->each(function($approver) use ($usersData, $departamentosData) {
            $approver->user = $usersData->get($approver->boss_id);
            $approver->employee = $usersData->get($approver->employee_id);
            $approver->departamento = $departamentosData->get($approver->departamento_id);
        });
        
        // Agrupar por boss_id
        $approvers = $approversRaw->groupBy('boss_id');
        
        // Obtener usuarios activos para el select
        $users = User::with('job')->where('active', 1)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Obtener todos los departamentos
        $departamentos = Departamento::orderBy('name')->get();
        
        return view('admin.direction-approvers.index', compact('approvers', 'users', 'departamentos'));
    }

    /**
     * Asignar un usuario como aprobador de dirección.
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
                        $exists = DirectionApprover::where('employee_id', $empleado->id)
                            ->where('boss_id', $request->user_id)
                            ->exists();
                        
                        if (!$exists) {
                            DirectionApprover::create([
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
                $message = "Se asignaron {$assigned} empleado(s) a {$user->first_name} {$user->last_name} como aprobador de dirección.";
            } else {
                // Asignación por USUARIO ESPECÍFICO
                foreach ($request->usuarios_especificos as $employeeId) {
                    $empleado = User::findOrFail($employeeId);
                    $departamentoId = $empleado->job->depto_id;
                    
                    $exists = DirectionApprover::where('employee_id', $employeeId)
                        ->where('boss_id', $request->user_id)
                        ->exists();
                    
                    if (!$exists) {
                        DirectionApprover::create([
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
                $message = "Se asignaron {$assigned} usuario(s) específico(s) a {$user->first_name} {$user->last_name} como aprobador de dirección.";
            }

            if ($skipped > 0) {
                $message .= " ({$skipped} ya estaban asignados)";
            }

            DB::commit();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error asignando aprobador de dirección: ' . $e->getMessage());
            return back()->with('error', 'Error al asignar aprobador: ' . $e->getMessage());
        }
    }

    /**
     * Activar/Desactivar una asignación específica.
     */
    public function toggle(Request $request, $id)
    {
        try {
            $approver = DirectionApprover::findOrFail($id);
            $approver->is_active = !$approver->is_active;
            $approver->save();

            $status = $approver->is_active ? 'activado' : 'desactivado';
            return back()->with('success', "Aprobador {$status} correctamente.");

        } catch (\Exception $e) {
            Log::error('Error cambiando estado de aprobador: ' . $e->getMessage());
            return back()->with('error', 'Error al cambiar estado: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una asignación.
     */
    public function destroy($id)
    {
        try {
            // Obtener approver SIN relaciones cross-database
            $approver = DirectionApprover::findOrFail($id);
            
            // Cargar datos manualmente de la base de datos principal
            $user = User::find($approver->boss_id);
            $employee = User::find($approver->employee_id);
            $departamento = Departamento::find($approver->departamento_id);
            
            $userName = $user ? ($user->first_name . ' ' . $user->last_name) : 'N/A';
            $employeeName = $employee ? ($employee->first_name . ' ' . $employee->last_name) : 'N/A';
            $deptName = $departamento ? $departamento->name : 'N/A';
            
            $message = "Se eliminó la asignación de {$userName} para el empleado {$employeeName} (Depto: {$deptName}).";
            
            $approver->delete();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error eliminando aprobador: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar asignaciones de un aprobador de dirección.
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

            $currentRecords = DirectionApprover::where('boss_id', $bossId)->get();
            $currentEmployeeIds = $currentRecords->pluck('employee_id')->toArray();

            // Eliminar empleados que ya no están en la lista
            $toRemove = array_diff($currentEmployeeIds, $employeeIds);
            if (!empty($toRemove)) {
                DirectionApprover::where('boss_id', $bossId)->whereIn('employee_id', $toRemove)->delete();
            }

            // Agregar nuevos empleados
            $toAdd = array_diff($employeeIds, $currentEmployeeIds);
            foreach ($toAdd as $empId) {
                $emp = User::with('job')->find($empId);
                if ($emp) {
                    DirectionApprover::create([
                        'boss_id' => $newBossId,
                        'employee_id' => $empId,
                        'departamento_id' => $emp->job->depto_id ?? null,
                        'is_active' => true,
                    ]);
                }
            }

            // Si cambió el jefe, actualizar registros restantes
            if ($bossId != $newBossId) {
                DirectionApprover::where('boss_id', $bossId)->update(['boss_id' => $newBossId]);
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
     * Eliminar todas las asignaciones de un aprobador.
     */
    public function destroyAll($bossId)
    {
        try {
            $boss = User::findOrFail($bossId);
            $count = DirectionApprover::where('boss_id', $bossId)->count();
            DirectionApprover::where('boss_id', $bossId)->delete();

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
        // NO usar with() - cross-database issue
        $approvers = DirectionApprover::where('boss_id', $userId)->get();
        
        // Cargar departamentos manualmente
        $departamentoIds = $approvers->pluck('departamento_id')->unique();
        $departamentosData = Departamento::whereIn('id', $departamentoIds)->get()->keyBy('id');
        
        $departments = $approvers->map(function($item) use ($departamentosData) {
            $dept = $departamentosData->get($item->departamento_id);
            return [
                'id' => $item->id,
                'departamento_id' => $item->departamento_id,
                'departamento_name' => $dept ? $dept->name : 'N/A',
                'is_active' => $item->is_active,
            ];
        });

        return response()->json($departments);
    }
}

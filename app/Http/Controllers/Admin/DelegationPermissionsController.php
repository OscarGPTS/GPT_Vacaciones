<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DelegationPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DelegationPermissionsController extends Controller
{
    /**
     * Mostrar el panel de gestión de permisos de delegación.
     */
    public function index()
    {
        $permissions = DelegationPermission::with(['user', 'user.job'])
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::with('job')
            ->where('active', 1)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('admin.delegation-permissions.index', compact('permissions', 'users'));
    }

    /**
     * Asignar permiso de delegación a uno o más usuarios.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $assigned = 0;
            $skipped = 0;

            foreach ($request->user_ids as $userId) {
                $exists = DelegationPermission::where('user_id', $userId)->exists();

                if (!$exists) {
                    DelegationPermission::create([
                        'user_id' => $userId,
                        'is_active' => true,
                    ]);
                    $assigned++;
                } else {
                    // Reactivar si estaba desactivado
                    $permission = DelegationPermission::where('user_id', $userId)->first();
                    if (!$permission->is_active) {
                        $permission->update(['is_active' => true]);
                        $assigned++;
                    } else {
                        $skipped++;
                    }
                }
            }

            $message = "Se asignó permiso de delegación a {$assigned} usuario(s).";
            if ($skipped > 0) {
                $message .= " ({$skipped} ya tenían el permiso)";
            }

            DB::commit();
            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error asignando permiso de delegación: ' . $e->getMessage());
            return back()->with('error', 'Error al asignar permiso: ' . $e->getMessage());
        }
    }

    /**
     * Activar/Desactivar un permiso de delegación.
     */
    public function toggle($id)
    {
        try {
            $permission = DelegationPermission::findOrFail($id);
            $permission->is_active = !$permission->is_active;
            $permission->save();

            $status = $permission->is_active ? 'activado' : 'desactivado';
            return back()->with('success', "Permiso de delegación {$status} correctamente.");

        } catch (\Exception $e) {
            Log::error('Error cambiando estado de permiso de delegación: ' . $e->getMessage());
            return back()->with('error', 'Error al cambiar estado: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un permiso de delegación.
     */
    public function destroy($id)
    {
        try {
            $permission = DelegationPermission::with('user')->findOrFail($id);
            $userName = $permission->user->first_name . ' ' . $permission->user->last_name;

            $permission->delete();
            return back()->with('success', "Se eliminó el permiso de delegación de {$userName}.");

        } catch (\Exception $e) {
            Log::error('Error eliminando permiso de delegación: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole('super-admin')) {
                abort(403, 'No tienes permisos para acceder a esta sección.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::with(['roles', 'permissions'])->where('active', 1)->get();

        return view('rrhh.admin.index', compact('roles', 'permissions', 'users'));
    }

    public function getUsersData()
    {
        $users = User::with(['roles', 'permissions', 'job'])
            ->where('active', 1)
            ->orderBy('first_name')
            ->get();

        return response()->json([
            'data' => $users->map(function($user) {
                return [
                    'id' => $user->id,
                    'nombre' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'puesto' => $user->job->nombre ?? 'N/A',
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'permissions' => $user->permissions->pluck('name')->toArray(),
                    'roles_html' => $user->roles->map(function($role) {
                        return '<span class="badge badge-primary mr-1">' . $role->name . '</span>';
                    })->join(''),
                    'permissions_html' => $user->permissions->map(function($permission) {
                        return '<span class="badge badge-info mr-1">' . $permission->name . '</span>';
                    })->join(''),
                ];
            })
        ]);
    }

    public function getUserRolesAndPermissions($userId)
    {
        $user = User::with(['roles', 'permissions'])->findOrFail($userId);
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'nombre' => $user->first_name . ' ' . $user->last_name,
                'roles' => $user->roles,
                'permissions' => $user->permissions
            ]
        ]);
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        
        $user->assignRole($role);

        return response()->json([
            'success' => true,
            'message' => "Rol '{$role->name}' asignado a {$user->first_name} {$user->last_name}"
        ]);
    }

    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        
        $user->removeRole($role);

        return response()->json([
            'success' => true,
            'message' => "Rol '{$role->name}' removido de {$user->first_name} {$user->last_name}"
        ]);
    }

    public function assignPermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $permission = Permission::findOrFail($request->permission_id);
        
        $user->givePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => "Permiso '{$permission->name}' asignado a {$user->first_name} {$user->last_name}"
        ]);
    }

    public function removePermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $permission = Permission::findOrFail($request->permission_id);
        
        $user->revokePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => "Permiso '{$permission->name}' removido de {$user->first_name} {$user->last_name}"
        ]);
    }

    // Gestión de Roles
    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);

        $role = Role::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => "Rol '{$role->name}' creado exitosamente",
            'role' => $role
        ]);
    }

    public function deleteRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::findOrFail($request->role_id);
        
        if ($role->name === 'super-admin') {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el rol super-admin'
            ], 403);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => "Rol '{$role->name}' eliminado exitosamente"
        ]);
    }

    public function assignPermissionToRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);
        
        $role->givePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => "Permiso '{$permission->name}' asignado al rol '{$role->name}'"
        ]);
    }

    public function removePermissionFromRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);
        
        $role->revokePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => "Permiso '{$permission->name}' removido del rol '{$role->name}'"
        ]);
    }

    // Gestión de Permisos
    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        $permission = Permission::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => "Permiso '{$permission->name}' creado exitosamente",
            'permission' => $permission
        ]);
    }

    public function deletePermission(Request $request)
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $permission = Permission::findOrFail($request->permission_id);
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => "Permiso '{$permission->name}' eliminado exitosamente"
        ]);
    }
}

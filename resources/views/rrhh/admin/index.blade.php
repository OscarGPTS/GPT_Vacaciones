@extends('layouts.codebase.master')

@section('content')
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <p>Administración de Roles y Permisos</p>
        </h3>
        <div class="block-options">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="fa fa-plus mr-1"></i> Nuevo Rol
            </button>
            <button type="button" class="btn btn-sm btn-success ml-2" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                <i class="fa fa-plus mr-1"></i> Nuevo Permiso
            </button>
        </div>
    </div>
    
    <div class="block-content">
        <ul class="nav nav-tabs nav-tabs-alt mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-tab-content" type="button" role="tab">
                    <i class="fa fa-fw fa-users mr-1"></i> Usuarios
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles-tab-content" type="button" role="tab">
                    <i class="fa fa-fw fa-user-tag mr-1"></i> Roles
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions-tab-content" type="button" role="tab">
                    <i class="fa fa-fw fa-key mr-1"></i> Permisos
                </button>
            </li>
        </ul>

        <div class="tab-content pt-4">
            <!-- Users Tab -->
            <div class="tab-pane fade show active" id="users-tab-content" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter" id="usersTable">
                        <thead>
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Puesto</th>
                                <th>Roles</th>
                                <th>Permisos Directos</th>
                                <th style="width: 150px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->id }}</td>
                                <td><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->job->nombre ?? 'N/A' }}</td>
                                <td>
                                    @if($user->roles->isNotEmpty())
                                    <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                        @foreach($user->roles as $role)
                                            <span style="background-color: rgb(87, 87, 87); color: white; border-radius: 5px; padding: 2px 5px; font-size: 12px; white-space: nowrap;">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Sin roles</span>
                                @endif
                                </td>
                                <td>
                                    @if($user->permissions->isNotEmpty())
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                            @foreach($user->permissions as $permission)
                                                <span style="background-color: rgb(87, 87, 87); color: white; border-radius: 5px; padding: 2px 5px; font-size: 12px; white-space: nowrap;">{{ $permission->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">Sin permisos</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="openUserModal({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}')">
                                        <i class="fa fa-edit"></i> Gestionar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Roles Tab -->
            <div class="tab-pane fade" id="roles-tab-content" role="tabpanel">
                <div class="row">
                    @foreach($roles as $role)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="block block-rounded border-3x {{ $role->name === 'super-admin' ? 'border-danger' : 'border-primary' }}">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">
                                    {{ $role->name }}
                                </h3>
                                <div class="block-options">
                                    
                                    @if($role->name !== 'super-admin')
                                        <button class="btn btn-sm btn-danger" onclick="deleteRole({{ $role->id }}, '{{ $role->name }}')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="block-content">
                                <p class="text-muted mb-2"><strong>Permisos asignados:</strong></p>
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach($role->permissions as $permission)
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge badge-success">{{ $permission->name }}</span>
                                            <button class="btn btn-xs btn-outline-danger" onclick="removePermissionFromRole({{ $role->id }}, {{ $permission->id }})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    @if($role->permissions->isEmpty())
                                        <p class="text-muted small">Sin permisos asignados</p>
                                    @endif
                                </div>
                                <hr>
                                <button class="btn btn-sm btn-block btn-primary" onclick="openRolePermissionsModal({{ $role->id }}, '{{ $role->name }}')">
                                    <i class="fa fa-plus mr-1"></i> Agregar Permisos
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Permissions Tab -->
            <div class="tab-pane fade" id="permissions-tab-content" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter" id="permissionsTable">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Nombre del Permiso</th>
                                <th>Guard</th>
                                <th style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td class="text-center">{{ $permission->id }}</td>
                                <td><strong>{{ $permission->name }}</strong></td>
                                <td>{{ $permission->guard_name }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger" onclick="deletePermission({{ $permission->id }}, '{{ $permission->name }}')">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal: Gestionar Usuario -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Usuario: <span id="userName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="selectedUserId">
                
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3"><i class="fa fa-user-tag mr-1"></i> Roles</h5>
                        <div class="form-group">
                            <label>Asignar Rol:</label>
                            <select class="form-control" id="roleSelect">
                                <option value="">Seleccionar rol...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-primary mt-2" onclick="assignRole()">
                                <i class="fa fa-plus mr-1"></i> Asignar Rol
                            </button>
                        </div>
                        <div id="userRoles" class="mt-3"></div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3"><i class="fa fa-key mr-1"></i> Permisos Directos</h5>
                        <div class="form-group">
                            <label>Asignar Permiso:</label>
                            <select class="form-control" id="permissionSelect">
                                <option value="">Seleccionar permiso...</option>
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-success mt-2" onclick="assignPermission()">
                                <i class="fa fa-plus mr-1"></i> Asignar Permiso
                            </button>
                        </div>
                        <div id="userPermissions" class="mt-3"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Crear Rol -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre del Rol:</label>
                    <input type="text" class="form-control" id="newRoleName" placeholder="Ej: editor, manager, etc.">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="createRole()">Crear Rol</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Crear Permiso -->
<div class="modal fade" id="createPermissionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre del Permiso:</label>
                    <input type="text" class="form-control" id="newPermissionName" placeholder="Ej: crear usuarios, editar posts, etc.">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="createPermission()">Crear Permiso</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Asignar Permisos a Rol -->
<div class="modal fade" id="rolePermissionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Permisos al Rol: <span id="roleName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="selectedRoleId">
                <div class="form-group">
                    <label>Seleccionar Permiso:</label>
                    <select class="form-control" id="rolePermissionSelect">
                        <option value="">Seleccionar permiso...</option>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="assignPermissionToRole()">Asignar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
let usersTable;
let userModalInstance;
let rolePermissionsModalInstance;

$(document).ready(function() {
    // Inicializar modales de Bootstrap 5
    const userModalElement = document.getElementById('userModal');
    if (userModalElement) {
        userModalInstance = new bootstrap.Modal(userModalElement);
    }
    
    const rolePermissionsModalElement = document.getElementById('rolePermissionsModal');
    if (rolePermissionsModalElement) {
        rolePermissionsModalInstance = new bootstrap.Modal(rolePermissionsModalElement);
    }
    
    // Inicializar DataTable de usuarios (usando datos del HTML)
    usersTable = $('#usersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        pageLength: 25,
        order: [[1, 'asc']]
    });
    
    $('#permissionsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        pageLength: 25
    });
});

function openUserModal(userId, userName) {
    $('#selectedUserId').val(userId);
    $('#userName').text(userName);
    
    // Cargar roles y permisos del usuario vía AJAX
    $.ajax({
        url: '{{ route("admin.user-roles-permissions", ":id") }}'.replace(':id', userId),
        method: 'GET',
        success: function(response) {
            const user = response.user;
            
            let rolesHtml = '';
            if (user.roles && user.roles.length > 0) {
                user.roles.forEach(role => {
                    rolesHtml += `
                        <div class="alert alert-primary d-flex justify-content-between align-items-center mb-2">
                            <span>${role.name}</span>
                            <button class="btn btn-sm btn-danger" onclick="removeRole(${userId}, ${role.id})">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    `;
                });
            } else {
                rolesHtml = '<p class="text-muted">Sin roles asignados</p>';
            }
            
            let permissionsHtml = '';
            if (user.permissions && user.permissions.length > 0) {
                user.permissions.forEach(permission => {
                    permissionsHtml += `
                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-2">
                            <span>${permission.name}</span>
                            <button class="btn btn-sm btn-danger" onclick="removePermission(${userId}, ${permission.id})">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    `;
                });
            } else {
                permissionsHtml = '<p class="text-muted">Sin permisos directos</p>';
            }
            
            $('#userRoles').html(rolesHtml);
            $('#userPermissions').html(permissionsHtml);
            
            // Abrir modal usando la instancia global
            if (userModalInstance) {
                userModalInstance.show();
            }
        },
        error: function() {
            alert('Error al cargar los datos del usuario');
        }
    });
}

function assignRole() {
    const userId = $('#selectedUserId').val();
    const roleId = $('#roleSelect').val();
    
    if (!roleId) {
        alert('Por favor selecciona un rol');
        return;
    }
    
    $.ajax({
        url: '{{ route("admin.assign-role") }}',
        method: 'POST',
        data: {
            user_id: userId,
            role_id: roleId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al asignar rol');
        }
    });
}

function removeRole(userId, roleId) {
    if (!confirm('¿Seguro que deseas remover este rol?')) return;
    
    $.ajax({
        url: '{{ route("admin.remove-role") }}',
        method: 'POST',
        data: {
            user_id: userId,
            role_id: roleId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al remover rol');
        }
    });
}

function assignPermission() {
    const userId = $('#selectedUserId').val();
    const permissionId = $('#permissionSelect').val();
    
    if (!permissionId) {
        alert('Por favor selecciona un permiso');
        return;
    }
    
    $.ajax({
        url: '{{ route("admin.assign-permission") }}',
        method: 'POST',
        data: {
            user_id: userId,
            permission_id: permissionId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al asignar permiso');
        }
    });
}

function removePermission(userId, permissionId) {
    if (!confirm('¿Seguro que deseas remover este permiso?')) return;
    
    $.ajax({
        url: '{{ route("admin.remove-permission") }}',
        method: 'POST',
        data: {
            user_id: userId,
            permission_id: permissionId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al remover permiso');
        }
    });
}

function createRole() {
    const name = $('#newRoleName').val();
    
    if (!name) {
        alert('Por favor ingresa el nombre del rol');
        return;
    }
    
    $.ajax({
        url: '{{ route("admin.create-role") }}',
        method: 'POST',
        data: {
            name: name,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al crear rol');
        }
    });
}

function deleteRole(roleId, roleName) {
    if (!confirm(`¿Seguro que deseas eliminar el rol '${roleName}'?`)) return;
    
    $.ajax({
        url: '{{ route("admin.delete-role") }}',
        method: 'POST',
        data: {
            role_id: roleId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert(xhr.responseJSON?.message || 'Error al eliminar rol');
        }
    });
}

function createPermission() {
    const name = $('#newPermissionName').val();
    
    if (!name) {
        alert('Por favor ingresa el nombre del permiso');
        return;
    }
    
    $.ajax({
        url: '{{ route("admin.create-permission") }}',
        method: 'POST',
        data: {
            name: name,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al crear permiso');
        }
    });
}

function deletePermission(permissionId, permissionName) {
    if (!confirm(`¿Seguro que deseas eliminar el permiso '${permissionName}'?`)) return;
    
    $.ajax({
        url: '{{ route("admin.delete-permission") }}',
        method: 'POST',
        data: {
            permission_id: permissionId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al eliminar permiso');
        }
    });
}

function openRolePermissionsModal(roleId, roleName) {
    $('#selectedRoleId').val(roleId);
    $('#roleName').text(roleName);
    if (rolePermissionsModalInstance) {
        rolePermissionsModalInstance.show();
    }
}

function assignPermissionToRole() {
    const roleId = $('#selectedRoleId').val();
    const permissionId = $('#rolePermissionSelect').val();
    
    if (!permissionId) {
        alert('Por favor selecciona un permiso');
        return;
    }
    
    $.ajax({
        url: '{{ route("admin.assign-permission-to-role") }}',
        method: 'POST',
        data: {
            role_id: roleId,
            permission_id: permissionId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al asignar permiso al rol');
        }
    });
}

function removePermissionFromRole(roleId, permissionId) {
    if (!confirm('¿Seguro que deseas remover este permiso del rol?')) return;
    
    $.ajax({
        url: '{{ route("admin.remove-permission-from-role") }}',
        method: 'POST',
        data: {
            role_id: roleId,
            permission_id: permissionId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            alert('Error al remover permiso del rol');
        }
    });
}
</script>
@endpush

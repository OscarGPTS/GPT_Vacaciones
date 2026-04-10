@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title mb-0 text-black">
                                <i class="fas fa-user-friends me-2"></i> Permisos de Delegación
                            </h3>
                            <small class="text-black d-block mt-1">
                                Gestiona qué usuarios pueden solicitar vacaciones en representación de otros
                            </small>
                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                            <i class="fas fa-plus me-1"></i> Agregar Usuario
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>¿Qué hace este módulo?</strong>
                        <p class="mb-0 mt-2">
                            Permite definir qué usuarios pueden crear solicitudes de vacaciones en representación de otro empleado.
                            Solo los usuarios listados aquí verán la opción "Solicitar en representación" al crear una solicitud.
                        </p>
                    </div>

                    @if($permissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Usuario</th>
                                        <th>Puesto</th>
                                        <th class="text-center" style="width: 120px;">Estado</th>
                                        <th class="text-center" style="width: 100px;">Fecha</th>
                                        <th class="text-center" style="width: 200px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $index => $permission)
                                        <tr>
                                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                         style="width: 35px; height: 35px; font-size: 0.9rem; font-weight: 600; flex-shrink: 0;">
                                                        {{ strtoupper(substr($permission->user->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($permission->user->last_name ?? '', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $permission->user->first_name ?? '' }} {{ $permission->user->last_name ?? '' }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($permission->user->job)
                                                    <small class="text-muted">{{ $permission->user->job->name }}</small>
                                                @else
                                                    <small class="text-muted">Sin puesto</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($permission->is_active)
                                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Activo</span>
                                                @else
                                                    <span class="badge bg-secondary"><i class="fas fa-times me-1"></i>Inactivo</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">{{ $permission->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('admin.delegation-permissions.toggle', $permission->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-{{ $permission->is_active ? 'warning' : 'success' }}" 
                                                                title="{{ $permission->is_active ? 'Desactivar' : 'Activar' }}">
                                                            <i class="fas fa-{{ $permission->is_active ? 'pause' : 'play' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.delegation-permissions.destroy', $permission->id) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Estás seguro de eliminar el permiso de {{ $permission->user->first_name }} {{ $permission->user->last_name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay permisos de delegación configurados</h5>
                            <p class="text-muted">Haz clic en "Agregar Usuario" para comenzar a asignar permisos.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Permiso -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-white">
            <form action="{{ route('admin.delegation-permissions.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Agregar Permiso de Delegación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Selecciona los usuarios que podrán solicitar vacaciones en representación de otros empleados.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-search me-1"></i> Buscar y seleccionar usuarios
                        </label>
                        <input type="text" id="searchUserInput" class="form-control mb-2" placeholder="Escriba para filtrar usuarios...">
                    </div>

                    <div style="max-height: 350px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px;">
                        @foreach($users as $user)
                            @php
                                $alreadyAssigned = $permissions->where('user_id', $user->id)->isNotEmpty();
                            @endphp
                            <div class="form-check py-1 px-3 user-item {{ $alreadyAssigned ? 'opacity-50' : '' }}" 
                                 data-name="{{ strtolower($user->first_name . ' ' . $user->last_name) }}"
                                 style="border-bottom: 1px solid #f0f0f0;">
                                <input class="form-check-input" type="checkbox" name="user_ids[]" value="{{ $user->id }}" 
                                       id="user_{{ $user->id }}" {{ $alreadyAssigned ? 'disabled' : '' }}>
                                <label class="form-check-label w-100 d-flex justify-content-between align-items-center" for="user_{{ $user->id }}">
                                    <span>
                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                        @if($user->job)
                                            <br><small class="text-muted">{{ $user->job->name }}</small>
                                        @endif
                                    </span>
                                    @if($alreadyAssigned)
                                        <span class="badge bg-secondary">Ya asignado</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('searchUserInput')?.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('.user-item').forEach(function(item) {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(filter) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection

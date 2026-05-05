<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="card-title mb-0 text-black">
                                    <i class="fas fa-user-check me-2"></i> 
                                    Solicitudes de Vacaciones - Jefe Directo
                                </h3>
                                <small class="text-black d-block mt-1 fs-5">Gestión de solicitudes de vacaciones como Jefe Directo</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(!$hasSignature)
                            <div class="alert alert-warning border-start border-warning border-4" role="alert">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-pen-nib fa-2x text-warning"></i>
                                    <div>
                                        <strong>Firma digital requerida</strong><br>
                                        Debes registrar tu firma digital antes de poder aprobar o rechazar solicitudes de vacaciones.
                                        <a href="{{ route('perfil.show') }}" class="alert-link ms-1">Ir a mi perfil para agregarla →</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Filtros Mejorados -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-3">
                                        <div class="row g-3 align-items-end">
                                            <!-- Búsqueda General -->
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    Búsqueda General
                                                </label>
                                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" 
                                                       placeholder="Buscar por nombre, motivo...">
                                            </div>

                                            <!-- Filtrar por Empleado -->
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    Filtrar por Empleado
                                                </label>
                                                <select wire:model.live="userFilter" class="form-select">
                                                    <option value="">Todos los empleados</option>
                                                    @foreach($this->users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->first_name }} {{ $user->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Filtrar por Departamento -->
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    Filtrar por Departamento
                                                </label>
                                                <select wire:model.live="departmentFilter" class="form-select">
                                                    <option value="">Todos los departamentos</option>
                                                    @foreach($this->departments as $department)
                                                        <option value="{{ $department->id }}">
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Botones de Acción -->
                                            <div class="col-md-3">
                                                <div class="d-grid gap-2">
                                                    <button wire:click="clearFilters" class="btn btn-outline-secondary">
                                                        <i class="fas fa-times me-1"></i> Limpiar Filtros
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Información de filtros activos -->
                                        @if($search || $userFilter || $departmentFilter)
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="alert alert-info mb-0 d-flex align-items-center">
                                                        <i class="fas fa-filter me-2"></i>
                                                        <span>
                                                            <strong>Filtros activos:</strong>
                                                            @if($search)
                                                                Búsqueda: "{{ $search }}"
                                                            @endif
                                                            @if($search && ($userFilter || $departmentFilter)) | @endif
                                                            @if($userFilter)
                                                                @php
                                                                    $selectedUser = $this->users->find($userFilter);
                                                                @endphp
                                                                Empleado: {{ $selectedUser ? $selectedUser->first_name . ' ' . $selectedUser->last_name : 'N/A' }}
                                                            @endif
                                                            @if($userFilter && $departmentFilter) | @endif
                                                            @if($departmentFilter)
                                                                @php
                                                                    $selectedDepartment = $this->departments->find($departmentFilter);
                                                                @endphp
                                                                Departamento: {{ $selectedDepartment ? $selectedDepartment->name : 'N/A' }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pestañas Mejoradas -->
                        <ul class="nav nav-pills nav-fill mb-4" id="directionTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $statusFilter === 'pending' ? 'active' : '' }} text-start" 
                                        wire:click="$set('statusFilter', 'pending')" type="button">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong>Pendientes por Aprobar</strong>
                                        </div>
                                        <span class="badge bg-light text-dark">{{ $this->pendingRequests->count() }}</span>
                                    </div>
                                    <small class="d-block mt-1">Solicitudes esperando tu aprobación como Jefe Directo</small>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $statusFilter === 'processed' ? 'active' : '' }} text-start" 
                                        wire:click="$set('statusFilter', 'processed')" type="button">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong>Aprobadas</strong>
                                        </div>
                                        <span class="badge bg-light text-dark">{{ $this->processedRequests->count() }}</span>
                                    </div>
                                    <small class="d-block mt-1">Solicitudes procesadas (aprobadas o rechazadas) por ti</small>
                                </button>
                            </li>
                        </ul>

                        <!-- Contenido de las Pestañas -->
                        <div class="tab-content">
                            @if($statusFilter === 'pending')
                                <!-- Pestaña de Pendientes -->
                                <div class="tab-pane fade show active">
                                    @if($this->pendingRequests->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap">
                                                            Empleado
                                                        </th>
                                                        <th class="text-nowrap">
                                                            Departamento
                                                        </th>
                                                        <th class="text-nowrap" style="cursor: pointer;" wire:click="sortBy('created_at')">
                                                            Fecha Solicitud
                                                            @if($sortField === 'created_at')
                                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                            @endif
                                                        </th>
                                                        <th class="text-nowrap">
                                                            Días Solicitados
                                                        </th>
                                                        <th class="text-nowrap">
                                                            Motivo
                                                        </th>
                                                        <th class="text-nowrap text-center">
                                                            Acciones
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:15px;">
                                                    @foreach($this->pendingRequests as $request)
                                                    <tr class="border-start border-light border-3">
                                                        <td>
                                                            <div>
                                                                <strong class="d-block">{{ $request->user->first_name }} {{ $request->user->last_name }}</strong>
                                                                @if($request->user->job)
                                                                    <small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($request->user->job && $request->user->job->departamento)
                                                                <span class="badge bg-light text-dark">
                                                                    {{ $request->user->job->departamento->name }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">Sin asignar</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <span class="d-block">{{ $request->created_at->format('d/m/Y') }}</span>
                                                                <small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <span class="badge bg-primary fs-6">
                                                                    {{ $request->requestDays->count() }} días
                                                                </span>
                                                                <div class="mt-2">
                                                                    @foreach($request->requestDays->sortBy('start') as $day)
                                                                        <small class="d-block text-muted">
                                                                            {{ \Carbon\Carbon::parse($day->start)->format('d/m/Y') }}
                                                                        </small>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $request->reason }}">
                                                                {{ Str::limit($request->reason, 50) }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                @if($hasSignature)
                                                                    <button type="button" 
                                                                            class="btn btn-success btn-sm" 
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#approveModal{{ $request->id }}">
                                                                        <i class="fas fa-check me-1"></i> Aprobar
                                                                    </button>
                                                                    <button type="button" 
                                                                            class="btn btn-danger btn-sm" 
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#rejectModal{{ $request->id }}">
                                                                        <i class="fas fa-times me-1"></i> Rechazar
                                                                    </button>
                                                                @else
                                                                    <button type="button" 
                                                                            class="btn btn-secondary btn-sm" 
                                                                            style="cursor:not-allowed;opacity:.6;"
                                                                            onclick="Swal.fire({icon:'warning',title:'Firma requerida',text:'Debes registrar tu firma digital antes de aprobar o rechazar solicitudes.',confirmButtonText:'Ir a mi perfil',showCancelButton:true,cancelButtonText:'Cerrar'}).then(r=>r.isConfirmed&&(window.location='{{ route('perfil.show') }}'))"
                                                                            title="Registra tu firma para poder aprobar">
                                                                        <i class="fas fa-lock me-1"></i> Aprobar
                                                                    </button>
                                                                    <button type="button" 
                                                                            class="btn btn-secondary btn-sm" 
                                                                            style="cursor:not-allowed;opacity:.6;"
                                                                            onclick="Swal.fire({icon:'warning',title:'Firma requerida',text:'Debes registrar tu firma digital antes de aprobar o rechazar solicitudes.',confirmButtonText:'Ir a mi perfil',showCancelButton:true,cancelButtonText:'Cerrar'}).then(r=>r.isConfirmed&&(window.location='{{ route('perfil.show') }}'))"
                                                                            title="Registra tu firma para poder rechazar">
                                                                        <i class="fas fa-lock me-1"></i> Rechazar
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <!-- Modales de Aprobación y Rechazo -->
                                            @foreach($this->pendingRequests as $request)
                                                <!-- Modal para Aprobar -->
                                                <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1" wire:ignore.self>
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title">
                                                                    <i class="fas fa-check-circle"></i> Aprobar Solicitud de Vacaciones - Jefe Directo
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body bg-white">
                                                                <div class="text-center mb-3">
                                                                    <i class="fas fa-user-check fa-3x text-success"></i>
                                                                </div>
                                                                <h6 class="text-center">¿Aprobar la solicitud de vacaciones?</h6>
                                                                
                                                                <div class="card border-success mt-3">
                                                                    <div class="card-body">
                                                                        <h6><strong>Empleado:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}</h6>
                                                                        @if($request->user->job)
                                                                            <p class="mb-2"><strong>Puesto:</strong> {{ $request->user->job->name }}</p>
                                                                        @endif
                                                                        @if($request->user->job && $request->user->job->departamento)
                                                                            <p class="mb-2"><strong>Departamento:</strong> {{ $request->user->job->departamento->name }}</p>
                                                                        @endif
                                                                        <p class="mb-2"><strong>Días:</strong> {{ $request->requestDays->count() }} días</p>
                                                                        @if($request->requestDays->count() > 0)
                                                                            <div class="mb-2">
                                                                                <strong>Días específicos:</strong>
                                                                                <ul class="mb-0 mt-1">
                                                                                    @foreach($request->requestDays->sortBy('start') as $day)
                                                                                        <li>{{ \Carbon\Carbon::parse($day->start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        @endif
                                                                        <p class="mb-0"><strong>Motivo:</strong> {{ $request->reason }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="alert alert-success mt-3">
                                                                    <i class="fas fa-info-circle"></i>
                                                                    <strong>Nota:</strong> Al aprobar, la solicitud será enviada automáticamente a Dirección para su revisión.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-white">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                    <i class="fas fa-times"></i> Cancelar
                                                                </button>
                                                                <button type="button" 
                                                                        class="btn btn-success" 
                                                                        wire:click="approveRequestDirect({{ $request->id }})"
                                                                        data-bs-dismiss="modal">
                                                                    <i class="fas fa-check"></i> Confirmar Aprobación
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal para Rechazar -->
                                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" wire:ignore.self>
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title">
                                                                    <i class="fas fa-times-circle"></i> Rechazar Solicitud de Vacaciones - Jefe Directo
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body bg-white">
                                                                <div class="text-center mb-3">
                                                                    <i class="fas fa-user-times fa-3x text-danger"></i>
                                                                </div>
                                                                <h6 class="text-center">¿Rechazar la solicitud de vacaciones?</h6>
                                                                
                                                                <div class="card border-danger mt-3">
                                                                    <div class="card-body">
                                                                        <h6><strong>Empleado:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}</h6>
                                                                        @if($request->user->job)
                                                                            <p class="mb-2"><strong>Puesto:</strong> {{ $request->user->job->name }}</p>
                                                                        @endif
                                                                        @if($request->user->job && $request->user->job->departamento)
                                                                            <p class="mb-2"><strong>Departamento:</strong> {{ $request->user->job->departamento->name }}</p>
                                                                        @endif
                                                                        <p class="mb-2"><strong>Días:</strong> {{ $request->requestDays->count() }} días</p>
                                                                        @if($request->requestDays->count() > 0)
                                                                            <div class="mb-2">
                                                                                <strong>Días específicos:</strong>
                                                                                <ul class="mb-0 mt-1">
                                                                                    @foreach($request->requestDays->sortBy('start') as $day)
                                                                                        <li>{{ \Carbon\Carbon::parse($day->start)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        @endif
                                                                        <p class="mb-0"><strong>Motivo:</strong> {{ $request->reason }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="alert alert-warning mt-3">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    <strong>Importante:</strong> Al rechazar, los días seleccionados serán liberados y el empleado será notificado del rechazo.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-white">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                    <i class="fas fa-arrow-left"></i> Cancelar
                                                                </button>
                                                                <button type="button" 
                                                                        class="btn btn-danger" 
                                                                        wire:click="rejectRequestDirect({{ $request->id }})"
                                                                        data-bs-dismiss="modal">
                                                                    <i class="fas fa-times"></i> Confirmar Rechazo
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if($this->pendingRequests->count() > 0)
                                                <div class="mt-3">
                                                    {{ $this->pendingRequests->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <div class="mb-4">
                                                <i class="fas fa-clipboard-check fa-4x text-muted"></i>
                                            </div>
                                            <h4 class="text-muted">No hay solicitudes pendientes</h4>
                                            <p class="text-muted">
                                                @if($search || $userFilter || $departmentFilter)
                                                    No hay solicitudes pendientes para los filtros seleccionados.
                                                @else
                                                    No hay solicitudes pendientes de revisión como Jefe Directo.
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Pestaña de Aprobadas -->
                                <div class="tab-pane fade show active">
                                    @if($this->processedRequests->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap">
                                                            Empleado
                                                        </th>
                                                        <th class="text-nowrap">
                                                            Departamento
                                                        </th>
                                                        <th class="text-nowrap" style="cursor: pointer;" wire:click="sortBy('created_at')">
                                                            Fecha Solicitud
                                                            @if($sortField === 'created_at')
                                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                            @endif
                                                        </th>
                                                        <th class="text-nowrap">
                                                            Días
                                                        </th>
                                                        <th class="text-nowrap">
                                                            Motivo
                                                        </th>
                                                        <th class="text-nowrap text-center" style="cursor: pointer;" wire:click="sortBy('updated_at')">
                                                            Fecha Aprobación
                                                            @if($sortField === 'updated_at')
                                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:15px;">
                                                    @foreach($this->processedRequests as $request)
                                                    <tr class="border-start border-success border-3">
                                                        <td>
                                                            <div>
                                                                <strong class="d-block">{{ $request->user->first_name }} {{ $request->user->last_name }}</strong>
                                                                @if($request->user->job)
                                                                    <small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($request->user->job && $request->user->job->departamento)
                                                                <span class="badge bg-light text-dark">
                                                                    {{ $request->user->job->departamento->name }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">Sin asignar</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <span class="d-block">{{ $request->created_at->format('d/m/Y') }}</span>
                                                                <small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <span class="badge bg-success fs-6">
                                                                    {{ $request->requestDays->count() }} días
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $request->reason }}">
                                                                {{ Str::limit($request->reason, 50) }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <span class="d-block">{{ $request->updated_at->format('d/m/Y') }}</span>
                                                                <small class="text-muted">{{ $request->updated_at->format('H:i') }}</small>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            @if($this->processedRequests->count() > 0)
                                                <div class="mt-3">
                                                    {{ $this->processedRequests->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <div class="mb-4">
                                                <i class="fas fa-history fa-4x text-muted"></i>
                                            </div>
                                            <h4 class="text-muted">No hay solicitudes aprobadas</h4>
                                            <p class="text-muted">
                                                @if($search || $userFilter || $departmentFilter)
                                                    No hay solicitudes aprobadas para los filtros seleccionados.
                                                @else
                                                    Aún no se han procesado solicitudes como Jefe Directo.
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Indicador de carga -->
                        <div wire:loading class="text-center py-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2 text-muted">Actualizando datos...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gradient-primary {
    background:#ffffff;
}

.nav-pills .nav-link {
    border-radius: 1rem;
    margin: 0 0.25rem;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.nav-pills .nav-link:not(.active) {
    background-color: #f8f9fa;
    color: #000000;
}

.nav-pills .nav-link:not(.active):hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    transform: translateY(-2px);
}

.nav-pills .nav-link.active {
    background-color: #e4e4e4;
    color: white;
    box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.15);
}

.table th {
    border-top: none;
    font-weight: 600;
    vertical-align: middle;
    background-color: rgba(var(--bs-warning-rgb), 0.1);
    position: sticky;
    top: 0;
    z-index: 10;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: scale(1.01);
    transition: all 0.2s ease;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    font-size: 0.875em;
}

.border-3 {
    border-width: 3px !important;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.table tbody tr {
    animation: fadeIn 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .nav-pills .nav-link {
        padding: 0.75rem 1rem;
        margin: 0.125rem;
    }
}
</style>
@endpush
</div>

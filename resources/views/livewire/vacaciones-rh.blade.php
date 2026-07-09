<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="card-title mb-0 text-black   ">
                                <i class="fas fa-user-tie me-2"></i> 
                                Solicitudes de Vacaciones - Recursos Humanos
                                </h3>
                                <small class="text-black d-block mt-1 fs-5">Gestión de solicitudes de vacaciones desde Recursos Humanos</small>
                            </div>


                            <div> 
                                <button wire:click="showAutoApprovalConfirm" class="btn btn-warning" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="showAutoApprovalConfirm">
                                        <i class="fas fa-robot me-1"></i> Procesar Auto-Aprobaciones
                                    </span>
                                    <span wire:loading wire:target="showAutoApprovalConfirm">
                                        <i class="fas fa-spinner fa-spin me-1"></i> Cargando...
                                    </span>
                                </button>
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
                                    <a href="{{ route('vacaciones.index') }}" class="alert-link ms-1">Ir a Firma Digital para agregarla →</a>
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
                    <ul class="nav nav-pills nav-fill mb-4" id="rhTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $statusFilter === 'pending' ? 'active' : '' }} text-start" 
                                    wire:click="$set('statusFilter', 'pending')" type="button">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <strong>Pendientes por Aprobar</strong>
                                    </div>
                                    <span class="badge bg-light text-dark">{{ $this->pendingRequests->count() }}</span>
                                </div>
                                <small class="d-block mt-1">Solicitudes esperando aprobación de RH</small>
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
                                <small class="d-block mt-1">Solicitudes ya procesadas por RH</small>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $statusFilter === 'tracking' ? 'active' : '' }} text-start"
                                    wire:click="$set('statusFilter', 'tracking')" type="button">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <strong>Seguimiento</strong>
                                    </div>
                                    <span class="badge bg-light text-dark">{{ $this->trackingRequests->count() }}</span>
                                </div>
                                <small class="d-block mt-1">Estado de las solicitudes en el flujo de aprobación</small>
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
                                                    <th class="text-nowrap">
                                                        Jefe Directo
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
                                                        Período de Vacaciones
                                                    </th>
                                                    <th class="text-nowrap">
                                                        Saldo del período
                                                    </th>
                                                    <th class="text-nowrap">
                                                        Motivo
                                                    </th>
                                                    <th class="text-nowrap">
                                                        Responsable
                                                    </th>
                                                    <th class="text-nowrap text-center">
                                                        Acciones RH
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 15px;">
                                                @foreach($this->pendingRequests as $request)
                                                <tr class="border-start border-light border-3">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            
                                                            <div>
                                                                <strong class="d-block">{{ $request->user->first_name }} {{ $request->user->last_name }}</strong>
                                                                @if($request->user->job)
                                                                    <small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($request->user->job && $request->user->job->departamento)
                                                            <span class="badge bg-light text-dark">
                                                                {{ $request->user->job->departamento->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-question-circle me-1"></i>Sin asignar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($request->user->boss_id)
                                                            @php
                                                                $boss = \App\Models\User::find($request->user->boss_id);
                                                            @endphp
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $boss->first_name ?? 'N/A' }} {{ $boss->last_name ?? '' }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-question-circle me-1"></i>Sin asignar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <span class=" d-block">{{ $request->created_at->format('d-m-Y') }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <span class="badge bg-warning text-dark mb-2">
                                                                {{ $request->requestDays->count() }} días
                                                            </span>
                                                            @if($request->requestDays->count() > 0)
                                                                <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                                                    @foreach ($request->requestDays as $day)
                                                                        <div class="small text-muted mb-2">
                                                                            {{ \Carbon\Carbon::parse($day->start)->format('d-m-Y') }} ,
                                                                        
                                                                        </div>
                                                                    @endforeach
                                                                   
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $vacationPeriod = $request->vacation_period;
                                                        @endphp
                                                        @if($vacationPeriod)
                                                            @php
                                                                $anniversaryDate = \Carbon\Carbon::parse($vacationPeriod->date_end);
                                                                $expirationDate = $anniversaryDate->copy()->addMonths(15);
                                                                $daysToExpire = \Carbon\Carbon::today()->diffInDays($expirationDate, false);
                                                            @endphp
                                                            <div>
                                                                <strong class="text-primary d-block">Período {{ $vacationPeriod->period }}</strong>
                                                                <small class="text-muted d-block">Aniversario: {{ $anniversaryDate->format('d/m/Y') }}</small>
                                                                <small class="text-muted d-block">Límite: {{ $expirationDate->format('d/m/Y') }}</small>
                                                                <small class="badge {{ $daysToExpire < 0 ? 'bg-danger' : ($daysToExpire <= 90 ? 'bg-warning text-dark' : 'bg-info text-dark') }} mt-1">
                                                                    {{ $daysToExpire < 0 ? 'Vencido' : 'Faltan ' . $daysToExpire . ' días' }}
                                                                </small>
                                                            </div>
                                                        @else
                                                            <span class="text-muted fst-italic">
                                                                No especificado
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($vacationPeriod)
                                                            @php
                                                                $diasSolicitados = $request->requestDays->count();
                                                                $saldoBase = (float) ($vacationPeriod->days_availables ?? 0);
                                                                $diasApartados = (float) ($vacationPeriod->days_reserved ?? 0);
                                                                $saldoProyectado = max(0, $saldoBase - $diasSolicitados);
                                                                $diasAntes = $request->requestDays->filter(function ($day) use ($vacationPeriod) {
                                                                    return \Carbon\Carbon::parse($day->start)->startOfDay()->lte(\Carbon\Carbon::parse($vacationPeriod->date_end)->startOfDay());
                                                                })->count();
                                                                $diasDespues = $diasSolicitados - $diasAntes;
                                                            @endphp
                                                            <div class="text-center small">
                                                                <div class="mb-1">
                                                                    <span class="badge bg-success">Disponibles: {{ number_format($saldoBase, 1) }}</span>
                                                                </div>
                                                          
                                                                <div class="mb-1">
                                                                    <span class="badge bg-primary">Tras aprobar quedarían: {{ number_format($saldoProyectado, 1) }}</span>
                                                                </div>
                                                                <div class="text-muted mt-1">
                                                                    <strong>Antes:</strong> {{ $diasAntes }} · <strong>Después:</strong> {{ $diasDespues }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <small class="text-muted">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Sin período asignado
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $request->reason }}">
                                                            {{ Str::limit($request->reason, 50) }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-info btn-sm" 
                                                                    wire:click="showDaysDetail({{ $request->id }})">
                                                                <i class="fas fa-eye me-1"></i> Ver Detalles
                                                            </button>
                                                            @if($hasSignature)
                                                                <button type="button" class="btn btn-success btn-sm" 
                                                                        wire:click="confirmApprove({{ $request->id }})">
                                                                    <i class="fas fa-check me-1"></i> Aprobar
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm" 
                                                                        wire:click="confirmReject({{ $request->id }})">
                                                                    <i class="fas fa-times me-1"></i> Rechazar
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                        style="cursor:not-allowed;opacity:.6;"
                                                                        onclick="Swal.fire({icon:'warning',title:'Firma requerida',text:'Debes registrar tu firma digital antes de aprobar o rechazar solicitudes.',confirmButtonText:'Ir a mi perfil',showCancelButton:true,cancelButtonText:'Cerrar'}).then(r=>r.isConfirmed&&(window.location='{{ route('perfil.show') }}'))"
                                                                        title="Registra tu firma para poder aprobar">
                                                                    <i class="fas fa-lock me-1"></i> Aprobar
                                                                </button>
                                                                <button type="button" class="btn btn-secondary btn-sm"
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
                                    </div>
                                    
                                    <!-- Paginación -->
                                    @if($this->pendingRequests->count() > 0)
                                        <div class="mt-3">
                                            {{ $this->pendingRequests->links() }}
                                        </div>
                                    @endif
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
                                                No hay solicitudes pendientes de aprobación por Recursos Humanos.
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @elseif($statusFilter === 'tracking')
                            <!-- Pestaña de Seguimiento -->
                            <div class="tab-pane fade show active">
                                @if($this->trackingRequests->count() > 0)
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
                                                    <th class="text-nowrap text-center">
                                                        Días
                                                    </th>
                                                    <th class="text-nowrap" style="min-width: 260px;">
                                                        Progreso de Aprobación
                                                    </th>
                                                    <th class="text-nowrap text-center">
                                                        Estado General
                                                    </th>
                                                    <th class="text-nowrap text-center">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 15px;">
                                                @foreach($this->trackingRequests as $request)
                                                @php
                                                    $jefe = $request->direct_manager_status;
                                                    $dir  = $request->direction_approbation_status;
                                                    $rh   = $request->human_resources_status;

                                                    $isCancelled = $rh === 'Cancelada';
                                                    $rejectedBy  = $jefe === 'Rechazada' ? 'Jefe Directo'
                                                                 : ($dir === 'Rechazada' ? 'Dirección'
                                                                 : ($rh === 'Rechazada' ? 'RH' : null));

                                                    // Estado de cada paso: done | current | rejected | waiting | cancelled
                                                    $stepJefe = $jefe === 'Aprobada' ? 'done'
                                                              : ($jefe === 'Rechazada' ? 'rejected'
                                                              : ($isCancelled ? 'cancelled' : 'current'));

                                                    $stepDir  = $dir === 'Aprobada' ? 'done'
                                                              : ($dir === 'Rechazada' ? 'rejected'
                                                              : ($isCancelled ? 'cancelled'
                                                              : ($stepJefe === 'done' ? 'current' : 'waiting')));

                                                    $stepRh   = $rh === 'Aprobada' ? 'done'
                                                              : ($rh === 'Rechazada' ? 'rejected'
                                                              : ($isCancelled ? 'cancelled'
                                                              : ($stepDir === 'done' ? 'current' : 'waiting')));

                                                    $stateText = function ($state) {
                                                        return [
                                                            'done'      => 'Aprobada',
                                                            'current'   => 'Pendiente de revisión',
                                                            'rejected'  => 'Rechazada',
                                                            'waiting'   => 'En espera',
                                                            'cancelled' => 'Cancelada',
                                                        ][$state] ?? '';
                                                    };

                                                    $steps = [
                                                        ['label' => 'Solicitud enviada', 'icon' => 'fa-paper-plane', 'state' => $isCancelled ? 'cancelled' : 'done',
                                                         'status' => $isCancelled ? 'Cancelada' : $request->created_at->format('d/m/Y H:i')],
                                                        ['label' => 'Jefe Directo', 'icon' => 'fa-user-tie',    'state' => $stepJefe, 'status' => $stateText($stepJefe)],
                                                        ['label' => 'Dirección',    'icon' => 'fa-building',    'state' => $stepDir,  'status' => $stateText($stepDir)],
                                                        ['label' => 'Recursos Humanos', 'icon' => 'fa-user-shield', 'state' => $stepRh, 'status' => $stateText($stepRh)],
                                                    ];
                                                @endphp
                                                <tr class="border-start border-light border-3">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <strong class="d-block">{{ $request->user->first_name ?? 'N/A' }} {{ $request->user->last_name ?? '' }}</strong>
                                                                @if($request->user && $request->user->job)
                                                                    <small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($request->user && $request->user->job && $request->user->job->departamento)
                                                            <span class="badge bg-light text-dark">
                                                                {{ $request->user->job->departamento->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-question-circle me-1"></i>Sin asignar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <span class="fw-bold d-block">{{ $request->created_at->format('d-m-Y') }}</span>
                                                            <small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary fs-6">{{ $request->requestDays->count() }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="v-stepper">
                                                            @foreach($steps as $step)
                                                                <div class="v-step step-{{ $step['state'] }}">
                                                                    <div class="v-step-indicator">
                                                                        <div class="v-step-circle">
                                                                            @if($step['state'] === 'done')
                                                                                <i class="fas fa-check"></i>
                                                                            @elseif($step['state'] === 'rejected')
                                                                                <i class="fas fa-times"></i>
                                                                            @elseif($step['state'] === 'cancelled')
                                                                                <i class="fas fa-ban"></i>
                                                                            @else
                                                                                <i class="fas {{ $step['icon'] }}"></i>
                                                                            @endif
                                                                        </div>
                                                                        @if(!$loop->last)
                                                                            <div class="v-step-line {{ $step['state'] === 'done' ? 'line-done' : '' }}"></div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="v-step-content">
                                                                        <div class="v-step-label">{{ $step['label'] }}</div>
                                                                        <div class="v-step-status">{{ $step['status'] }}</div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($isCancelled)
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-ban me-1"></i> Cancelada
                                                            </span>
                                                        @elseif($rejectedBy)
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times-circle me-1"></i> Rechazada por {{ $rejectedBy }}
                                                            </span>
                                                        @elseif($rh === 'Aprobada')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-double me-1"></i> Aprobada
                                                            </span>
                                                        @else
                                                            @php
                                                                $waitingOn = $stepJefe === 'current' ? 'Jefe Directo' : ($stepDir === 'current' ? 'Dirección' : 'RH');
                                                            @endphp
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-hourglass-half me-1"></i> Esperando {{ $waitingOn }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                                wire:click="showTrackingDetail({{ $request->id }})">
                                                            <i class="fas fa-tasks me-1"></i> Gestionar
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Paginación -->
                                    @if($this->trackingRequests->count() > 0)
                                        <div class="mt-3">
                                            {{ $this->trackingRequests->links() }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <i class="fas fa-route fa-4x text-muted"></i>
                                        </div>
                                        <h4 class="text-muted">No hay solicitudes para dar seguimiento</h4>
                                        <p class="text-muted">
                                            @if($search || $userFilter || $departmentFilter)
                                                No se encontraron solicitudes para los filtros seleccionados.
                                            @else
                                                Los usuarios aún no han registrado solicitudes de vacaciones.
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Pestaña de Procesadas -->
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
                                                        Días Solicitados
                                                    </th>
                                                    <th class="text-nowrap">
                                                        Período de Vacaciones
                                                    </th>
                                                    <th class="text-nowrap">
                                                        Motivo
                                                    </th>
                                                    <th class="text-nowrap">
                                                        Responsable
                                                    </th>
                                                    <th class="text-nowrap text-center">
                                                        <i class="fas fa-check-double me-1"></i> Estado RH
                                                    </th>
                                                    <th class="text-nowrap text-center" style="cursor: pointer;" wire:click="sortBy('updated_at')">
                                                        Fecha Procesado
                                                        @if($sortField === 'updated_at')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @endif
                                                    </th>
                                                    <th class="text-nowrap text-center">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 15px;">
                                                @foreach($this->processedRequests as $request)
                                                <tr class="border-start border-light border-3">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <strong class="d-block">{{ $request->user->first_name }} {{ $request->user->last_name }}</strong>
                                                                @if($request->user->job)
                                                                    <small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($request->user->job && $request->user->job->departamento)
                                                            <span class="badge bg-light text-dark">
                                                                {{ $request->user->job->departamento->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-question-circle me-1"></i>Sin asignar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <span class="fw-bold d-block">{{ $request->created_at->format('d-m-Y') }}</span>
                                                            <small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <span class="badge bg-{{ $request->human_resources_status == 'Aprobada' ? 'success' : 'danger' }} fs-6 mb-2">
                                                                {{ $request->requestDays->count() }} días
                                                            </span>
                                                            @if($request->requestDays->count() > 0)
                                                                <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">

                                                                @foreach ($request->requestDays as $day)
                                                                    <div class="small text-muted mb-2">
                                                                        {{ \Carbon\Carbon::parse($day->start)->format('d-m-Y') }} ,
                                                                    
                                                                    </div>
                                                                @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $vacationPeriod = $request->vacation_period;
                                                        @endphp
                                                        @if($vacationPeriod)
                                                            <div class="d-flex align-items-start">
                                                                <div>
                                                                    <small class="text-muted d-block">                                                                        
                                                                        {{ \Carbon\Carbon::parse($vacationPeriod->date_start)->format('d/m/Y') }} 
                                                                        - 
                                                                        {{ \Carbon\Carbon::parse($vacationPeriod->date_end)->format('d/m/Y') }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted fst-italic">
                                                                No especificado
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $request->reason }}">
                                                            {{ Str::limit($request->reason, 50) }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($request->human_resources_status == 'Aprobada')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-double me-1"></i> Aprobada por RH
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times-circle me-1"></i> Rechazada por RH
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <span class="fw-bold d-block">{{ $request->updated_at->format('d-m-Y') }}</span>
                                                            <small class="text-muted">{{ $request->updated_at->format('H:i') }}</small>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($request->human_resources_status == 'Aprobada')
                                                            <a href="{{ route('vacaciones.generar-pdf', $request->id) }}" 
                                                               class="btn btn-danger btn-sm" 
                                                               title="Descargar PDF de solicitud"
                                                               target="_blank">
                                                                <i class="fas fa-file-pdf me-1"></i> PDF
                                                            </a>
                                                        @else
                                                            <span class="text-muted small">
                                                                <i class="fas fa-ban me-1"></i> No disponible
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Paginación -->
                                    @if($this->processedRequests->count() > 0)
                                        <div class="mt-3">
                                            {{ $this->processedRequests->links() }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-4">
                                            <i class="fas fa-history fa-4x text-muted"></i>
                                        </div>
                                        <h4 class="text-muted">No hay solicitudes procesadas</h4>
                                        <p class="text-muted">
                                            @if($search || $userFilter || $departmentFilter)
                                                No hay solicitudes procesadas para los filtros seleccionados.
                                            @else
                                                Aún no se han procesado solicitudes desde Recursos Humanos.
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

    <!-- Modales -->
    @if($showDaysModal && $selectedRequest)
        @include('livewire.partials.rh-days-detail-modal')
    @endif

    @if($showTrackingModal && $selectedRequest)
        @php
            $tJefe = $selectedRequest->direct_manager_status;
            $tDir  = $selectedRequest->direction_approbation_status;
            $tRh   = $selectedRequest->human_resources_status;

            $tCancelled = $tRh === 'Cancelada';

            $tStepJefe = $tJefe === 'Aprobada' ? 'done'
                       : ($tJefe === 'Rechazada' ? 'rejected'
                       : ($tCancelled ? 'cancelled' : 'current'));

            $tStepDir  = $tDir === 'Aprobada' ? 'done'
                       : ($tDir === 'Rechazada' ? 'rejected'
                       : ($tCancelled ? 'cancelled'
                       : ($tStepJefe === 'done' ? 'current' : 'waiting')));

            $tStepRh   = $tRh === 'Aprobada' ? 'done'
                       : ($tRh === 'Rechazada' ? 'rejected'
                       : ($tCancelled ? 'cancelled'
                       : ($tStepDir === 'done' ? 'current' : 'waiting')));

            $tStateText = function ($state) {
                return [
                    'done'      => 'Aprobada',
                    'current'   => 'Pendiente de revisión — etapa actual',
                    'rejected'  => 'Rechazada',
                    'waiting'   => 'En espera',
                    'cancelled' => 'Cancelada',
                ][$state] ?? '';
            };

            $tSteps = [
                ['label' => 'Solicitud enviada', 'icon' => 'fa-paper-plane', 'state' => $tCancelled ? 'cancelled' : 'done',
                 'status' => $tCancelled ? 'Cancelada' : $selectedRequest->created_at->format('d/m/Y H:i')],
                ['label' => 'Jefe Directo', 'icon' => 'fa-user-tie',    'state' => $tStepJefe, 'status' => $tStateText($tStepJefe)],
                ['label' => 'Dirección',    'icon' => 'fa-building',    'state' => $tStepDir,  'status' => $tStateText($tStepDir)],
                ['label' => 'Recursos Humanos', 'icon' => 'fa-user-shield', 'state' => $tStepRh, 'status' => $tStateText($tStepRh)],
            ];

            $tCurrentStage = \App\Livewire\VacacionesRh::currentStageOf($selectedRequest);
            $tStageLabels  = ['manager' => 'Jefe Directo', 'direction' => 'Dirección', 'rh' => 'Recursos Humanos'];
            $tPeriod       = $selectedRequest->vacation_period;
        @endphp
        <div class="modal fade show" style="display: block; z-index: 1055;" tabindex="-1" role="dialog" aria-modal="true" wire:click="closeTrackingModal">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document" wire:click.stop>
                <div class="modal-content bg-white border-0 shadow">
                    <div class="modal-header" style="background:#eef2ff;">
                        <h5 class="modal-title" style="color:#3730a3;">
                            <i class="fas fa-route me-2"></i>
                            Seguimiento de Solicitud — {{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeTrackingModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            {{-- Detalles de la solicitud --}}
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-3" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;">
                                    <i class="fas fa-info-circle me-1"></i> Detalles
                                </h6>
                                <ul class="list-group list-group-flush small">
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-muted">Empleado</span>
                                        <strong>{{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-muted">Departamento</span>
                                        <strong>{{ $selectedRequest->user->job->departamento->name ?? 'Sin asignar' }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-muted">Tipo</span>
                                        <strong>{{ $selectedRequest->type_request }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-muted">Días solicitados</span>
                                        <strong>{{ $selectedRequest->requestDays->count() }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-muted">Período</span>
                                        <strong>{{ $tPeriod ? 'Período ' . $tPeriod->period : 'No especificado' }}</strong>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <span class="text-muted d-block mb-1">Días de vacaciones</span>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($selectedRequest->requestDays->sortBy('start') as $day)
                                                <span class="badge bg-light text-dark border">
                                                    {{ \Carbon\Carbon::parse($day->start)->format('d/m/Y') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            {{-- Stepper vertical de progreso --}}
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-3" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;">
                                    <i class="fas fa-shoe-prints me-1"></i> Progreso de Aprobación
                                </h6>
                                <div class="v-stepper v-stepper-lg">
                                    @foreach($tSteps as $step)
                                        <div class="v-step step-{{ $step['state'] }}">
                                            <div class="v-step-indicator">
                                                <div class="v-step-circle">
                                                    @if($step['state'] === 'done')
                                                        <i class="fas fa-check"></i>
                                                    @elseif($step['state'] === 'rejected')
                                                        <i class="fas fa-times"></i>
                                                    @elseif($step['state'] === 'cancelled')
                                                        <i class="fas fa-ban"></i>
                                                    @else
                                                        <i class="fas {{ $step['icon'] }}"></i>
                                                    @endif
                                                </div>
                                                @if(!$loop->last)
                                                    <div class="v-step-line {{ $step['state'] === 'done' ? 'line-done' : '' }}"></div>
                                                @endif
                                            </div>
                                            <div class="v-step-content">
                                                <div class="v-step-label">{{ $step['label'] }}</div>
                                                <div class="v-step-status">{{ $step['status'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if($tCurrentStage)
                            <div class="alert alert-info mt-3 mb-0 py-2" style="font-size:.85rem;">
                                <i class="fas fa-arrow-circle-right me-1"></i>
                                Etapa actual: <strong>{{ $tStageLabels[$tCurrentStage] }}</strong>.
                                Al avanzar, se ejecutará el mismo flujo de aprobación de esa etapa (asignaciones y notificaciones incluidas).
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeTrackingModal">Cerrar</button>
                        @if($tCurrentStage)
                            @if($hasSignature)
                                <button type="button" class="btn btn-danger"
                                        wire:click="confirmRejectTracking({{ $selectedRequest->id }})">
                                    <i class="fas fa-times me-1"></i> Rechazar ({{ $tStageLabels[$tCurrentStage] }})
                                </button>
                                <button type="button" class="btn btn-success"
                                        wire:click="confirmAdvance({{ $selectedRequest->id }})">
                                    <i class="fas fa-arrow-right me-1"></i> Avanzar: aprobar {{ $tStageLabels[$tCurrentStage] }}
                                </button>
                            @else
                                <span class="text-muted small">
                                    <i class="fas fa-lock me-1"></i> Registra tu firma digital para poder avanzar o rechazar solicitudes.
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(!$showDecisionModal)
            <div class="modal-backdrop fade show" style="z-index: 1050;"></div>
        @endif
    @endif

    @if($showDecisionModal && $selectedRequest)
        <div class="modal fade show rh-decision-modal" style="display: block; z-index: 1061;" tabindex="-1" role="dialog" aria-modal="true" wire:click="closeDecisionModal">
            <div class="modal-dialog rh-modal-dialog modal-dialog-centered" role="document" wire:click.stop>
                <div class="modal-content bg-white rh-modal-content border-0 shadow">
                    <div class="modal-header rh-modal-header flex align-items-arround {{ $decisionType === 'approve' ? 'rh-modal-header-success' : 'rh-modal-header-danger' }}">
                        <h5 class="modal-title">
                            <i class="fas {{ $decisionType === 'approve' ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
                            {{ $decisionType === 'approve' ? 'Confirmar aprobación' : 'Confirmar rechazo' }}
                            @if($decisionStage && $decisionStage !== 'rh')
                                — Etapa: {{ $decisionStage === 'manager' ? 'Jefe Directo' : 'Dirección' }}
                            @endif
                        </h5>

                    </div>
                    <div class="modal-body rh-modal-body">
                        @php
                            $requestedDaysModal = $selectedRequest->requestDays->count();
                            $requestPeriodModal = $selectedRequest->vacation_period;
                            $projectedDaysModal = $requestPeriodModal
                                ? max(0, ($requestPeriodModal->days_availables ?? 0) - $requestedDaysModal)
                                : null;

                            if ($decisionType === 'approve') {
                                $decisionText = [
                                    'manager'   => 'Al aprobar la etapa de Jefe Directo, la solicitud avanzará a Dirección y se notificará al aprobador correspondiente.',
                                    'direction' => 'Al aprobar la etapa de Dirección, la solicitud avanzará a Recursos Humanos para la aprobación final.',
                                ][$decisionStage] ?? 'Al aprobar, los días de esta solicitud se descontarán del período seleccionado del empleado.';
                            } else {
                                $decisionText = [
                                    'manager'   => 'Al rechazar en la etapa de Jefe Directo, los días reservados volverán a quedar disponibles y se notificará al empleado.',
                                    'direction' => 'Al rechazar en la etapa de Dirección, los días reservados volverán a quedar disponibles y se notificará al empleado.',
                                ][$decisionStage] ?? 'Al rechazar, los días reservados de esta solicitud volverán a quedar disponibles.';
                            }
                        @endphp

                        <p class="mb-3">{{ $decisionText }}</p>

                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Empleado</span>
                                <strong>{{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Días solicitados</span>
                                <strong>{{ $requestedDaysModal }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Período</span>
                                <strong>{{ $requestPeriodModal ? 'Período ' . $requestPeriodModal->period : 'No identificado' }}</strong>
                            </li>
                            @if($requestPeriodModal)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Saldo actual</span>
                                    <strong>{{ number_format($requestPeriodModal->days_availables ?? 0, 2) }} días</strong>
                                </li>
                            @endif
                        </ul>

                        @if($decisionType === 'approve' && ($decisionStage === 'rh' || !$decisionStage) && $projectedDaysModal !== null)
                            <div class="alert alert-success mt-3 mb-0">
                                <i class="fas fa-arrow-right me-1"></i>
                                Saldo proyectado del período después de aprobar: <strong>{{ number_format($projectedDaysModal, 2) }} días</strong>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer rh-modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDecisionModal">Cancelar</button>
                        <button type="button" class="btn {{ $decisionType === 'approve' ? 'btn-success' : 'btn-danger' }}"
                                wire:click="executeDecision"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="executeDecision">
                                {{ $decisionType === 'approve' ? 'Sí, aprobar' : 'Sí, rechazar' }}
                            </span>
                            <span wire:loading wire:target="executeDecision">Procesando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show rh-modal-backdrop" style="z-index: 1060;"></div>
    @endif
</div>

@push('styles')
<style>
.bg-gradient-primary {
    background:#ffffff;
}

/* ═══ Stepper vertical de seguimiento (estilo rastreo de pedido) ═════════ */
.v-stepper {
    display: flex;
    flex-direction: column;
    padding: .25rem 0;
}

.v-step {
    display: flex;
    align-items: flex-start;
    gap: .75rem;
}

.v-step-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
    align-self: stretch;
}

.v-step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .78rem;
    border: 2px solid #d1d5db;
    background: #f9fafb;
    color: #9ca3af;
    transition: all .3s ease;
    z-index: 1;
}

.v-stepper-lg .v-step-circle {
    width: 40px;
    height: 40px;
    font-size: .9rem;
}

.v-step-line {
    width: 3px;
    flex-grow: 1;
    min-height: 22px;
    background: #e5e7eb;
    border-radius: 2px;
    margin: 2px 0;
}

.v-stepper-lg .v-step-line {
    min-height: 30px;
}

.v-step-line.line-done {
    background: #198754;
}

.v-step-content {
    padding-bottom: 1rem;
    padding-top: .25rem;
    min-width: 0;
}

.v-step:last-child .v-step-content {
    padding-bottom: 0;
}

.v-step-label {
    font-size: .8rem;
    font-weight: 700;
    color: #9ca3af;
    line-height: 1.2;
}

.v-stepper-lg .v-step-label {
    font-size: .9rem;
}

.v-step-status {
    font-size: .72rem;
    color: #9ca3af;
    margin-top: .1rem;
}

.v-stepper-lg .v-step-status {
    font-size: .8rem;
}

/* Paso completado */
.v-step.step-done .v-step-circle {
    background: #198754;
    border-color: #198754;
    color: #fff;
}
.v-step.step-done .v-step-label {
    color: #198754;
}
.v-step.step-done .v-step-status {
    color: #157347;
}

/* Paso actual (en espera de acción) */
.v-step.step-current .v-step-circle {
    background: #fff8e1;
    border-color: #f59e0b;
    color: #b45309;
    animation: stepperPulse 1.6s ease-in-out infinite;
}
.v-step.step-current .v-step-label {
    color: #b45309;
}
.v-step.step-current .v-step-status {
    color: #b45309;
}

/* Paso rechazado */
.v-step.step-rejected .v-step-circle {
    background: #dc3545;
    border-color: #dc3545;
    color: #fff;
}
.v-step.step-rejected .v-step-label,
.v-step.step-rejected .v-step-status {
    color: #dc3545;
}

/* Paso cancelado */
.v-step.step-cancelled .v-step-circle {
    background: #e5e7eb;
    border-color: #9ca3af;
    color: #6b7280;
}
.v-step.step-cancelled .v-step-label,
.v-step.step-cancelled .v-step-status {
    color: #6b7280;
}

@keyframes stepperPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, .45); }
    50%      { box-shadow: 0 0 0 7px rgba(245, 158, 11, 0); }
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

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.9rem;
}

.btn-group-vertical .btn {
    margin-bottom: 0.25rem;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
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

.rh-modal-dialog {
    background: #ffffff !important;
    border-radius: 16px;
}

.rh-modal-content {
    background: #ffffff !important;
    opacity: 1 !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 16px;
    box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22) !important;
    overflow: hidden;
}

.rh-modal-header {
    background: #ffffff !important;
    border-bottom: 1px solid #e5e7eb !important;
    color: #0f172a !important;
}

.rh-modal-header .modal-title,
.rh-modal-header .modal-title * {
    color: #0f172a !important;
}

.rh-modal-close {
    width: 2rem;
    height: 2rem;
    border: 1px solid #cbd5e1;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    color: #0f172a !important;
    font-size: 1.35rem;
    line-height: 1;
    padding: 0;
    box-shadow: none;
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.rh-modal-close:hover {
    background: #e2e8f0;
    color: #0f172a !important;
    transform: scale(1.04);
}

.rh-modal-close:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.18);
}

.rh-modal-close span {
    display: inline-block;
    transform: translateY(-1px);
}

.rh-modal-header-success {
    background: #ffffff !important;
    box-shadow: inset 0 4px 0 #198754;
}

.rh-modal-header-danger {
    background: #ffffff !important;
    box-shadow: inset 0 4px 0 #dc3545;
}

.rh-modal-body,
.rh-modal-footer {
    background: #ffffff !important;
}

.rh-modal-footer {
    border-top: 1px solid #eef2f7;
    padding: 1rem 1.25rem;
}

.rh-modal-backdrop {
    background-color: rgba(15, 23, 42, 0.58) !important;
    opacity: 1 !important;
}

.rh-modal-shell .table th,
.rh-decision-modal .table th {
    position: static;
    top: auto;
}

.rh-modal-shell .card,
.rh-decision-modal .card {
    background: #ffffff !important;
    border: 1px solid #e9eef5 !important;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
}

.rh-modal-shell .card-header,
.rh-decision-modal .card-header {
    background: #f8fafc !important;
    color: #0f172a !important;
    border-bottom: 1px solid #e9eef5;
}

.rh-modal-shell .card-header *,
.rh-decision-modal .card-header * {
    color: #0f172a !important;
}

.rh-decision-modal .list-group-item {
    background: #ffffff !important;
    border-color: #e9eef5;
}

.rh-auto-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 1058;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: rgba(15, 23, 42, 0.58);
}

.rh-auto-modal-panel {
    width: min(680px, 100%);
    background: #ffffff !important;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22);
    overflow: hidden;
}

.rh-auto-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.25rem;
    color: #0f172a;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
}

.rh-auto-modal-body {
    background: #ffffff;
    padding: 1.25rem;
}

.rh-auto-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-top: 1px solid #eef2f7;
    background: #ffffff;
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
    
    .avatar-circle {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }
}
</style>
@endpush

<!-- Modal de Confirmación - Auto-Aprobación -->
@if($showAutoApprovalModal)
<div class="rh-auto-modal-overlay" wire:click="closeModal">
    <div class="rh-auto-modal-panel" wire:click.stop>
        <div class="rh-auto-modal-header">
            <div>
                <h5 class="mb-1"><i class="fas fa-robot me-2"></i>Confirmar Auto-Aprobación</h5>
                <small class="text-muted">Proceso asistido para solicitudes con más de 5 días pendientes.</small>
            </div>
            <button type="button" class="rh-modal-close" wire:click="closeModal" aria-label="Cerrar modal">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="rh-auto-modal-body">
            <p class="text-muted mb-3">
                Esta acción revisará automáticamente las solicitudes elegibles y avanzará el flujo según las reglas configuradas.
            </p>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body bg-white">
                    <h6 class="fw-bold mb-2">Criterios de procesamiento</h6>
                    <ul class="mb-0 text-muted">
                        <li>Solicitudes pendientes por más de 5 días</li>
                        <li>Solo se procesan solicitudes con supervisor asignado</li>
                        <li>Se registra la fecha de aprobación automática</li>
                        <li>RH solo avanza cuando la configuración lo permite</li>
                    </ul>
                </div>
            </div>

            <div class="alert alert-light border mb-0">
                <i class="fas fa-lightbulb text-warning me-1"></i>
                Consejo: usa esta opción al cierre del día para mantener la cola de aprobación al corriente.
            </div>
        </div>

        <div class="rh-auto-modal-footer">
            <button wire:click="closeModal" class="btn btn-outline-secondary">
                Cancelar
            </button>
            <button wire:click="processAutoApprovals" wire:loading.attr="disabled" class="btn btn-primary">
                <span wire:loading.remove wire:target="processAutoApprovals">Procesar Auto-Aprobaciones</span>
                <span wire:loading wire:target="processAutoApprovals">Procesando...</span>
            </button>
        </div>
    </div>
</div>
@endif

</div>

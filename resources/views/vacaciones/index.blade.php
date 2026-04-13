@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Mis Solicitudes de Vacaciones y Permisos</h3>
                        <a href="{{ route('vacaciones.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Nueva Solicitud
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Balance de Vacaciones - Compacto -->
                    @if($vacationPeriods->count() > 0)
                    <div class="alert alert-light border mb-3 py-2">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <strong>Balance de vacaciones:</strong>
                                <div class="mt-1">
                                    @foreach($vacationPeriods as $period)
                                        @if($period['available_days'] > 0)
                                            @php
                                                $daysText = $period['available_days'] === 1 ? 'día' : 'días';
                                                $dateStart = \Carbon\Carbon::parse($period['date_start'])->format('d/m/Y');
                                                $dateEnd = \Carbon\Carbon::parse($period['date_end'])->format('d/m/Y');
                                                $expirationDate = \Carbon\Carbon::parse($period['expiration_date'])->format('d/m/Y');
                                                $daysRemaining = abs($period['days_until_expiration']);
                                                
                                                // Determinar clase según urgencia
                                                if ($period['is_expired']) {
                                                    $daysClass = 'text-danger fw-bold';
                                                    $expirationClass = 'text-danger fw-bold';
                                                    $daysRemainingText = "(hace {$daysRemaining} días)";
                                                } elseif ($period['expires_soon']) {
                                                    $daysClass = 'text-warning fw-bold';
                                                    $expirationClass = 'text-warning fw-bold';
                                                    $daysRemainingText = "(faltan {$daysRemaining} días)";
                                                } else {
                                                    $daysClass = 'text-success fw-bold';
                                                    $expirationClass = '';
                                                    $daysRemainingText = "(faltan {$daysRemaining} días)";
                                                }
                                            @endphp
                                            <div class="mb-2">
                                                • Tienes 
                                                <span class="{{ $daysClass }}" title="Exactos: {{ $period['available_days_exact'] ?? $period['available_days'] }}">{{ $period['available_days'] }} {{ $daysText }}</span>
                                                del período 
                                                <strong>({{ $dateStart }} al {{ $dateEnd }})</strong>
                                                que vencen el día 
                                                <strong class="{{ $expirationClass }}">{{ $expirationDate }}</strong>
                                                <span class="{{ $expirationClass }}">{{ $daysRemainingText }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Pestañas -->
                    <ul class="nav nav-tabs mb-3" id="vacationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="my-requests-tab" data-bs-toggle="tab" data-bs-target="#my-requests" type="button" role="tab">
                                <i class="fas fa-user"></i> Mis Solicitudes
                                <span class="badge bg-primary ms-1">{{ $requests->count() }}</span>
                            </button>
                        </li>
                        @if(isset($canDelegate) && $canDelegate)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="behalf-requests-tab" data-bs-toggle="tab" data-bs-target="#behalf-requests" type="button" role="tab">
                                <i class="fas fa-user-friends"></i> Solicitudes en Representación
                                <span class="badge bg-info ms-1">{{ $behalfRequests->count() }}</span>
                            </button>
                        </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="vacationTabsContent">
                        <!-- Pestaña de Mis Solicitudes -->
                        <div class="tab-pane fade show active" id="my-requests" role="tabpanel">
                            <!-- Lista de Solicitudes -->
                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha Solicitud</th>
                                        <th>Tipo</th>
                                        <th>Días Solicitados</th>
                                        <th>Período de Vacaciones</th>
                                        <th>Rango de Días</th>
                                        <th>Estado Jefe</th>
                                        <th>Estado RH</th>
                                        <th>Estado General</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:15px;">
                                    @foreach($requests as $request)
                                    <tr>
                                        <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $request->type_request }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $request->requestDays->count() }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $vacationPeriod = $request->vacation_period;
                                            @endphp
                                            @if($vacationPeriod)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong class="text-primary">Período {{ $vacationPeriod->period }}</strong>
                                                        <br>
                                                        <small class="text-muted">
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
                                            @if($request->requestDays->count() > 0)
                                                <small>
                                                    {{ \Carbon\Carbon::parse($request->requestDays->min('start'))->format('d/m/Y') }}
                                                    al
                                                    {{ \Carbon\Carbon::parse($request->requestDays->max('start'))->format('d/m/Y') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->direct_manager_status === 'Pendiente')
                                                <span class="badge bg-warning">
                                                    Pendiente
                                                </span>
                                            @elseif($request->direct_manager_status === 'Aprobada')
                                                <span class="badge bg-success">
                                                    Aprobada
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Rechazada
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->direct_manager_status === 'Aprobada')
                                                @if($request->human_resources_status === 'Pendiente')
                                                    <span class="badge bg-warning">
                                                        Pendiente
                                                    </span>
                                                @elseif($request->human_resources_status === 'Aprobada')
                                                    <span class="badge bg-success">
                                                        Aprobada
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        Rechazada
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Pendiente</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->direct_manager_status === 'Aprobada' && $request->human_resources_status === 'Rechazada')
                                                <span class="badge bg-success">
                                                    Rechazada
                                                </span>
                                            @elseif($request->direct_manager_status === 'Rechazada' || $request->human_resources_status === 'Rechazada')
                                                <span class="badge bg-danger">
                                                    Rechazada
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    En proceso
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $request->id }}">
                                                <i class="fas fa-eye"></i> Ver Detalles
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if($requests->hasPages())
                                <div class="mt-3">
                                    {{ $requests->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            No tienes solicitudes de vacaciones registradas.
                            <a href="{{ route('vacaciones.create') }}" class="btn btn-primary btn-sm ms-2">
                                Crear primera solicitud
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pestaña de Solicitudes en Representación -->
            @if(isset($canDelegate) && $canDelegate)
            <div class="tab-pane fade" id="behalf-requests" role="tabpanel">
                @if($behalfRequests->count() > 0)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Solicitudes creadas por ti en representación de otros usuarios</strong>
                        <p class="mb-0 mt-2">Estas son las solicitudes que has creado para usuarios que no tienen acceso al sistema.</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-info">
                                <tr>
                                    <th>Usuario Representado</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Tipo</th>
                                    <th>Días Solicitados</th>
                                    <th>Período de Vacaciones</th>
                                    <th>Rango de Días</th>
                                    <th>Estado Jefe</th>
                                    <th>Estado RH</th>
                                    <th>Estado General</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($behalfRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $request->user->first_name ?? 'N/A' }} {{ $request->user->last_name ?? '' }}</strong>
                                                @if($request->user->job)
                                                    <br><small class="text-muted">{{ $request->user->job->name ?? '' }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        {{ $request->type_request }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary fs-6">{{ $request->requestDays->count() }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $vacationPeriod = $request->vacation_period;
                                        @endphp
                                        @if($vacationPeriod)
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong class="text-primary">Período {{ $vacationPeriod->period }}</strong>
                                                    <br>
                                                    <small class="text-muted">
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
                                        @if($request->requestDays->count() > 0)
                                            <small>
                                                {{ \Carbon\Carbon::parse($request->requestDays->min('start'))->format('d/m/Y') }}
                                                al
                                                {{ \Carbon\Carbon::parse($request->requestDays->max('start'))->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->direct_manager_status === 'Pendiente')
                                            <span class="badge bg-warning">
                                                Pendiente
                                            </span>
                                        @elseif($request->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">
                                                Aprobada
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Rechazada
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->direct_manager_status === 'Aprobada')
                                            @if($request->human_resources_status === 'Pendiente')
                                                <span class="badge bg-warning">
                                                    Pendiente
                                                </span>
                                            @elseif($request->human_resources_status === 'Aprobada')
                                                <span class="badge bg-success">
                                                    Aprobada
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Rechazada
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->direct_manager_status === 'Aprobada' && $request->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">
                                                Aprobada
                                            </span>
                                        @elseif($request->direct_manager_status === 'Rechazada' || $request->human_resources_status === 'Rechazada')
                                            <span class="badge bg-danger">
                                                Rechazada
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                En proceso
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailBehalfModal{{ $request->id }}">
                                            Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($behalfRequests->hasPages())
                            <div class="mt-3">
                                {{ $behalfRequests->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No has creado solicitudes en representación de otros usuarios.
                    </div>
                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modales para Mis Solicitudes -->
    @foreach($requests as $request)
        <div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i> 
                            Detalle de Mi Solicitud
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-file-alt text-warning"></i> Detalles de la Solicitud</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Tipo:</strong> {{ $request->type_request }}</li>
                                    <li><strong>Fecha Solicitud:</strong> {{ $request->created_at->format('d-m-Y H:i') }}</li>
                                    <li><strong>Forma de Pago:</strong> {{ $request->payment }}</li>
                                    @if($request->opcion)
                                        <li><strong>Opción:</strong> {{ $request->opcion }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-clipboard-check text-success"></i> Estados de Aprobación</h6>
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>Jefe Directo:</strong> 
                                        @if($request->direct_manager_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Recursos Humanos:</strong>
                                        @if($request->human_resources_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

                        <h6><i class="fas fa-calendar-days text-success"></i> Días Solicitados ({{ $request->requestDays->count() }} días)</h6>
                        <div class="row">
                            @foreach($request->requestDays->sortBy('start') as $day)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="card border-primary">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">
                                                {{ \Carbon\Carbon::parse($day->start)->format('d') }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($day->start)->format('M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-primary">
                                                {{ \Carbon\Carbon::parse($day->start)->locale('es')->dayName }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($request->reason)
                            <hr>
                            <h6><i class="fas fa-comment text-warning"></i> Motivo de la Solicitud</h6>
                            <div class="alert alert-light">
                                {{ $request->reason }}
                            </div>
                        @endif

                        @if($request->reveal)
                            <h6><i class="fas fa-user-shield text-secondary"></i> Responsable durante la Ausencia</h6>
                            <p>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</p>
                        @endif
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modales para Solicitudes en Representación -->
    @if(isset($canDelegate) && $canDelegate)
    @foreach($behalfRequests as $request)
        <div class="modal fade" id="detailBehalfModal{{ $request->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i> 
                            Detalle de Solicitud en Representación - {{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Solicitud creada en representación</strong>
                            <p class="mb-0 mt-2">Has creado esta solicitud para <strong>{{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}</strong></p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-user text-primary"></i> Información del Empleado Representado</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Nombre:</strong> {{ $request->user->first_name ?? 'N/A' }} {{ $request->user->last_name ?? '' }}</li>
                                    <li><strong>Email:</strong> {{ $request->user->email ?? 'N/A' }}</li>
                                    @if($request->user->job ?? false)
                                        <li><strong>Puesto:</strong> {{ $request->user->job->name ?? 'N/A' }}</li>
                                        <li><strong>Departamento:</strong> {{ $request->user->job->departamento->name ?? 'N/A' }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-file-alt text-warning"></i> Detalles de la Solicitud</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Tipo:</strong> {{ $request->type_request }}</li>
                                    <li><strong>Fecha Solicitud:</strong> {{ $request->created_at->format('d-m-Y H:i') }}</li>
                                    <li><strong>Forma de Pago:</strong> {{ $request->payment }}</li>
                                    <li><strong>Creada por:</strong> Tú</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6><i class="fas fa-clipboard-check text-success"></i> Estados de Aprobación</h6>
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>Jefe Directo:</strong> 
                                        @if($request->direct_manager_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->direct_manager_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </li>
                                    <li>
                                        <strong>Recursos Humanos:</strong>
                                        @if($request->human_resources_status === 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($request->human_resources_status === 'Aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @else
                                            <span class="badge bg-danger">Rechazada</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

                        <h6><i class="fas fa-calendar-days text-success"></i> Días Solicitados ({{ $request->requestDays->count() }} días)</h6>
                        <div class="row">
                            @foreach($request->requestDays->sortBy('start') as $day)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="card border-info">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">
                                                {{ \Carbon\Carbon::parse($day->start)->format('d') }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($day->start)->format('M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-info">
                                                {{ \Carbon\Carbon::parse($day->start)->locale('es')->dayName }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($request->reason)
                            <hr>
                            <h6><i class="fas fa-comment text-warning"></i> Motivo de la Solicitud</h6>
                            <div class="alert alert-light">
                                {{ $request->reason }}
                            </div>
                        @endif

                        @if($request->reveal)
                            <h6><i class="fas fa-user-shield text-secondary"></i> Responsable durante la Ausencia</h6>
                            <p>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</p>
                        @endif
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>
@endsection
@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-check"></i> 
                        Solicitudes de Vacaciones Pendientes de Aprobación
                    </h3>
                    <p class="card-subtitle text-muted">Como jefe directo, revisa y aprueba las solicitudes de tu equipo</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Empleado</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Tipo de Solicitud</th>
                                        <th>Días Solicitados</th>
                                        <th>Motivo</th>
                                        <th>Responsable</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
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
                                        <td>
                                            <span class="fw-bold">{{ $request->created_at->format('d-m-Y') }}</span>
                                            <br><small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $request->type_request }}</span>
                                            @if($request->payment)
                                                <br><small class="text-muted">{{ $request->payment }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $request->requestDays->count() }} días
                                            </span>
                                            @if($request->requestDays->count() > 0)
                                                <br><small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($request->requestDays->min('start'))->format('d-m-Y') }} 
                                                    al {{ \Carbon\Carbon::parse($request->requestDays->max('start'))->format('d-m-Y') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $request->reason }}">
                                                {{ Str::limit($request->reason, 50) }}
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-user-shield text-secondary me-1"></i>
                                            {{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical d-grid gap-1" role="group">
                                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $request->id }}">
                                                    <i class="fas fa-eye"></i> Detalle
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                                    <i class="fas fa-check"></i> Aprobar
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modales para cada solicitud -->
                        @foreach($requests as $request)

                                <!-- Modal para Ver Detalle -->
                                <div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title">
                                                    Detalle de Solicitud - {{ $request->user->first_name }} {{ $request->user->last_name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body bg-white">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Información del Empleado</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Nombre:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}</li>
                                                            <li><strong>Email:</strong> {{ $request->user->email }}</li>
                                                            @if($request->user->job)
                                                                <li><strong>Puesto:</strong> {{ $request->user->job->name ?? 'N/A' }}</li>
                                                                <li><strong>Departamento:</strong> {{ $request->user->job->departamento->name ?? 'N/A' }}</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Detalles de la Solicitud</h4>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Tipo:</strong> {{ $request->type_request }}</li>
                                                            <li><strong>Fecha Solicitud:</strong> {{ $request->created_at->format('d-m-Y H:i') }}</li>
                                                            <li><strong>Forma de Pago:</strong> {{ $request->payment }}</li>
                                                           
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

                                                <hr>

                                                <h6><i class="fas fa-comment text-warning"></i> Motivo de la Solicitud</h6>
                                                <div class="alert alert-light">
                                                    {{ $request->reason }}
                                                </div>

                                                <h6><i class="fas fa-user-shield text-secondary"></i> Responsable durante la Ausencia</h6>
                                                <p>{{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</p>

                                                @if($request->start || $request->end)
                                                    <h6><i class="fas fa-clock text-info"></i> Horario Específico</h6>
                                                    <p>
                                                        @if($request->start) <strong>Salida:</strong> {{ $request->start }} @endif
                                                        @if($request->end) <strong>Regreso:</strong> {{ $request->end }} @endif
                                                    </p>
                                                @endif

                                                @if($request->doc_permiso)
                                                    <h6><i class="fas fa-paperclip text-info"></i> Documentos Adjuntos</h6>
                                                    <p>
                                                        @foreach(explode(',', $request->doc_permiso) as $document)
                                                            <a href="{{ asset('storage/archivosPermisos/' . $document) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                                                <i class="fas fa-download"></i> {{ $document }}
                                                            </a>
                                                        @endforeach
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="modal-footer bg-white">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                                    <i class="fas fa-check"></i> Aprobar
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para Aprobar -->
                                <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('vacaciones.aprobar.action', $request->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="aprobar">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-check-circle"></i> Aprobar Solicitud de Vacaciones
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body bg-white">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-user-check fa-3x text-success"></i>
                                                    </div>
                                                    <h6 class="text-center">¿Aprobar la solicitud de vacaciones?</h6>
                                                    
                                                    <div class="card border-success mt-3">
                                                        <div class="card-body">
                                                            <h6><strong>Empleado:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}</h6>
                                                            <p><strong>Tipo:</strong> {{ $request->type_request }}</p>
                                                            <p><strong>Días:</strong> {{ $request->requestDays->count() }} días 
                                                                @if($request->requestDays->count() > 0)
                                                                    ({{ \Carbon\Carbon::parse($request->requestDays->min('start'))->format('d-m-Y') }} 
                                                                    al {{ \Carbon\Carbon::parse($request->requestDays->max('start'))->format('d-m-Y') }})
                                                                @endif
                                                            </p>
                                                            <p><strong>Responsable:</strong> {{ $request->reveal->first_name ?? 'N/A' }} {{ $request->reveal->last_name ?? '' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-success mt-3">
                                                        <i class="fas fa-info-circle"></i>
                                                        <strong>Nota:</strong> Al aprobar, la solicitud será enviada automáticamente a Dirección para su revisión y posterior aprobación.
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-white">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check"></i> Confirmar Aprobación
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para Rechazar -->
                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('vacaciones.aprobar.action', $request->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="rechazar">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-times-circle"></i> Rechazar Solicitud de Vacaciones
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body bg-white">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-user-times fa-3x text-danger"></i>
                                                    </div>
                                                    <h6 class="text-center">¿Rechazar la solicitud de vacaciones?</h6>
                                                    
                                                    <div class="card border-danger mt-3">
                                                        <div class="card-body">
                                                            <h6><strong>Empleado:</strong> {{ $request->user->first_name }} {{ $request->user->last_name }}</h6>
                                                            <p><strong>Tipo:</strong> {{ $request->type_request }}</p>
                                                            <p><strong>Días:</strong> {{ $request->requestDays->count() }} días 
                                                                @if($request->requestDays->count() > 0)
                                                                    ({{ \Carbon\Carbon::parse($request->requestDays->min('start'))->format('d-m-Y') }} 
                                                                    al {{ \Carbon\Carbon::parse($request->requestDays->max('start'))->format('d-m-Y') }})
                                                                @endif
                                                            </p>
                                                            <p><strong>Motivo:</strong> {{ Str::limit($request->reason, 100) }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-warning mt-3">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        <strong>Importante:</strong> Al rechazar, los días seleccionados serán liberados y el empleado deberá crear una nueva solicitud si lo desea.
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-white">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-left"></i> Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times"></i> Confirmar Rechazo
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-check fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No hay solicitudes pendientes</h4>
                            <p class="text-muted">Cuando tu equipo envíe solicitudes de vacaciones, aparecerán aquí para tu aprobación.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table {
    margin-bottom: 0;
}

.table th {
    border-top: none;
    font-weight: 600;
    vertical-align: middle;
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.075);
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
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

.modal-lg {
    max-width: 800px;
}

.card-title {
    color: #2c3e50;
}

.text-justify {
    text-align: justify;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-vertical .btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mejorar la experiencia de usuario con tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection

@endsection
<!-- Modal para Ver Días Específicos -->
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl bg-white" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Detalle de Solicitud y Períodos de Vacaciones
                    <span class="badge bg-warning text-dark ms-2">
                        <i class="fas fa-clock me-1"></i>
                        Pendiente de Aprobación RH
                    </span>
                </h5>
                <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <!-- Información básica de la solicitud -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6><i class="fas fa-user me-1"></i> <strong>Empleado:</strong></h6>
                        <p class="mb-0">{{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-calendar-plus me-1"></i> <strong>Tipo de Solicitud:</strong></h6>
                        <p class="mb-0">{{ $selectedRequest->type_request }}</p>
                    </div>
                    <div class="col-md-4">
                        @php
                            // Usar la misma lógica que el análisis para consistencia
                            $vacationsAvailableHeader = $selectedRequest->user->vacationsAvailable()->where('is_historical', false)->get();
                            $totalDaysAvailableHeader = 0;
                            $totalDaysEnjoyedHeader = 0;
                            
                            foreach ($vacationsAvailableHeader as $periodo) {
                                $diasDelPeriodoHeader = $periodo->days_availables ?? 0;
                                $diasDisfrutadosDelPeriodoHeader = $periodo->days_enjoyed ?? 0;
                                
                                $totalDaysAvailableHeader += $diasDelPeriodoHeader;
                                $totalDaysEnjoyedHeader += $diasDisfrutadosDelPeriodoHeader;
                            }
                            
                            $remainingDaysHeader = $totalDaysAvailableHeader - $totalDaysEnjoyedHeader;
                        @endphp
                        <h6><i class="fas fa-calendar-check me-1"></i> <strong>Resumen de Días:</strong></h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-calendar-check me-1"></i>
                                {{ number_format($remainingDaysHeader, 1) }} disponibles
                            </span>
                        </div>
                        <small class="text-muted">
                            Total: {{ number_format($totalDaysAvailableHeader, 1) }} | 
                            Usados: {{ number_format($totalDaysEnjoyedHeader, 1) }}
                        </small>
                    </div>
                </div>

                <!-- Sección de días solicitados -->
                <div class="card border-info mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-calendar-check me-1"></i> <strong>Días Específicos Solicitados</strong></h6>
                    </div>
                    <div class="card-body">
                        @if($selectedRequest->requestDays->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th><i class="fas fa-calendar me-1"></i> Fecha</th>
                                            <th><i class="fas fa-clock me-1"></i> Día de la Semana</th>
                                            <th><i class="fas fa-info-circle me-1"></i> Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($selectedRequest->requestDays->sortBy('start') as $index => $day)
                                            @php
                                                $dayDate = \Carbon\Carbon::parse($day->start);
                                                $dayNames = [
                                                    'Monday' => 'Lunes',
                                                    'Tuesday' => 'Martes', 
                                                    'Wednesday' => 'Miércoles',
                                                    'Thursday' => 'Jueves',
                                                    'Friday' => 'Viernes',
                                                    'Saturday' => 'Sábado',
                                                    'Sunday' => 'Domingo'
                                                ];
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $dayDate->format('d-m-Y') }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $dayNames[$dayDate->format('l')] ?? $dayDate->format('l') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        {{ $selectedRequest->type_request }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Total de días:</strong> {{ $selectedRequest->requestDays->count() }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-secondary">
                                        <i class="fas fa-calendar-week me-1"></i>
                                        <strong>Período:</strong> 
                                        {{ \Carbon\Carbon::parse($selectedRequest->requestDays->min('start'))->format('d-m-Y') }}
                                        al 
                                        {{ \Carbon\Carbon::parse($selectedRequest->requestDays->max('start'))->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                        $diasSolicitadosSection = $selectedRequest->requestDays->count();
                                        $diasRestantesDespuesSection = $remainingDaysHeader - $diasSolicitadosSection;
                                    @endphp
                                    @if($diasRestantesDespuesSection >= 0)
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            <strong>Quedarían:</strong> {{ number_format($diasRestantesDespuesSection, 1) }} días
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <strong>Déficit:</strong> {{ number_format(abs($diasRestantesDespuesSection), 1) }} días
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                No se encontraron días específicos para esta solicitud.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sección de todos los períodos de vacaciones -->
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Todos los Períodos de Vacaciones - {{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $allVacationPeriods = $selectedRequest->user->vacationsAvailable()->get();
                        @endphp
                        
                        @if($allVacationPeriods->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;" class="text-center">#</th>
                                            <th><i class="fas fa-calendar-day"></i> Período</th>
                                            <th><i class="fas fa-calendar-plus"></i> Ingreso</th>
                                            <th><i class="fas fa-calendar-minus"></i> Aniversario</th>
                                            <th><i class="fas fa-calendar-check"></i> Fecha Vencimiento</th>
                                            <th class="text-center"><i class="fas fa-calculator"></i> Días Acumulados</th>
                                            {{-- <th class="text-center"><i class="fas fa-plus-circle"></i> DV</th> ❌ ELIMINADO --}}
                                            <th class="text-center"><i class="fas fa-umbrella-beach"></i> Días Disfrutados</th>
                                            <th class="text-center"><i class="fas fa-chart-line"></i> Restantes</th>
                                            <th class="text-center"><i class="fas fa-tag"></i> Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allVacationPeriods as $index => $period)
                                            @php
                                                $remaining = $period->days_availables - $period->days_enjoyed;
                                            @endphp
                                            <tr>
                                                <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                                                <td><span class="badge bg-secondary">Período {{ $period->period ?? 'N/A' }}</span></td>
                                                <td>{{ $period->date_start ? \Carbon\Carbon::parse($period->date_start)->format('d/m/Y') : 'N/A' }}</td>
                                                <td>{{ $period->date_end ? \Carbon\Carbon::parse($period->date_end)->format('d/m/Y') : 'N/A' }}</td>
                                                <td>{{ $period->cutoff_date ? \Carbon\Carbon::parse($period->cutoff_date)->format('d/m/Y') : 'N/A' }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">{{ number_format($period->days_availables, 2) }}</span>
                                                </td>
                                                {{-- <td class="text-center">
                                                    <span class="badge bg-primary">{{ $period->dv ?? 0 }}</span>
                                                </td> ❌ ELIMINADO --}}
                                                <td class="text-center">
                                                    <span class="badge bg-success">{{ number_format($period->days_enjoyed, 2) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $remaining <= 0 ? 'bg-danger' : ($remaining <= 3 ? 'bg-warning text-dark' : 'bg-info') }}">
                                                        {{ number_format($remaining, 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($period->is_historical || (isset($period->status) && $period->status === 'vencido'))
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle"></i> Vencido
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle"></i> Vigente
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="5" class="text-end">TOTALES:</th>
                                            <th class="text-center">
                                                <span class="badge bg-info fs-6">
                                                    {{ number_format($allVacationPeriods->sum('days_availables'), 2) }}
                                                </span>
                                            </th>
                                            {{-- <th class="text-center">
                                                <span class="badge bg-primary fs-6">
                                                    {{ $allVacationPeriods->sum('dv') }}
                                                </span>
                                            </th> ❌ ELIMINADO --}}
                                            <th class="text-center">
                                                <span class="badge bg-success fs-6">
                                                    {{ number_format($allVacationPeriods->sum('days_enjoyed'), 2) }}
                                                </span>
                                            </th>
                                            <th class="text-center">
                                                <span class="badge bg-info fs-6">
                                                    {{ number_format($allVacationPeriods->sum('days_availables') - $allVacationPeriods->sum('days_enjoyed'), 2) }}
                                                </span>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Este empleado aún no tiene períodos de vacaciones calculados.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">
                        Cerrar
                    </button>
                    
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-danger" 
                                wire:click="rejectRequest"
                                wire:confirm="¿Está seguro de rechazar esta solicitud? Los días quedarán disponibles para el empleado.">
                            Rechazar
                        </button>
                        <button type="button" class="btn btn-success" 
                                wire:click="approveRequest"
                                wire:confirm="¿Está seguro de aprobar esta solicitud? Se descontarán los días de vacaciones del empleado.">
                            Aprobar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
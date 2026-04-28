@php
    $requestDays = $selectedRequest->requestDays->sortBy('start');
    $daysRequested = $requestDays->count();
    $today = \Carbon\Carbon::today();

    $requestPeriodNumber = null;
    $requestDateStart    = null;

    if (!empty($selectedRequest->opcion)) {
        $optionParts = explode('|', $selectedRequest->opcion);
        if (count($optionParts) === 2) {
            [$requestPeriodNumber, $requestDateStart] = $optionParts;
        }
    }

    $allVacationPeriods = $selectedRequest->user->vacationsAvailable()
        ->with('vacationPerYear')
        ->orderBy('date_end')
        ->get();

    // Solo períodos desbloqueados: date_end <= hoy <= cutoff_date
    $availablePeriods = $allVacationPeriods->filter(function ($period) use ($today) {
        if ($period->is_historical || (isset($period->status) && $period->status === 'vencido')) {
            return false;
        }
        $dateEnd = \Carbon\Carbon::parse($period->date_end);
        $cutoff  = !empty($period->cutoff_date)
            ? \Carbon\Carbon::parse($period->cutoff_date)
            : $dateEnd->copy()->addMonths(15);
        return $today->gte($dateEnd) && $today->lte($cutoff);
    });

    $selectedVacationPeriod = $allVacationPeriods->first(function ($period) use ($requestPeriodNumber, $requestDateStart) {
        return (string) $period->period === (string) $requestPeriodNumber
            && optional($period->date_start)->format('Y-m-d') === $requestDateStart;
    });

    $periodBalance    = $selectedVacationPeriod ? (float) $selectedVacationPeriod->days_availables : null;
    $projectedBalance = $periodBalance !== null ? max(0, $periodBalance - $daysRequested) : null;

    $periodYearLabel = $selectedVacationPeriod
        ? (\Carbon\Carbon::parse($selectedVacationPeriod->date_end)->year . '-' . (\Carbon\Carbon::parse($selectedVacationPeriod->date_end)->year + 1))
        : null;

    $expirationLimit = $selectedVacationPeriod
        ? (!empty($selectedVacationPeriod->cutoff_date)
            ? \Carbon\Carbon::parse($selectedVacationPeriod->cutoff_date)
            : \Carbon\Carbon::parse($selectedVacationPeriod->date_end)->addMonths(15))
        : null;

    $dayNames = [
        'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday'  => 'Jueves',
        'Friday'    => 'Viernes',
        'Saturday'  => 'Sábado',
        'Sunday'    => 'Domingo',
    ];

    $employee = $selectedRequest->user;
@endphp

<div class="modal fade show rh-modal-shell" style="display: block;" tabindex="-1" role="dialog" aria-modal="true" wire:click="closeModal">
    <div class="modal-dialog bg-white rh-modal-dialog modal-dialog-scrollable modal-xl" role="document" style="max-width: 95%;" wire:click.stop>
        <div class="modal-content rh-modal-content">

            {{-- HEADER --}}
            <div class="modal-header rh-modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Detalle de Solicitud y Períodos de Vacaciones
                    <span class="badge bg-warning text-dark ms-2">
                        <i class="fas fa-clock me-1"></i>
                        Pendiente de Aprobación RH
                    </span>
                </h5>
                <button type="button" class="rh-modal-close" wire:click="closeModal" aria-label="Cerrar modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body rh-modal-body">

                {{-- EMPLEADO + TIPO --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body py-3">
                                <h6 class="mb-1 text-muted"><i class="fas fa-user me-1"></i>Empleado</h6>
                                <p class="mb-0 fw-bold fs-6">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                <small class="text-muted">{{ $employee->job->name ?? 'Sin puesto' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body py-3">
                                <h6 class="mb-1 text-muted"><i class="fas fa-tag me-1"></i>Tipo de Solicitud</h6>
                                <p class="mb-0 fw-bold fs-6">{{ $selectedRequest->type_request }}</p>
                                <small class="text-muted">
                                    Creada: {{ \Carbon\Carbon::parse($selectedRequest->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3 MÉTRICAS CLAVE --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 text-center h-100" style="background:#e0f2fe;">
                            <div class="card-body py-3">
                                <div class="fs-2 fw-bold text-primary">{{ $daysRequested }}</div>
                                <small class="text-muted">Días solicitados</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 text-center h-100" style="background:{{ $projectedBalance !== null && $projectedBalance >= 0 ? '#dcfce7' : '#fef9c3' }};">
                            <div class="card-body py-3">
                                <div class="fs-2 fw-bold {{ $projectedBalance !== null && $projectedBalance >= 0 ? 'text-success' : 'text-warning' }}">
                                    {{ $projectedBalance !== null ? number_format($projectedBalance, 1) : 'N/D' }}
                                </div>
                                <small class="text-muted">Días que quedarían</small>
                                @if($periodBalance !== null)
                                    <div class="mt-1" style="font-size:.7rem; color:#6b7280;">
                                        Actual del período: {{ number_format($periodBalance, 1) }} días
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 text-center h-100" style="background:#faf5ff;">
                            <div class="card-body py-3">
                                @if($periodYearLabel)
                                    <div class="fs-4 fw-bold" style="color:#7c3aed;">{{ $periodYearLabel }}</div>
                                    <small class="text-muted">Período utilizado</small>
                                    @if($expirationLimit)
                                        <div class="mt-1" style="font-size:.7rem; color:#6b7280;">
                                            Válido hasta {{ $expirationLimit->format('d/m/Y') }}
                                        </div>
                                    @endif
                                @else
                                    <div class="fs-5 text-muted">N/D</div>
                                    <small class="text-muted">Período no identificado</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DÍAS SOLICITADOS --}}
                <div class="card border-0 mb-4" style="border: 1px solid #e5e7eb !important;">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-check me-1"></i>
                            <strong>Días Específicos Solicitados</strong>
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @if($requestDays->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:50px;">#</th>
                                            <th>Fecha</th>
                                            <th>Día</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requestDays as $index => $day)
                                            @php $dayDate = \Carbon\Carbon::parse($day->start); @endphp
                                            <tr>
                                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                                <td><strong>{{ $dayDate->format('d/m/Y') }}</strong></td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $dayNames[$dayDate->format('l')] ?? $dayDate->format('l') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0 rounded-0">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                No se encontraron días específicos para esta solicitud.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TABLA DE PERÍODOS (igual que expandible de vacaciones/reporte) --}}
                <div class="p-0">
                    <h5 class="mb-3">
                        <i class="fas fa-calendar-alt text-primary"></i>
                        Período del cual se descontarán los días de vacaciones — {{ $employee->first_name }} {{ $employee->last_name }}
                    </h5>

                    @if($availablePeriods->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:50px; background-color:#1e3a8a; color:white;" class="text-center">#</th>
                                        <th style="background-color:#1e3a8a; color:white;">Período</th>
                                        <th style="background-color:#9bc2e6; color:black;" class="text-center">Saldo Pendiente</th>
                                        <th style="background-color:#9ec89f; color:black;" class="text-center">Días Disfrutados<br>Antes de la Fecha<br>de Aniversario</th>
                                        <th style="background-color:#f4b6c2; color:black;" class="text-center">Días Disfrutados<br>Después de Fecha<br>de Aniversario</th>
                                        <th style="background-color:#9bc2e6; color:black;" class="text-center">Días Disfrutados</th>
                                        <th style="background-color:#1e3a8a; color:white;" class="text-center">Fecha Vencimiento</th>
                                        <th style="background-color:#1e3a8a; color:white;" class="text-center">Estado</th>
                                        <th style="background-color:#1e3a8a; color:white;" class="text-center">Impacto solicitud actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availablePeriods->values() as $index => $period)
                                        @php
                                            $expirationDate   = !empty($period->cutoff_date)
                                                ? \Carbon\Carbon::parse($period->cutoff_date)
                                                : \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                                            $daysUntilExpiration = $today->diffInDays($expirationDate, false);

                                            $yearLabel = 'N/D';
                                            if (!empty($employee->admission) && $employee->admission !== '0000-00-00' && $employee->admission !== '0000-00-00 00:00:00') {
                                                try {
                                                    $admissionDate  = \Carbon\Carbon::parse($employee->admission);
                                                    $periodStart    = \Carbon\Carbon::parse($period->date_start);
                                                    $seniorityYear  = $periodStart->diffInYears($admissionDate) + 1;
                                                    $yearLabel      = 'Año ' . max(1, $seniorityYear);
                                                } catch (\Exception $e) {
                                                    $yearLabel = 'N/D';
                                                }
                                            }

                                            $isExpiringSoon   = $daysUntilExpiration >= 0 && $daysUntilExpiration <= 90;
                                            $isRequestPeriod  = (string) $period->period === (string) $requestPeriodNumber
                                                && optional($period->date_start)->format('Y-m-d') === $requestDateStart;

                                            $projectedRowBalance = $isRequestPeriod
                                                ? max(0, (float) $period->days_availables - $daysRequested)
                                                : null;

                                            $endYr = \Carbon\Carbon::parse($period->date_end)->year;
                                        @endphp
                                        <tr class="{{ $isRequestPeriod ? 'table-warning' : '' }}">
                                            <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                                            <td>
                                                <span class="badge bg-dark">{{ $endYr }}-{{ $endYr + 1 }}</span>
                                                <br>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-calendar-check text-success me-1"></i>
                                                    <strong>Desde:</strong> {{ \Carbon\Carbon::parse($period->date_end)->format('d/m/Y') }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar-times text-danger me-1"></i>
                                                    <strong>Hasta:</strong> {{ $expirationDate->format('d/m/Y') }}
                                                </small>
                                                <small class="text-muted d-block" style="font-size:.68rem;">
                                                    ({{ \Carbon\Carbon::parse($period->date_end)->diffInMonths($expirationDate) }} meses para usar)
                                                </small>
                                            </td>
                                         
                                            <td class="text-center" style="background-color:#d9edf7;">
                                                <strong>{{ number_format($period->days_availables, 2) }}</strong>
                                            </td>
                                            <td class="text-center" style="background-color:#d4edda;">
                                                {{ number_format($period->days_enjoyed_before_anniversary ?? 0, 2) }}
                                            </td>
                                            <td class="text-center" style="background-color:#f8d7da;">
                                                {{ number_format($period->days_enjoyed_after_anniversary ?? 0, 2) }}
                                            </td>
                                            <td class="text-center" style="background-color:#d9edf7;">
                                                <strong>{{ number_format($period->days_enjoyed, 2) }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold {{ $isExpiringSoon ? 'text-warning' : 'text-muted' }}">
                                                    {{ $expirationDate->format('d/m/Y') }}
                                                </span>
                                                <small class="d-block {{ $isExpiringSoon ? 'text-warning' : 'text-muted' }}">
                                                    {{ $daysUntilExpiration === 0
                                                        ? 'Vence hoy'
                                                        : 'Faltan ' . $daysUntilExpiration . ' día(s)' }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                @if($isExpiringSoon)
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-exclamation-triangle"></i> Próximo a Vencer
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Vigente
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($isRequestPeriod)
                                                    <span class="badge bg-warning text-dark d-block mb-1">
                                                        <i class="fas fa-arrow-down me-1"></i>Esta solicitud
                                                    </span>
                                                    <small class="d-block text-danger">Se restan: {{ number_format($daysRequested, 2) }}</small>
                                                    <small class="d-block text-success fw-bold">Quedaría: {{ number_format($projectedRowBalance, 2) }}</small>
                                                @else
                                                    <span class="text-muted small">Sin impacto</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3" class="text-end">TOTALES (Solo Vigentes):</th>
                                        <th class="text-center" style="background-color:#b8bfc6;">
                                            <strong>{{ number_format($availablePeriods->sum(function ($p) { return $p->vacationPerYear->days ?? 0; }), 2) }}</strong>
                                        </th>
                                        <th class="text-center" style="background-color:#d9edf7;">
                                            <strong class="fs-6">{{ number_format($availablePeriods->sum('days_availables'), 2) }}</strong>
                                        </th>
                                        <th class="text-center" style="background-color:#d4edda;">
                                            <strong class="fs-6">{{ number_format($availablePeriods->sum('days_enjoyed_before_anniversary'), 2) }}</strong>
                                        </th>
                                        <th class="text-center" style="background-color:#f8d7da;">
                                            <strong class="fs-6">{{ number_format($availablePeriods->sum('days_enjoyed_after_anniversary'), 2) }}</strong>
                                        </th>
                                        <th class="text-center" style="background-color:#d9edf7;">
                                            <strong class="fs-6">{{ number_format($availablePeriods->sum('days_enjoyed'), 2) }}</strong>
                                        </th>
                                        <th colspan="3"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle"></i>
                            Este empleado no tiene períodos de vacaciones disponibles actualmente.
                        </div>
                    @endif
                </div>

            </div>

            <div class="modal-footer rh-modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">
                        Cerrar
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-danger" wire:click="confirmReject">
                            Rechazar
                        </button>
                        <button type="button" class="btn btn-success" wire:click="confirmApprove">
                            Aprobar
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal-backdrop fade show rh-modal-backdrop"></div>

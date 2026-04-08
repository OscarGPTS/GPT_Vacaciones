@php
    $requestDays = $selectedRequest->requestDays->sortBy('start');
    $daysRequested = $requestDays->count();

    $requestPeriodNumber = null;
    $requestDateStart = null;

    if (!empty($selectedRequest->opcion)) {
        $optionParts = explode('|', $selectedRequest->opcion);
        if (count($optionParts) === 2) {
            [$requestPeriodNumber, $requestDateStart] = $optionParts;
        }
    }

    $allVacationPeriods = $selectedRequest->user->vacationsAvailable()
        ->with('vacationPerYear')
        ->orderByDesc('date_end')
        ->orderByDesc('date_start')
        ->get();

    $selectedVacationPeriod = $allVacationPeriods->first(function ($period) use ($requestPeriodNumber, $requestDateStart) {
        return (string) $period->period === (string) $requestPeriodNumber
            && optional($period->date_start)->format('Y-m-d') === $requestDateStart;
    });

    $visibleBalance = $selectedVacationPeriod
        ? max(0, (float) $selectedVacationPeriod->days_availables - (float) ($selectedVacationPeriod->days_reserved ?? 0))
        : null;

    $projectedBalance = $selectedVacationPeriod
        ? max(0, (float) $selectedVacationPeriod->days_availables - $daysRequested)
        : null;

    $anniversaryDate = $selectedVacationPeriod?->date_end
        ? \Carbon\Carbon::parse($selectedVacationPeriod->date_end)->startOfDay()
        : null;

    $expirationLimit = $anniversaryDate
        ? $anniversaryDate->copy()->addMonths(15)->endOfDay()
        : null;

    $daysRemainingToExpire = $expirationLimit
        ? \Carbon\Carbon::today()->diffInDays($expirationLimit, false)
        : null;

    $requestDaysBeforeAnniversary = 0;
    $requestDaysAfterAnniversary = 0;
    $requestDaysOutOfWindow = 0;

    if ($anniversaryDate) {
        foreach ($requestDays as $requestDay) {
            $requestDate = \Carbon\Carbon::parse($requestDay->start)->startOfDay();

            if ($requestDate->lte($anniversaryDate)) {
                $requestDaysBeforeAnniversary++;
            } elseif ($expirationLimit && $requestDate->lte($expirationLimit)) {
                $requestDaysAfterAnniversary++;
            } else {
                $requestDaysOutOfWindow++;
            }
        }
    }

    $totalVisibleBalance = $allVacationPeriods
        ->where('is_historical', false)
        ->sum(function ($period) {
            return max(0, (float) $period->days_availables - (float) ($period->days_reserved ?? 0));
        });

    $totalUsed = $allVacationPeriods->sum('days_enjoyed');
    $totalReserved = $allVacationPeriods->sum('days_reserved');
@endphp

<div class="modal fade show rh-modal-shell" style="display: block;" tabindex="-1" role="dialog" aria-modal="true" wire:click="closeModal">
    <div class="modal-dialog bg-white rh-modal-dialog modal-dialog-scrollable modal-xl" role="document" style="max-width: 95%;" wire:click.stop>
        <div class="modal-content rh-modal-content">
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
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="mb-2"><i class="fas fa-user me-1"></i>Empleado</h6>
                                <p class="mb-1 fw-bold">{{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}</p>
                                <small class="text-muted">{{ $selectedRequest->user->job->name ?? 'Sin puesto' }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="mb-2"><i class="fas fa-calendar-plus me-1"></i>Solicitud</h6>
                                <p class="mb-1"><strong>{{ $selectedRequest->type_request }}</strong></p>
                                <small class="text-muted">
                                    {{ $daysRequested }} día(s) solicitados
                                    @if($requestPeriodNumber)
                                        · Período {{ $requestPeriodNumber }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="mb-2"><i class="fas fa-chart-pie me-1"></i>Resumen</h6>
                                <div class="mb-1">
                                    <span class="badge bg-success">{{ number_format($totalVisibleBalance, 2) }} disponibles</span>
                                    <span class="badge bg-secondary">{{ number_format($totalUsed, 2) }} usados</span>
                                </div>
                                <small class="text-muted">Apartados/pendientes: {{ number_format($totalReserved, 2) }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-info mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-check me-1"></i>
                            <strong>Días Específicos Solicitados</strong>
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($requestDays->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Fecha</th>
                                            <th>Día de la Semana</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requestDays as $index => $day)
                                            @php
                                                $dayDate = \Carbon\Carbon::parse($day->start);
                                                $dayNames = [
                                                    'Monday' => 'Lunes',
                                                    'Tuesday' => 'Martes',
                                                    'Wednesday' => 'Miércoles',
                                                    'Thursday' => 'Jueves',
                                                    'Friday' => 'Viernes',
                                                    'Saturday' => 'Sábado',
                                                    'Sunday' => 'Domingo',
                                                ];
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td><strong>{{ $dayDate->format('d-m-Y') }}</strong></td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $dayNames[$dayDate->format('l')] ?? $dayDate->format('l') }}
                                                    </span>
                                                </td>
                                                <td><span class="badge bg-primary">{{ $selectedRequest->type_request }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Total:</strong> {{ $daysRequested }} día(s)
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-secondary mb-0">
                                        <i class="fas fa-calendar-week me-1"></i>
                                        <strong>Rango:</strong>
                                        {{ \Carbon\Carbon::parse($requestDays->min('start'))->format('d-m-Y') }}
                                        al
                                        {{ \Carbon\Carbon::parse($requestDays->max('start'))->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert {{ $projectedBalance !== null && $projectedBalance >= 0 ? 'alert-success' : 'alert-warning' }} mb-0">
                                        <i class="fas fa-balance-scale me-1"></i>
                                        <strong>Saldo proyectado del período:</strong>
                                        {{ $projectedBalance !== null ? number_format($projectedBalance, 2) . ' días' : 'N/D' }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                No se encontraron días específicos para esta solicitud.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Todos los Períodos de Vacaciones - {{ $selectedRequest->user->first_name }} {{ $selectedRequest->user->last_name }}
                            </h6>
                            <small class="text-white-50">
                                Descuento en caso de aprobar la solicitud
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($allVacationPeriods->count() > 0)
                            <div class="alert alert-primary border-start border-4 border-primary">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <strong>Período origen:</strong><br>
                                        {{ $requestPeriodNumber ? 'Período ' . $requestPeriodNumber : 'No identificado' }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Fecha aniversario:</strong><br>
                                        {{ $anniversaryDate ? $anniversaryDate->format('d/m/Y') : 'N/D' }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Fecha límite para tomarlas:</strong><br>
                                        {{ $expirationLimit ? $expirationLimit->format('d/m/Y') : 'N/D' }}
                                        @if(!is_null($daysRemainingToExpire))
                                            <small class="d-block {{ $daysRemainingToExpire < 0 ? 'text-danger' : ($daysRemainingToExpire <= 90 ? 'text-warning' : 'text-muted') }}">
                                                {{ $daysRemainingToExpire < 0
                                                    ? 'Venció hace ' . abs($daysRemainingToExpire) . ' día(s)'
                                                    : 'Faltan ' . $daysRemainingToExpire . ' día(s)' }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Saldo visible actual:</strong><br>
                                        {{ $visibleBalance !== null ? number_format($visibleBalance, 2) . ' días' : 'N/D' }}
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-4">
                                        <strong>Descuento al aprobar:</strong>
                                        {{ number_format($daysRequested, 2) }} día(s)
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Antes del aniversario:</strong>
                                        {{ $requestDaysBeforeAnniversary }} día(s)
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Después del aniversario:</strong>
                                        {{ $requestDaysAfterAnniversary }} día(s)
                                    </div>
                                </div>
                                @if($requestDaysOutOfWindow > 0)
                                    <div class="mt-2 text-danger fw-semibold">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Hay {{ $requestDaysOutOfWindow }} día(s) fuera del plazo permitido de 12 + 3 meses desde el `end date`.
                                    </div>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px; background-color: #1e3a8a; color: white;" class="text-center">#</th>
                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Antigüedad</th>
                                            <th style="background-color: #1e3a8a; color: white;">Fecha de Aniversario</th>
                                            <th style="background-color: #b8bfc6; color: black;" class="text-center">Días de Vacaciones<br>Correspondientes<br>Período</th>
                                            <th style="background-color: #9bc2e6; color: black;" class="text-center">Saldo Pendiente</th>
                                            <th style="background-color: #9ec89f; color: black;" class="text-center">Días Disfrutados<br>Antes de la Fecha<br>de Aniversario</th>
                                            <th style="background-color: #f4b6c2; color: black;" class="text-center">Días Disfrutados<br>Después de Fecha<br>de Aniversario</th>
                                            <th style="background-color: #9bc2e6; color: black;" class="text-center">Días Disfrutados</th>
                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Fecha Vencimiento</th>
                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Estado</th>
                                            <th style="background-color: #1e3a8a; color: white;" class="text-center">Impacto solicitud actual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allVacationPeriods as $index => $period)
                                            @php
                                                $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                                                $today = \Carbon\Carbon::today();
                                                $daysUntilExpiration = $today->diffInDays($expirationDate, false);
                                                $yearLabel = 'N/D';

                                                if (!empty($selectedRequest->user->admission) && $selectedRequest->user->admission !== '0000-00-00' && $selectedRequest->user->admission !== '0000-00-00 00:00:00') {
                                                    try {
                                                        $admissionDate = \Carbon\Carbon::parse($selectedRequest->user->admission);
                                                        $periodStart = \Carbon\Carbon::parse($period->date_start);
                                                        $seniorityYear = $periodStart->diffInYears($admissionDate) + 1;
                                                        $yearLabel = 'Año ' . max(1, $seniorityYear);
                                                    } catch (\Exception $e) {
                                                        $yearLabel = 'N/D';
                                                    }
                                                }

                                                $isExpired = $daysUntilExpiration < 0 || $period->is_historical || (isset($period->status) && $period->status === 'vencido');
                                                $isExpiringSoon = !$isExpired && $daysUntilExpiration >= 0 && $daysUntilExpiration <= 90;
                                                $isRequestPeriod = (string) $period->period === (string) $requestPeriodNumber
                                                    && optional($period->date_start)->format('Y-m-d') === $requestDateStart;
                                                $projectedRowBalance = $isRequestPeriod
                                                    ? max(0, (float) $period->days_availables - $daysRequested)
                                                    : (float) $period->days_availables;
                                            @endphp
                                            <tr class="{{ $isRequestPeriod ? 'table-warning' : ($isExpired ? 'table-secondary text-muted' : '') }}" style="{{ $isExpired ? 'opacity: 0.6;' : '' }}">
                                                <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary">{{ $yearLabel }}</span>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($period->date_end)->format('d/m/Y') }}
                                                    <br>
                                                    <small class="text-muted">({{ \Carbon\Carbon::parse($period->date_start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->date_end)->format('d/m/Y') }})</small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary">{{ number_format($period->vacationPerYear->days ?? 0, 2) }}</span>
                                                </td>
                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#d9edf7' }};">
                                                    <strong>{{ number_format($period->days_availables, 2) }}</strong>
                                                </td>
                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#d4edda' }};">
                                                    {{ number_format($period->days_enjoyed_before_anniversary ?? 0, 2) }}
                                                </td>
                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#f8d7da' }};">
                                                    {{ number_format($period->days_enjoyed_after_anniversary ?? 0, 2) }}
                                                </td>
                                                <td class="text-center" style="background-color: {{ $isExpired ? '#e9ecef' : '#d9edf7' }};">
                                                    <strong>{{ number_format($period->days_enjoyed, 2) }}</strong>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="fw-bold {{ $isExpired ? 'text-danger' : ($isExpiringSoon ? 'text-warning' : 'text-muted') }}">
                                                            {{ $expirationDate->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @if($isExpired)
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle"></i> Vencido
                                                        </span>
                                                    @elseif($isExpiringSoon)
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
                                                        <small class="d-block text-muted">Apartados: {{ number_format($period->days_reserved ?? 0, 2) }}</small>
                                                        <small class="d-block text-danger">Se restan: {{ number_format($daysRequested, 2) }}</small>
                                                        <small class="d-block text-info">Antes aniversario: +{{ $requestDaysBeforeAnniversary }}</small>
                                                        <small class="d-block text-primary">Después aniversario: +{{ $requestDaysAfterAnniversary }}</small>
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
                                            @php
                                                $today = \Carbon\Carbon::today();
                                                $vigentePeriods = $allVacationPeriods->filter(function ($period) use ($today) {
                                                    $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                                                    $isExpired = $today->gt($expirationDate) || $period->is_historical || (isset($period->status) && $period->status === 'vencido');
                                                    return !$isExpired;
                                                });
                                            @endphp
                                            <th class="text-center" style="background-color: #b8bfc6;">
                                                <strong>{{ number_format($vigentePeriods->sum(function ($p) { return $p->vacationPerYear->days ?? 0; }), 2) }}</strong>
                                            </th>
                                            <th class="text-center" style="background-color: #d9edf7;">
                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_availables'), 2) }}</strong>
                                            </th>
                                            <th class="text-center" style="background-color: #d4edda;">
                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_enjoyed_before_anniversary'), 2) }}</strong>
                                            </th>
                                            <th class="text-center" style="background-color: #f8d7da;">
                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_enjoyed_after_anniversary'), 2) }}</strong>
                                            </th>
                                            <th class="text-center" style="background-color: #d9edf7;">
                                                <strong class="fs-6">{{ number_format($vigentePeriods->sum('days_enjoyed'), 2) }}</strong>
                                            </th>
                                            <th colspan="3"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle"></i>
                                Este empleado aún no tiene períodos de vacaciones calculados.
                            </div>
                        @endif
                    </div>
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

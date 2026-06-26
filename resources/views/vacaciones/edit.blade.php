@extends('layouts.codebase.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css" media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .btnCreate{
            width: 100%;
            color: white;
            padding: 10px;
        }
      
        .fc-day-grid-event .fc-time{
            display: none;
        }
        .fc-day-grid-event .fc-content{
            white-space: nowrap;
        }
        #calendar {
            /* Limitar el ancho para que no se vea desproporcionado a pantalla completa */
            max-width: 760px;
            margin: 0 auto;
            height: auto;
            min-height: 420px;
        }
        /* Encabezado del calendario alineado al mismo ancho centrado */
        .calendar-header {
            max-width: 760px;
            margin-left: auto;
            margin-right: auto;
        }
        #calendar .fc-toolbar h2 { font-size: 1.25rem; }
        #calendar .fc-day-grid-event { font-size: 0.8rem; }
        .fc-sun, .fc-sat {
            background-color: #f5f5f5 !important;
            color: #aaa !important;
        }
        .fc-day-header.fc-sun,
        .fc-day-header.fc-sat {
            background-color: #ececec !important;
            color: #bbb !important;
        }
        .fc-toolbar {
            margin-bottom: 1rem;
        }
        .fc-view-container {
            background: white;
        }
        .fc-event {
            border-radius: 3px;
            border: none;
        }
        .fc-day-top {
            padding: 5px;
        }
        .fc {
            direction: ltr;
            text-align: left;
        }
        .fc table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        
        .period-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px;
            background: white;
            position: relative;
            overflow: hidden;
        }
        .period-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }
        .period-card.selected {
            border-color: #007bff;
            background: #f0f7ff;
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.2);
        }
        .period-card.selected::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: #007bff;
        }
        .period-card.expired {
            opacity: 0.6;
            background: #f8f9fa;
        }
        .period-card.locked {
            opacity: 0.65;
            background: #f8f9fa;
            cursor: not-allowed;
        }
        .period-card.locked::after {
            content: '\f023';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: rgba(0, 0, 0, 0.08);
            pointer-events: none;
        }
        .period-card.expires-soon {
            border-color: #ffc107;
        }
        .period-card.expires-urgent {
            border-color: #dc3545;
            border-width: 2px;
        }
        .period-card.expires-urgent .period-badge {
            background: #f8d7da !important;
            color: #721c24 !important;
        }
        .period-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .period-badge.badge-green { background: #d4edda; color: #155724; }
        .period-badge.badge-blue  { background: #d1ecf1; color: #0c5460; }
        .period-badge.badge-yellow{ background: #fff3cd; color: #856404; }
        .period-days-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            line-height: 1;
        }
        .period-expiration {
            font-size: 0.75rem;
            margin-top: 6px;
        }
        .period-expiration.text-danger  { font-weight: 600; }
        .period-expiration.text-warning { font-weight: 600; }
        .period-check-icon {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 1.2rem;
            color: #007bff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .period-card.selected .period-check-icon { opacity: 1; }
        .period-counter {
            position: absolute;
            top: 8px;
            left: 8px;
            background: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: bold;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .period-days-remaining {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-top: 4px;
        }
        .period-days-remaining.urgent  { background: #dc3545; color: white; }
        .period-days-remaining.warning { background: #ffc107; color: #000; }
        .period-days-remaining.safe    { background: #e9ecef; color: #6c757d; }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3><i class="fas fa-edit me-2 text-warning"></i> Editar solicitud de vacaciones</h3>
                <a href="{{ route('vacaciones.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
     
        <div class="card-body">
            <div class="alert alert-warning d-flex align-items-center mb-3">
                <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                <div>
                    <strong>Editando solicitud #{{ $vacationRequest->id }}</strong> creada el {{ $vacationRequest->created_at->format('d/m/Y H:i') }}.
                    Solo puedes editar mientras la solicitud esté pendiente de aprobación.
                </div>
            </div>

            <div class="alert alert-info" id="vacationInfoAlert">
                <h5><i class="fa fa-info-circle"></i> Información de Vacaciones</h5>
                <p class="mb-0">Modifica los días seleccionados en el calendario. Recuerda:</p>
                <ul class="mb-0 mt-2" id="restrictionsList">
                    <li id="periodsInfoItem">Días disponibles: <strong id="availableDaysText">Calculando...</strong></li>
                    <li>Solicitar con al menos 5 días de anticipación</li>
                    <li id="antiquityItem">Requiere 1 año de antigüedad mínima (<span id="antiquityText">Verificando...</span>)</li>
                </ul>
            </div>

            <!-- Tarjetas de Selección de Períodos -->
            <div id="periodsSelectionPanel" style="display: none;" class="mb-3">
                <h6 class="mb-2"><i class="fas fa-calendar-check"></i> Selecciona el período de vacaciones</h6>
                <p class="text-muted small mb-2" style="font-size: 0.85rem;">
                    Elige el período del que deseas tomar tus vacaciones.
                </p>
                <div id="periodsCardsContainer" class="row g-2">
                    <!-- Las tarjetas se generarán dinámicamente aquí -->
                </div>
            </div>
        </div>

        <form action="{{ route('vacaciones.update', $vacationRequest->id) }}" method="POST" enctype="multipart/form-data" id="vacationForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="period" id="periodInput" value="">
            <input type="hidden" name="type_request" value="Vacaciones">

            <div class="row mx-3">
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3 d-flex align-items-center justify-content-between calendar-header">
                                <label for="days" class="mb-0">Selecciona los días que no te presentarás a la oficina</label>
                                <span class="badge bg-primary"><i class="fas fa-umbrella-beach me-1"></i> Vacaciones</span>
                            </div>
                            <div class="days" id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center px-3 py-3">
                <button type="submit" class="btnCreate bg-warning rounded-lg mt-4" name="submit" style="background-color:#e6a817;">
                    <i class="fas fa-save me-1"></i> Actualizar solicitud
                </button>
            </div>
        </form>
        </div>

    </div>


    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // ── Constantes ──────────────────────────────────────────────────
            const SITEURL = "{{ url('/') }}";
            let noworkingdays = @json($noworkingdays);

            // Datos de la solicitud que se está editando
            const existingDays       = @json($existingDays);           // [{id, title, start, end}, ...]
            const preSelectedPeriod  = @json($selectedPeriodData);     // {period: X, date_start: 'YYYY-MM-DD'} | null

            // Estado del período y días seleccionados
            let selectedPeriod = null;
            let selectedDaysByPeriod = {};

            let currentUserRestrictions = {
                maxDays: 32,
                availableDays: 0,
                meetsAntiquity: false,
                userName: 'tú',
                periods: []
            };

            const MAX_DAYS_PER_REQUEST = 32;

            // ── CSRF token para todas las peticiones AJAX ────────────────────
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ── Funciones de tracking por período ───────────────────────────
            function updatePeriodCounter(periodKey) {
                const periodData = selectedDaysByPeriod[periodKey];
                $('.period-card').each(function() {
                    const cardPeriod = JSON.parse($(this).attr('data-period'));
                    const cardPeriodKey = 'period_' + cardPeriod.period;
                    if (cardPeriodKey === periodKey) {
                        const counterElement = $(this).find('.period-counter');
                        const selectedCount  = periodData ? periodData.days.length : 0;
                        const totalAvailable = cardPeriod.available_days;
                        counterElement.text(`${selectedCount}/${totalAvailable}`);
                        if (selectedCount >= totalAvailable) {
                            counterElement.removeClass('text-success text-warning').addClass('text-danger');
                        } else if (selectedCount >= totalAvailable * 0.8) {
                            counterElement.removeClass('text-success text-danger').addClass('text-warning');
                        } else if (selectedCount > 0) {
                            counterElement.removeClass('text-warning text-danger').addClass('text-primary');
                        } else {
                            counterElement.removeClass('text-warning text-danger text-primary').addClass('text-success');
                        }
                    }
                });
            }

            function addDayToPeriod(date, periodInfo) {
                const periodKey = 'period_' + periodInfo.period;
                if (!selectedDaysByPeriod[periodKey]) {
                    selectedDaysByPeriod[periodKey] = {
                        period:      periodInfo.period,
                        period_name: periodInfo.period_name,
                        available_days: periodInfo.available_days,
                        date_start:  periodInfo.date_start,
                        date_end:    periodInfo.date_end,
                        days:  [],
                        dayIds: {}
                    };
                }
                if (!selectedDaysByPeriod[periodKey].days.includes(date)) {
                    selectedDaysByPeriod[periodKey].days.push(date);
                }
                updatePeriodCounter(periodKey);
            }

            function removeDayFromPeriod(date) {
                for (let periodKey in selectedDaysByPeriod) {
                    const index = selectedDaysByPeriod[periodKey].days.indexOf(date);
                    if (index > -1) {
                        selectedDaysByPeriod[periodKey].days.splice(index, 1);
                        if (selectedDaysByPeriod[periodKey].days.length === 0) {
                            delete selectedDaysByPeriod[periodKey];
                        }
                        updatePeriodCounter(periodKey);
                        break;
                    }
                }
            }

            function clearAllPeriods() {
                for (let periodKey in selectedDaysByPeriod) {
                    selectedDaysByPeriod[periodKey].days = [];
                    updatePeriodCounter(periodKey);
                }
                selectedDaysByPeriod = {};
            }

            // ── Limpiar al salir sin guardar ─────────────────────────────────
            $(window).on('beforeunload', function() {
                const selectedEvents = $('#calendar').fullCalendar('clientEvents');
                if (selectedEvents && selectedEvents.length > 0) {
                    $.ajax({
                        url: SITEURL + '/vacaciones/ajax',
                        type: 'POST',
                        async: false,
                        data: { type: 'delete_all', behalf_user_id: '{{ $vacationRequest->user_id }}', _token: '{{ csrf_token() }}' }
                    });
                }
            });

            // ── Cargar restricciones del usuario ────────────────────────────
            function loadUserRestrictions() {
                $.ajax({
                    url: "{{ route('vacaciones.get-user-restrictions') }}",
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', user_id: '{{ $vacationRequest->user_id }}' },
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            currentUserRestrictions = {
                                maxDays:        data.max_per_request.toFixed(2),
                                availableDays:  data.total_available,
                                meetsAntiquity: data.meets_antiquity,
                                userName:       data.user_name,
                                antiquityYears: data.antiquity_years,
                                antiquityMonths: data.antiquity_months,
                                periods:        data.periods || []
                            };

                            // ── Modo edición: pre-seleccionar período ────────
                            if (preSelectedPeriod && data.periods) {
                                const match = data.periods.find(p =>
                                    String(p.period) === String(preSelectedPeriod.period)
                                );
                                if (match) {
                                    selectedPeriod = match;
                                    $('#periodInput').val(match.period + '|' + match.date_start);

                                    // Pre-poblar selectedDaysByPeriod con los días ya cargados
                                    const periodKey = 'period_' + match.period;
                                    const existingStartDates = existingDays.map(d => d.start.substring(0, 10));
                                    selectedDaysByPeriod[periodKey] = {
                                        period:      match.period,
                                        period_name: match.period_name,
                                        available_days: match.available_days,
                                        date_start:  match.date_start,
                                        date_end:    match.date_end,
                                        days:  existingStartDates,
                                        dayIds: {}
                                    };

                                    // Actualizar color de los eventos ya renderizados
                                    const periodColors = { 1: '#28a745', 2: '#007bff', 3: '#ffc107' };
                                    const color = periodColors[match.period] || '#6c757d';
                                    calendar.fullCalendar('clientEvents').forEach(function(ev) {
                                        if (!ev.rendering) {
                                            calendar.fullCalendar('updateEvent', $.extend(ev, {
                                                color: color,
                                                title: 'Vacaciones - ' + match.period_name
                                            }));
                                        }
                                    });
                                }
                            }

                            updateRestrictionsUI();
                        } else {
                            $('#periodsInfoItem').html('Días disponibles: <strong class="text-danger">Error al cargar</strong>');
                            $('#antiquityText').text('Error al cargar');
                        }
                    },
                    error: function(xhr) {
                        $('#periodsInfoItem').html('Días disponibles: <strong class="text-danger">Error: ' + (xhr.status || 'desconocido') + '</strong>');
                        $('#antiquityText').text('Error al cargar');
                    }
                });
            }

            function updateRestrictionsUI() {
                const restrictions = currentUserRestrictions;

                // Máximo por solicitud: sumar SOLO los períodos disponibles ahora
                // (no vencidos y cuyo date_end ya pasó). Los bloqueados aún no se pueden
                // solicitar, por lo que no deben contarse en el máximo mostrado.
                const _maxToday = new Date(); _maxToday.setHours(0, 0, 0, 0);
                let _availableNow = 0;
                (restrictions.periods || []).forEach(function(p) {
                    if (p.is_expired) return;
                    const _end = new Date(p.date_end); _end.setHours(0, 0, 0, 0);
                    if (_end >= _maxToday) return; // bloqueado: aún no disponible
                    _availableNow += Math.floor(p.available_days);
                });
                const _maxPerRequest = Math.min(32, _availableNow);
                restrictions.maxDays = _maxPerRequest;
                $('#maxDaysText').text(_maxPerRequest);

                if (restrictions.periods && restrictions.periods.length > 0) {
                    let periodsHTML = '<div class="mt-1">';
                    restrictions.periods.forEach(function(period) {
                        const _infoEndDate = new Date(period.date_end);
                        _infoEndDate.setHours(0, 0, 0, 0);
                        const _infoToday = new Date(); _infoToday.setHours(0, 0, 0, 0);
                        if (_infoEndDate >= _infoToday) return;

                        const daysText = period.available_days === 1 ? 'día' : 'días';
                        const exactDays = period.available_days_exact ? ' (' + period.available_days_exact + ' exactos)' : '';
                        const formatDate = (dateStr) => { const [y,m,d] = dateStr.split('-'); return `${d}/${m}/${y}`; };
                        const dateStart = formatDate(period.date_start);
                        const dateEnd   = formatDate(period.date_end);
                        const daysRemaining = Math.abs(new Date(period.expiration_date.split('/').reverse().join('-')) - new Date()) / (1000 * 60 * 60 * 24);
                        let daysClass = '', expirationClass = '';
                        if (period.is_expired) {
                            daysClass = 'text-danger fw-bold'; expirationClass = 'text-danger fw-bold';
                        } else if (period.expires_soon) {
                            daysClass = 'text-warning fw-bold'; expirationClass = 'text-warning fw-bold';
                        } else {
                            daysClass = 'text-success fw-bold'; expirationClass = '';
                        }
                        let daysRemainingText = period.is_expired
                            ? '<span class="' + expirationClass + '">(hace ' + Math.floor(daysRemaining) + ' días)</span>'
                            : '<span class="' + expirationClass + '">(faltan ' + Math.floor(daysRemaining) + ' días)</span>';

                        periodsHTML += '<div class="mb-2">';
                        periodsHTML += '• Tienes <span class="' + daysClass + '" title="' + exactDays + '">' + period.available_days + ' ' + daysText + '</span>';
                        periodsHTML += ' del período <strong>' + period.period_name + '</strong>';
                        periodsHTML += ' <span class="text-muted" style="font-size:.8rem;">(' + dateStart + ' al ' + dateEnd + ')</span>';
                        periodsHTML += ' que vencen el <strong class="' + expirationClass + '">' + period.expiration_date + '</strong>';
                        periodsHTML += ' ' + daysRemainingText;
                        if (period.expires_soon) {
                            periodsHTML += ' <span class="badge bg-warning text-dark ms-1"><i class="fas fa-exclamation-triangle"></i> ¡Vence pronto!</span>';
                        }
                        periodsHTML += '</div>';
                    });
                    periodsHTML += '</div>';
                    $('#periodsInfoItem').html(periodsHTML);
                    renderPeriodCards(restrictions.periods);
                } else {
                    $('#periodsInfoItem').html('Días disponibles: <strong class="text-danger">0 días</strong>');
                    $('#periodsSelectionPanel').hide();
                }

                const antiquityYears  = restrictions.antiquityYears  || 0;
                const antiquityMonths = restrictions.antiquityMonths || 0;
                if (restrictions.meetsAntiquity) {
                    // Ya cumple el año de antigüedad: ocultar el recordatorio.
                    $('#antiquityItem').hide();
                } else {
                    const monthsText = antiquityMonths === 1 ? '1 mes' : antiquityMonths + ' meses';
                    $('#antiquityText').html('<span class="text-danger"><i class="fas fa-times-circle"></i> No cumple (' + monthsText + ')</span>');
                    $('#antiquityItem').show();
                }

                const alertBox = $('#vacationInfoAlert');
                if (!restrictions.meetsAntiquity || restrictions.availableDays <= 0) {
                    alertBox.removeClass('alert-info').addClass('alert-danger');
                } else if (restrictions.availableDays <= 5) {
                    alertBox.removeClass('alert-info alert-danger').addClass('alert-warning');
                } else {
                    alertBox.removeClass('alert-danger alert-warning').addClass('alert-info');
                }
            }

            // ── Renderizar tarjetas de períodos ──────────────────────────────
            function renderPeriodCards(periods) {
                if (!periods || periods.length === 0) {
                    $('#periodsSelectionPanel').hide();
                    return;
                }

                const container = $('#periodsCardsContainer');
                container.empty();

                const periodColors = {
                    1: { badge: 'badge-green',  color: '#28a745' },
                    2: { badge: 'badge-blue',   color: '#007bff' },
                    3: { badge: 'badge-yellow', color: '#ffc107' }
                };

                const today = new Date(); today.setHours(0, 0, 0, 0);

                periods.forEach(function(period) {
                    const colorScheme   = periodColors[period.period] || { badge: 'badge-secondary', color: '#6c757d' };
                    const isExpired     = period.is_expired;
                    const expiresSoon   = period.expires_soon;
                    const expiresUrgent = period.expires_urgent;
                    const periodEndDate = new Date(period.date_end); periodEndDate.setHours(0,0,0,0);
                    const isLocked      = periodEndDate >= today;

                    if (isLocked) return;

                    const dateStart = new Date(period.date_start).toLocaleDateString('es-MX', { day:'2-digit', month:'2-digit', year:'2-digit' });
                    const dateEnd   = new Date(period.date_end  ).toLocaleDateString('es-MX', { day:'2-digit', month:'2-digit', year:'2-digit' });

                    // ── En modo edición: respetar selectedPeriod ya establecido ──
                    const isPreSelected = selectedPeriod && String(selectedPeriod.period) === String(period.period);
                    let cardClass = 'period-card';

                    if (isPreSelected && !isLocked && !isExpired) {
                        cardClass += ' selected';
                        // Actualizar selectedPeriod con el objeto completo del servidor
                        selectedPeriod = period;
                    } else if (!selectedPeriod && !isLocked && !isExpired) {
                        // No había pre-selección: auto-seleccionar el primero disponible
                        cardClass += ' selected';
                        selectedPeriod = period;
                        $('#periodInput').val(period.period + '|' + period.date_start);
                    }

                    if (isExpired)    cardClass += ' expired';
                    if (isLocked)     cardClass += ' locked';
                    if (expiresUrgent && !isLocked && !isExpired) cardClass += ' expires-urgent';
                    else if (expiresSoon && !isLocked && !isExpired) cardClass += ' expires-soon';

                    let statusText = '', statusClass = '', daysRemainingBadge = '';
                    if (isExpired) {
                        statusText = '<i class="fas fa-times-circle"></i> Expirado';
                        statusClass = 'text-danger';
                        daysRemainingBadge = `<span class="period-days-remaining urgent"><i class="fas fa-ban"></i> Vencido</span>`;
                    } else {
                        const daysLeft = period.days_until_expiration;
                        if (expiresUrgent) {
                            statusText = `<i class="fas fa-exclamation-triangle"></i> ¡Prioritario!`;
                            statusClass = 'text-danger';
                            daysRemainingBadge = `<span class="period-days-remaining urgent"><i class="fas fa-hourglass-end"></i> ${daysLeft} días</span>`;
                        } else if (expiresSoon) {
                            statusText = `<i class="fas fa-exclamation-circle"></i> Próximo a vencer`;
                            statusClass = 'text-warning';
                            daysRemainingBadge = `<span class="period-days-remaining warning"><i class="fas fa-hourglass-half"></i> ${daysLeft} días</span>`;
                        } else {
                            statusText = `<i class="fas fa-check-circle"></i> Disponible`;
                            statusClass = 'text-success';
                            daysRemainingBadge = `<span class="period-days-remaining safe"><i class="fas fa-hourglass-start"></i> ${daysLeft} días</span>`;
                        }
                    }

                    // Contar días ya seleccionados para este período
                    const periodKey = 'period_' + period.period;
                    const alreadySelected = selectedDaysByPeriod[periodKey] ? selectedDaysByPeriod[periodKey].days.length : 0;

                    const cardHTML = `
                        <div class="col-md-4">
                            <div class="${cardClass}" data-period='${JSON.stringify(period)}' data-locked="${isLocked}" data-expired="${isExpired}">
                                <span class="period-counter text-${alreadySelected > 0 ? 'primary' : 'success'}">${alreadySelected}/${period.available_days}</span>
                                <i class="fas fa-check-circle period-check-icon"></i>
                                <div class="period-badge ${colorScheme.badge}">${period.period_name}</div>
                                <div class="period-days-text" style="color: ${colorScheme.color}">
                                    ${period.available_days}
                                    <span style="font-size: 0.85rem; color: #6c757d;">${period.available_days === 1 ? 'día' : 'días'}</span>
                                </div>
                                <div class="text-muted small mt-1" style="font-size: 0.65rem;">
                                    <i class="fas fa-calendar-alt"></i> ${dateStart} - ${dateEnd}
                                </div>
                                <div class="mt-1">${daysRemainingBadge}</div>
                                <div class="period-expiration ${statusClass} mt-1" style="font-size: 0.7rem;">${statusText}</div>
                            </div>
                        </div>
                    `;
                    container.append(cardHTML);
                });

                $('#periodsSelectionPanel').show();

                // Evento click en tarjetas
                $('.period-card').off('click').on('click', function() {
                    if ($(this).attr('data-locked') === 'true') {
                        displayError('Este período aún no está disponible.');
                        return;
                    }
                    if ($(this).attr('data-expired') === 'true') {
                        displayError('Este período ya expiró. No puedes seleccionar días de él.');
                        return;
                    }
                    $('.period-card').removeClass('selected');
                    $(this).addClass('selected');
                    selectedPeriod = JSON.parse($(this).attr('data-period'));
                    $('#periodInput').val(selectedPeriod.period + '|' + selectedPeriod.date_start);
                    displayInfo(`Has seleccionado ${selectedPeriod.period_name} con ${selectedPeriod.available_days} días disponibles`);
                    if (confirm('¿Deseas limpiar los días seleccionados y empezar de nuevo con este período?')) {
                        clearCalendarCompletely();
                    }
                });
            }

            // ── Limpiar calendario completamente ────────────────────────────
            function clearCalendarCompletely() {
                if (typeof calendar !== 'undefined') {
                    calendar.fullCalendar('removeEvents');
                }
                clearAllPeriods();
                $.ajax({
                    url: SITEURL + '/vacaciones/ajax',
                    type: 'POST',
                    data: { type: 'delete_all', behalf_user_id: '{{ $vacationRequest->user_id }}', _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.deleted > 0) {
                            displayMessage(`${response.deleted} días eliminados correctamente`);
                        }
                    },
                    error: function() { displayError('Error al limpiar días seleccionados'); }
                });
            }

            // ── Carga inicial ────────────────────────────────────────────────
            loadUserRestrictions();

            // ── Inicialización del calendario ────────────────────────────────
            let events = [];
            noworkingdays.forEach(element => {
                events.push({
                    title: element.reason,
                    start: element.day,
                    description: element.reason,
                    rendering: 'background',
                    editable: false,
                    eventStartEditable: false,
                });
            });

            // Bloquear visualmente los 5 primeros días hábiles
            function addBusinessDays(date, days) {
                let d = moment(date).clone();
                let added = 0;
                while (added < days) {
                    d.add(1, 'day');
                    const dow = d.isoWeekday();
                    if (dow !== 6 && dow !== 7) added++;
                }
                return d;
            }
            const today         = moment().startOf('day');
            const minSelectDate = addBusinessDays(today, 5);

            for (let d = today.clone(); d.isBefore(minSelectDate); d.add(1, 'day')) {
                const dow = d.isoWeekday();
                if (dow !== 6 && dow !== 7) {
                    events.push({
                        start: d.format('YYYY-MM-DD'),
                        rendering: 'background',
                        color: '#ffcccc',
                        editable: false,
                    });
                }
            }

            var calendar = $('#calendar').fullCalendar({
                header: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                locale: 'es',
                aspectRatio: 1.6,
                weekends: false,
                editable: true,
                displayEventTime: false,
                allDay: false,
                events: events,
                selectable: true,
                selectHelper: true,
                dragScroll: false,
                eventMaxStack: 1,
                nextDayThreshold: '00:00:00',
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
                select: function(start, end, allDay) {
                    if (moment(start).isBefore(minSelectDate, 'day')) {
                        displayInfo('Debes solicitar con al menos 5 días hábiles de anticipación. El primer día disponible es el ' + minSelectDate.format('DD/MM/YYYY'));
                        return false;
                    }
                    let check = false;
                    const dates = start.format('YYYY-MM-DD');
                    events.forEach(function(e) {
                        if (dates == e.start) {
                            displayInfo("No puedes seleccionar un día festivo");
                            throw new Error('break');
                        } else {
                            check = true;
                        }
                    });
                    if (events.length === 0) check = true;
                    if (check) {
                        check = false;
                        var startDate = moment(start), endDate = moment(end), date = startDate.clone(), isWeekend = false;
                        end = $.fullCalendar.moment(start);
                        end.add(1, 'hours');
                        while (date.isBefore(endDate)) {
                            if (date.isoWeekday() == 6 || date.isoWeekday() == 7) isWeekend = true;
                            date.add(1, 'day');
                        }
                        if (isWeekend) {
                            displayInfo('No se puede seleccionar fin de semana');
                            return false;
                        } else {
                            var start = $.fullCalendar.formatDate(start, "YYYY-MM-DD");
                            var end   = $.fullCalendar.formatDate(end,   "YYYY-MM-DD");
                            let canSelected = false;

                            if (!selectedPeriod) {
                                displayError('Debes seleccionar un período de vacaciones primero');
                                return false;
                            }
                            if (!currentUserRestrictions.meetsAntiquity) {
                                displayError('No cumples con la antigüedad mínima de 1 año');
                                return false;
                            }
                            if (selectedPeriod.available_days <= 0) {
                                displayError('El período seleccionado no tiene días disponibles');
                                return false;
                            }

                            const periodKey = 'period_' + selectedPeriod.period;
                            const currentlyInPeriod = selectedDaysByPeriod[periodKey] ? selectedDaysByPeriod[periodKey].days.length : 0;
                            if (currentlyInPeriod >= selectedPeriod.available_days) {
                                displayError(`Has alcanzado el límite de ${selectedPeriod.available_days} días disponibles en ${selectedPeriod.period_name}`);
                                return false;
                            }

                            let totalSelectedDays = 0;
                            for (let key in selectedDaysByPeriod) {
                                totalSelectedDays += selectedDaysByPeriod[key].days.length;
                            }
                            if (totalSelectedDays >= currentUserRestrictions.maxDays) {
                                displayError('Has alcanzado el límite máximo de ' + currentUserRestrictions.maxDays + ' días');
                                canSelected = false;
                            } else {
                                canSelected = true;
                            }

                            if (canSelected) {
                                const periodInfo = selectedPeriod;
                                const periodColors = { 1: '#28a745', 2: '#007bff', 3: '#ffc107' };
                                const eventColor = periodColors[periodInfo.period] || '#6c757d';

                                $.ajax({
                                    url: SITEURL + "/vacaciones/ajax",
                                    data: {
                                        title: 'Vacaciones',
                                        start: start,
                                        end:   end,
                                        allDay: false,
                                        type:  'add',
                                        period: periodInfo.period,
                                        behalf_user_id: '{{ $vacationRequest->user_id }}',
                                    },
                                    type: "POST",
                                    success: function(data) {
                                        if (data.exist) { displayError('Ya has seleccionado este día'); return; }
                                        calendar.fullCalendar('renderEvent', {
                                            id:    data.id,
                                            title: 'Vacaciones - ' + periodInfo.period_name,
                                            start: start,
                                            end:   end,
                                            allDay: false,
                                            color: eventColor,
                                            periodInfo: periodInfo
                                        }, true);
                                        addDayToPeriod(start, periodInfo);
                                        displayMessage("Día seleccionado (" + periodInfo.period_name + ")");
                                        calendar.fullCalendar('unselect');
                                    }
                                });
                            }
                        }
                    }
                },
                eventClick: function(event) {
                    if (confirm('¿Eliminar este día seleccionado?')) {
                        const eventStart = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD");
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/vacaciones/ajax',
                            data: { id: event.id, type: 'delete' },
                            success: function() {
                                calendar.fullCalendar('removeEvents', event.id);
                                removeDayFromPeriod(eventStart);
                                displayMessage("Día eliminado correctamente");
                            }
                        });
                    }
                },
            });

            // ── Renderizar días pre-existentes en el calendario ──────────────
            if (existingDays && existingDays.length > 0) {
                const periodColors = { 1: '#28a745', 2: '#007bff', 3: '#ffc107' };
                const defaultColor = preSelectedPeriod ? (periodColors[preSelectedPeriod.period] || '#6c757d') : '#6c757d';
                existingDays.forEach(function(day) {
                    calendar.fullCalendar('renderEvent', {
                        id:    day.id,
                        title: 'Vacaciones',
                        start: day.start,
                        end:   day.end,
                        allDay: false,
                        color: defaultColor,
                    }, true);
                });
                // Navegar al mes del primer día existente
                if (existingDays[0]) {
                    calendar.fullCalendar('gotoDate', existingDays[0].start);
                }
            }

            tipoSolicitud = 'Vacaciones';
        });

        function displayMessage(message) { toastr.success(message, 'Solicitud'); }
        function displayAlert(message)   { toastr.warning(message, 'Advertencia'); }
        function displayInfo(message)    { toastr.info(message, 'Aviso'); }
        function displayError(message)   { toastr.error(message, 'Error'); }
    </script>
    @endpush

@endsection

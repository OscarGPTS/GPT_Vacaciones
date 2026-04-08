@extends('layouts.codebase.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css" media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> <!-- Agregado -->
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
        /* Estilos adicionales para FullCalendar */
        #calendar {
            max-width: 100%;
            height: auto;
            min-height: 500px;
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
        
        /* Estilos para tarjetas de períodos */
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
        
        .period-badge.badge-green {
            background: #d4edda;
            color: #155724;
        }
        
        .period-badge.badge-blue {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .period-badge.badge-yellow {
            background: #fff3cd;
            color: #856404;
        }
        
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
        
        .period-expiration.text-danger {
            font-weight: 600;
        }
        
        .period-expiration.text-warning {
            font-weight: 600;
        }
        
        .period-check-icon {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 1.2rem;
            color: #007bff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .period-card.selected .period-check-icon {
            opacity: 1;
        }
        
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
        
        .period-days-remaining.urgent {
            background: #dc3545;
            color: white;
        }
        
        .period-days-remaining.warning {
            background: #ffc107;
            color: #000;
        }
        
        .period-days-remaining.safe {
            background: #e9ecef;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
@php
    // Solo se maneja un tipo de solicitud: VACACIONES
    $opc = [
        'Vacaciones' => 'Vacaciones'
    ];
@endphp
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Solicitar un permiso</h3>
                <div>
                 
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">¿Como solicito mis vacaciones?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
        <div class="card-body">
            <div class="alert alert-info" id="vacationInfoAlert">
                <h5><i class="fa fa-info-circle"></i> Información de Vacaciones</h5>
                <p class="mb-0">Completa el formulario y selecciona los días de vacaciones en el calendario. Recuerda:</p>
                <ul class="mb-0 mt-2" id="restrictionsList">
                    <li>Máximo <strong id="maxDaysText">32</strong> días por solicitud</li>
                    <li id="periodsInfoItem">Días disponibles: <strong id="availableDaysText">Calculando...</strong></li>
                    <li>Solicitar con al menos 5 días de anticipación</li>
                    <li>Requiere 1 año de antigüedad mínima (<span id="antiquityText">Verificando...</span>)</li>
                </ul>
            </div>
            
            <!-- Opción para solicitar en representación -->
            <div class="alert alert-warning">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="onBehalfCheckbox">
                    <label class="form-check-label fw-bold" for="onBehalfCheckbox">
                        <i class="fas fa-user-friends"></i> Solicitar vacaciones en representación de otro usuario
                    </label>
                </div>
                <small class="text-muted d-block mt-2">
                    Activa esta opción si vas a crear una solicitud para un usuario que no tiene acceso al sistema.
                </small>
            </div>
            
            <!-- Tarjetas de Selección de Períodos -->
            <div id="periodsSelectionPanel" style="display: none;" class="mb-3">
                <h6 class="mb-2"><i class="fas fa-calendar-check"></i> Selecciona el período de vacaciones</h6>
                <p class="text-muted small mb-2" style="font-size: 0.85rem;">
                    Elige el período del que deseas tomar tus vacaciones. Por defecto está seleccionado el período más antiguo disponible.
                </p>
                <div id="periodsCardsContainer" class="row g-2">
                    <!-- Las tarjetas se generarán dinámicamente aquí -->
                </div>
            </div>
        </div>


            <form action="{{ route('vacaciones.store') }}" method="POST" enctype="multipart/form-data" id="vacationForm">
                @csrf
                <input type="hidden" name="period" id="periodInput" value="">
                <div class="row mx-3">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <!-- Selector de usuario (oculto por defecto) -->
                                <div class="form-group mb-3" id="userSelectionDiv" style="display: none;">
                                    <label for="behalf_user_id" class="fw-bold">
                                        <i class="fas fa-user"></i> Seleccionar Usuario <span class="text-danger">*</span>
                                    </label>
                                    <select name="behalf_user_id" id="behalf_user_id" class="form-control">
                                        <option value="">-- Seleccione el usuario --</option>
                                        @foreach($users as $key => $user)
                                            <option value="{{ $key }}" {{ old('behalf_user_id') == $key ? 'selected' : '' }}>
                                                {{ $user }} 
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Selecciona el empleado para quien estás creando esta solicitud</small>
                                    @error('behalf_user_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group mt-4">
                                    <label for="type_request">Tipo de solicitud</label>
                                    <input type="text" class="form-control bg-light text-muted"  value="Vacaciones" readonly>
                                    <input type="hidden" name="type_request" value="Vacaciones">
                                </div>
                                <div class="form-group mt-4">
                                    <label for="payment">Forma de pago</label>
                                    <input type="text" class="form-control bg-light text-muted" value="A cuenta de vacaciones" readonly>
                                    <input type="hidden" name="payment" value="A cuenta de vacaciones">
                                </div>
                        {{--     <div class="mb-2 form-group">
                                <label for="reason">Motivo de las vacaciones (Opcional)</label>
                                <textarea name="reason" id="reason" cols="30" rows="4" class="form-control"
                                    placeholder="Ingrese el motivo de sus vacaciones">{{ old('reason') }}</textarea>
                               
                            </div> --}}

                            <div class="mb-2 form-group mt-4">
                                <label for="reveal">¿Quién será el responsable de atender tus pendientes?</label>
                                <select name="reveal" id="reveal" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($users as $key => $user)
                                        <option value="{{ $key }}" {{ old('reveal') == $key ? 'selected' : '' }}>
                                            {{ $user }}
                                        </option>
                                    @endforeach
                                </select>
                          
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-2 form-group">
                                <label for="days">Selecciona los días que no te presentarás a la oficina</label>
                                <p class="mt'5"></p>
                                <div class="days" id='calendar'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center px-3 py-3">
                <button type="submit" class="btnCreate bg-primary bg-blue rounded-lg mt-4" name="submit">Guardar</button>
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
            // Constantes - definir al principio
            let noworkingdays = @json($noworkingdays);
            const SITEURL = "{{ url('/') }}";
            
            // Variable global para almacenar las restricciones del usuario actual
            let currentUserRestrictions = {
                maxDays: 32,
                availableDays: 0,
                meetsAntiquity: false,
                userName: 'tú',
                periods: []
            };
            
            // Variable para almacenar el período seleccionado actualmente
            let selectedPeriod = null;

            // Variable para rastrear días seleccionados por período
            let selectedDaysByPeriod = {};
            
            // Límite máximo por solicitud
            const MAX_DAYS_PER_REQUEST = 32;

            // Función para actualizar el contador en la tarjeta del período
            function updatePeriodCounter(periodKey) {
                const periodData = selectedDaysByPeriod[periodKey];
                
                // Buscar la tarjeta correspondiente
                $('.period-card').each(function() {
                    const cardPeriod = JSON.parse($(this).attr('data-period'));
                    const cardPeriodKey = 'period_' + cardPeriod.period;
                    
                    if (cardPeriodKey === periodKey) {
                        const counterElement = $(this).find('.period-counter');
                        const selectedCount = periodData ? periodData.days.length : 0;
                        const totalAvailable = cardPeriod.available_days;
                        
                        counterElement.text(`${selectedCount}/${totalAvailable}`);
                        
                        // Cambiar color según disponibilidad
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

            // Función para agregar día a un período
            function addDayToPeriod(date, periodInfo) {
                const periodKey = 'period_' + periodInfo.period;
                
                if (!selectedDaysByPeriod[periodKey]) {
                    selectedDaysByPeriod[periodKey] = {
                        period: periodInfo.period,
                        period_name: periodInfo.period_name,
                        available_days: periodInfo.available_days,
                        date_start: periodInfo.date_start,
                        date_end: periodInfo.date_end,
                        days: [],
                        dayIds: {} // Guardar IDs de los días para enviar al backend
                    };
                }
                
                if (!selectedDaysByPeriod[periodKey].days.includes(date)) {
                    selectedDaysByPeriod[periodKey].days.push(date);
                }
                
                console.log('Días seleccionados por período:', selectedDaysByPeriod);
                updatePeriodCounter(periodKey);
            }

            // Función para eliminar día de un período
            function removeDayFromPeriod(date) {
                for (let periodKey in selectedDaysByPeriod) {
                    const index = selectedDaysByPeriod[periodKey].days.indexOf(date);
                    if (index > -1) {
                        selectedDaysByPeriod[periodKey].days.splice(index, 1);
                        
                        // Si no quedan días en este período, eliminarlo
                        if (selectedDaysByPeriod[periodKey].days.length === 0) {
                            delete selectedDaysByPeriod[periodKey];
                        }
                        
                        updatePeriodCounter(periodKey);
                        break;
                    }
                }
                
                console.log('Días seleccionados por período:', selectedDaysByPeriod);
            }

            // Función para limpiar todos los períodos
            function clearAllPeriods() {
                // Actualizar todos los contadores a 0 antes de limpiar
                for (let periodKey in selectedDaysByPeriod) {
                    selectedDaysByPeriod[periodKey].days = [];
                    updatePeriodCounter(periodKey);
                }
                selectedDaysByPeriod = {};
                console.log('Resumen de períodos limpiado');
            }

            // Función para obtener el período disponible actual (considerando días ya seleccionados)
            function getCurrentAvailablePeriod(userId) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: SITEURL + "/vacaciones/get-user-restrictions",
                        data: {
                            user_id: userId
                        },
                        type: "POST",
                        success: function(response) {
                            if (response.success && response.data.periods) {
                                // Encontrar el primer período con días disponibles
                                for (let period of response.data.periods) {
                                    const periodKey = 'period_' + period.period;
                                    const selectedInPeriod = selectedDaysByPeriod[periodKey] ? selectedDaysByPeriod[periodKey].days.length : 0;
                                    
                                    if (selectedInPeriod < period.available_days) {
                                        // Devolver el período con la información original (sin restar)
                                        resolve(period);
                                        return;
                                    }
                                }
                                resolve(null); // No hay períodos disponibles
                            } else {
                                reject('Error al obtener períodos');
                            }
                        },
                        error: function(xhr, status, error) {
                            reject(error);
                        }
                    });
                });
            }

            // Función para verificar si se puede agregar un día del período
            // Limpiar días seleccionados al salir de la página sin guardar
            $(window).on('beforeunload', function() {
                // Solo limpiar si hay días seleccionados
                const selectedEvents = $('#calendar').fullCalendar('clientEvents');
                if (selectedEvents && selectedEvents.length > 0) {
                    const behalfUserId = $('#behalf_user_id').val();
                    $.ajax({
                        url: SITEURL + '/vacaciones/ajax',
                        type: 'POST',
                        async: false, // Sincronizar para que se ejecute antes de salir
                        data: {
                            type: 'delete_all',
                            behalf_user_id: behalfUserId || null,
                            _token: '{{ csrf_token() }}'
                        }
                    });
                }
            });

            // Función para cargar restricciones del usuario
            function loadUserRestrictions(userId = null) {
                const url = "{{ route('vacaciones.get-user-restrictions') }}";
                
                console.log('Cargando restricciones para usuario:', userId || 'usuario autenticado');
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        user_id: userId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Respuesta recibida:', response);
                        
                        if (response.success) {
                            const data = response.data;
                            currentUserRestrictions = {
                                maxDays: data.max_per_request.toFixed(2),
                                availableDays: data.total_available,
                                meetsAntiquity: data.meets_antiquity,
                                userName: data.user_name,
                                antiquityYears: data.antiquity_years,
                                antiquityMonths: data.antiquity_months,
                                periods: data.periods || []
                            };

                            console.log('Restricciones actualizadas:', currentUserRestrictions);

                            // Actualizar la UI
                            updateRestrictionsUI();
                        } else {
                            console.error('Respuesta sin success:', response);
                            $('#periodsInfoItem').html('Días disponibles: <strong class="text-danger">Error al cargar</strong>');
                            $('#antiquityText').text('Error al cargar');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX:', {xhr: xhr, status: status, error: error});
                        console.error('Response Text:', xhr.responseText);
                        $('#periodsInfoItem').html('Días disponibles: <strong class="text-danger">Error: ' + (xhr.status || 'desconocido') + '</strong>');
                        $('#antiquityText').text('Error al cargar');
                        displayError('Error al cargar información del usuario: ' + error);
                    }
                });
            }

            // Función para actualizar la UI con las restricciones
            function updateRestrictionsUI() {
                const restrictions = currentUserRestrictions;
                
                console.log('Actualizando UI con restricciones:', restrictions);
                
                $('#maxDaysText').text(restrictions.maxDays);
                
                // Actualizar información de períodos
                if (restrictions.periods && restrictions.periods.length > 0) {
                    let periodsHTML = '<div class="mt-1">';
                    restrictions.periods.forEach(function(period, index) {
                        const daysText = period.available_days === 1 ? 'día' : 'días';
                        const exactDays = period.available_days_exact ? ' (' + period.available_days_exact + ' exactos)' : '';
                        
                        // Formatear fechas del período - usar split para evitar problemas de zona horaria
                        const formatDate = (dateStr) => {
                            const [year, month, day] = dateStr.split('-');
                            return `${day}/${month}/${year}`;
                        };
                        const dateStart = formatDate(period.date_start);
                        const dateEnd = formatDate(period.date_end);
                        
                        // Calcular días restantes hasta la expiración
                        const daysRemaining = Math.abs(new Date(period.expiration_date.split('/').reverse().join('-')) - new Date()) / (1000 * 60 * 60 * 24);
                        
                        // Determinar color según urgencia
                        let daysClass = '';
                        let expirationClass = '';
                        if (period.is_expired) {
                            daysClass = 'text-danger fw-bold';
                            expirationClass = 'text-danger fw-bold';
                        } else if (period.expires_soon) {
                            daysClass = 'text-warning fw-bold';
                            expirationClass = 'text-warning fw-bold';
                        } else {
                            daysClass = 'text-success fw-bold';
                            expirationClass = '';
                        }
                        
                        // Construir el texto de días restantes
                        let daysRemainingText = '';
                        if (period.is_expired) {
                            const daysExpired = Math.floor(daysRemaining);
                            daysRemainingText = '<span class="' + expirationClass + '">(hace ' + daysExpired + ' días)</span>';
                        } else {
                            daysRemainingText = '<span class="' + expirationClass + '">(faltan ' + Math.floor(daysRemaining) + ' días)</span>';
                        }
                        
                        // Formato: Tienes X días del período (fecha - fecha) que vencen el día DD/MM/YYYY (faltan X días)
                        periodsHTML += '<div class="mb-2">';
                        periodsHTML += '• Tienes ';
                        periodsHTML += '<span class="' + daysClass + '" title="' + exactDays + '">' + period.available_days + ' ' + daysText + '</span>';
                        periodsHTML += ' del período ';
                        periodsHTML += '<strong>(' + dateStart + ' al ' + dateEnd + ')</strong>';
                        periodsHTML += ' que vencen el día ';
                        periodsHTML += '<strong class="' + expirationClass + '">' + period.expiration_date + '</strong>';
                        periodsHTML += ' ' + daysRemainingText;
                        periodsHTML += '</div>';
                    });
                    periodsHTML += '</div>';
                    
                    $('#periodsInfoItem').html(periodsHTML);
                    
                    // Renderizar tarjetas de períodos
                    renderPeriodCards(restrictions.periods);
                } else {
                    $('#periodsInfoItem').html('Días disponibles: <strong class="text-danger">0 días</strong>');
                    $('#periodsSelectionPanel').hide();
                }
                
                console.log('Texto actualizado - Días disponibles por período');
                
                // Actualizar texto de antigüedad
                const antiquityYears = restrictions.antiquityYears || 0;
                const antiquityMonths = restrictions.antiquityMonths || 0;
                
                if (restrictions.meetsAntiquity) {
                    const yearsText = antiquityYears === 1 ? '1 año' : antiquityYears + ' años';
                    $('#antiquityText').html('<span class="text-success"><i class="fas fa-check-circle"></i> Cumple (' + yearsText + ')</span>');
                } else {
                    const monthsText = antiquityMonths === 1 ? '1 mes' : antiquityMonths + ' meses';
                    $('#antiquityText').html('<span class="text-danger"><i class="fas fa-times-circle"></i> No cumple (' + monthsText + ')</span>');
                }

                console.log('Antigüedad actualizada - Años:', antiquityYears, 'Meses:', antiquityMonths, 'Cumple:', restrictions.meetsAntiquity);

                // Cambiar color del alert si no tiene días disponibles o no cumple antigüedad
                const alertBox = $('#vacationInfoAlert');
                if (!restrictions.meetsAntiquity || restrictions.availableDays <= 0) {
                    alertBox.removeClass('alert-info').addClass('alert-danger');
                } else if (restrictions.availableDays <= 5) {
                    alertBox.removeClass('alert-info alert-danger').addClass('alert-warning');
                } else {
                    alertBox.removeClass('alert-danger alert-warning').addClass('alert-info');
                }
                
                console.log('UI actualizada correctamente');
            }
            
            // Función para renderizar las tarjetas de períodos
            function renderPeriodCards(periods) {
                if (!periods || periods.length === 0) {
                    $('#periodsSelectionPanel').hide();
                    return;
                }
                
                const container = $('#periodsCardsContainer');
                container.empty();
                
                // Colores por período
                const periodColors = {
                    1: { badge: 'badge-green', color: '#28a745' },
                    2: { badge: 'badge-blue', color: '#007bff' },
                    3: { badge: 'badge-yellow', color: '#ffc107' }
                };
                
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Resetear horas para comparación de solo fecha
                
                let firstSelectablePeriod = null;
                
                periods.forEach(function(period, index) {
                    const colorScheme = periodColors[period.period] || { badge: 'badge-secondary', color: '#6c757d' };
                    const isExpired = period.is_expired;
                    const expiresSoon = period.expires_soon;
                    const expiresUrgent = period.expires_urgent;
                    
                    // Verificar si el período está bloqueado (date_end no ha pasado aún)
                    const periodEndDate = new Date(period.date_end);
                    periodEndDate.setHours(0, 0, 0, 0);
                    const isLocked = periodEndDate >= today; // Si date_end es mayor o igual a hoy, está bloqueado
                    
                    // Formatear fechas
                    const dateStart = new Date(period.date_start).toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: '2-digit' });
                    const dateEnd = new Date(period.date_end).toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: '2-digit' });
                    
                    // Construir clase CSS
                    let cardClass = 'period-card';
                    
                    // Solo seleccionar automáticamente si no está bloqueado ni expirado
                    if (!firstSelectablePeriod && !isLocked && !isExpired) {
                        firstSelectablePeriod = period;
                        cardClass += ' selected';
                        selectedPeriod = period;
                        // Actualizar campo oculto del formulario con período y fecha
                        $('#periodInput').val(period.period + '|' + period.date_start);
                    } else if (selectedPeriod && selectedPeriod.period === period.period && !isLocked && !isExpired) {
                        cardClass += ' selected';
                    }
                    
                    if (isExpired) cardClass += ' expired';
                    if (isLocked) cardClass += ' locked';
                    if (expiresUrgent && !isLocked && !isExpired) cardClass += ' expires-urgent';
                    else if (expiresSoon && !isLocked && !isExpired) cardClass += ' expires-soon';
                    
                    // Texto de estado y badge de días restantes
                    let statusText = '';
                    let statusClass = '';
                    let daysRemainingBadge = '';
                    
                    if (isLocked) {
                        // Calcular días restantes hasta desbloqueo
                        const daysUntilUnlock = Math.ceil((periodEndDate - today) / (1000 * 60 * 60 * 24));
                        statusText = '<i class="fas fa-lock"></i> Bloqueado';
                        statusClass = 'text-secondary';
                        daysRemainingBadge = `<span class="period-days-remaining safe"><i class="fas fa-clock"></i> Desbloquea en ${daysUntilUnlock}d</span>`;
                    } else if (isExpired) {
                        statusText = '<i class="fas fa-times-circle"></i> Expirado';
                        statusClass = 'text-danger';
                        daysRemainingBadge = `<span class="period-days-remaining urgent"><i class="fas fa-ban"></i> Vencido</span>`;
                    } else {
                        // Mostrar días restantes
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
                    
                    const cardHTML = `
                        <div class="col-md-4">
                            <div class="${cardClass}" data-period='${JSON.stringify(period)}' data-locked="${isLocked}" data-expired="${isExpired}">
                                <span class="period-counter text-success">0/${period.available_days}</span>
                                <i class="fas fa-check-circle period-check-icon"></i>
                                <div class="period-badge ${colorScheme.badge}">
                                    ${period.period_name}
                                </div>
                                <div class="period-days-text" style="color: ${colorScheme.color}">
                                    ${period.available_days}
                                    <span style="font-size: 0.85rem; color: #6c757d;">${period.available_days === 1 ? 'día' : 'días'}</span>
                                </div>
                                <div class="text-muted small mt-1" style="font-size: 0.65rem;">
                                    <i class="fas fa-calendar-alt"></i> ${dateStart} - ${dateEnd}
                                </div>
                                <div class="mt-1">
                                    ${daysRemainingBadge}
                                </div>
                                <div class="period-expiration ${statusClass} mt-1" style="font-size: 0.7rem;">
                                    ${statusText}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    container.append(cardHTML);
                });
                
                $('#periodsSelectionPanel').show();
                
                // Agregar evento click a las tarjetas
                $('.period-card').off('click').on('click', function() {
                    const isLocked = $(this).attr('data-locked') === 'true';
                    const isExpired = $(this).attr('data-expired') === 'true';
                    
                    if (isLocked) {
                        displayError('Este período aún no está disponible. Se desbloqueará cuando finalice el período de generación.');
                        return;
                    }
                    
                    if (isExpired) {
                        displayError('Este período ya expiró. No puedes seleccionar días de él.');
                        return;
                    }
                    
                    // Remover selección anterior
                    $('.period-card').removeClass('selected');
                    
                    // Seleccionar esta tarjeta
                    $(this).addClass('selected');
                    
                    // Actualizar período seleccionado
                    selectedPeriod = JSON.parse($(this).attr('data-period'));
                    
                    // Actualizar campo oculto del formulario con período y fecha de inicio
                    $('#periodInput').val(selectedPeriod.period + '|' + selectedPeriod.date_start);
                    
                    console.log('Período seleccionado:', selectedPeriod);
                    displayInfo(`Has seleccionado ${selectedPeriod.period_name} con ${selectedPeriod.available_days} días disponibles`);
                    
                    // Limpiar días seleccionados al cambiar de período
                    if (confirm('¿Deseas limpiar los días seleccionados y empezar de nuevo con este período?')) {
                        clearCalendarCompletely();
                    }
                });
            }

            // Función para limpiar completamente el calendario
            function clearCalendarCompletely() {
                console.log('Limpiando calendario completamente...');
                
                // 1. Limpiar eventos del calendario visual
                if (typeof calendar !== 'undefined') {
                    calendar.fullCalendar('removeEvents');
                    console.log('Eventos visuales eliminados del calendario');
                }
                
                // 2. Limpiar resumen de períodos
                clearAllPeriods();
                
                // 3. Limpiar eventos del servidor - considerar usuario en representación
                const behalfUserId = $('#behalf_user_id').val();
                
                $.ajax({
                    url: SITEURL + '/vacaciones/ajax',
                    type: 'POST',
                    data: {
                        type: 'delete_all',
                        behalf_user_id: behalfUserId || null,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Eventos del servidor eliminados exitosamente:', response);
                        if (response.deleted > 0) {
                            displayMessage(`${response.deleted} días eliminados correctamente`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al limpiar eventos del servidor:', error);
                        displayError('Error al limpiar días seleccionados');
                    }
                });
                
                // 4. No resetear el período seleccionado, mantenerlo para seguir seleccionando
                // selectedPeriod seguirá siendo el que está seleccionado
            }

            // ========== TOGGLE PARA SOLICITUD EN REPRESENTACIÓN ==========
            $('#onBehalfCheckbox').on('change', function() {
                console.log('Checkbox cambió, estado:', $(this).is(':checked'));
                
                // Limpiar calendario al cambiar el estado del checkbox
                clearCalendarCompletely();
                
                // Resetear período seleccionado
                selectedPeriod = null;
                
                if ($(this).is(':checked')) {
                    $('#userSelectionDiv').slideDown();
                    $('#behalf_user_id').prop('required', true);
                    displayInfo('Modo representación activado. Selecciona un usuario para continuar.');
                } else {
                    $('#userSelectionDiv').slideUp();
                    $('#behalf_user_id').prop('required', false);
                    $('#behalf_user_id').val('');
                    
                    // Recargar restricciones del usuario actual
                    loadUserRestrictions();
                    displayInfo('Volviendo a tu usuario personal. Días anteriores eliminados.');
                }
            });

            // Cuando cambie el usuario seleccionado
            $('#behalf_user_id').on('change', function() {
                const selectedUserId = $(this).val();
                console.log('Usuario seleccionado cambió a:', selectedUserId);
                
                // Limpiar calendario al cambiar de usuario
                clearCalendarCompletely();
                
                // Resetear período seleccionado
                selectedPeriod = null;
                
                if (selectedUserId) {
                    // Cargar restricciones del usuario seleccionado
                    loadUserRestrictions(selectedUserId);
                    displayInfo('Usuario cambiado. Días seleccionados reseteados.');
                } else {
                    // Si no hay usuario seleccionado, cargar del usuario actual si está en modo representación
                    if ($('#onBehalfCheckbox').is(':checked')) {
                        displayInfo('Selecciona un usuario para continuar.');
                    } else {
                        loadUserRestrictions();
                    }
                }
            });

            @if(old('behalf_user_id'))
                console.log('Modo: Restaurando selección anterior');
                $('#onBehalfCheckbox').prop('checked', true);
                $('#userSelectionDiv').show();
                $('#behalf_user_id').prop('required', true);
                // Cargar restricciones directamente
                loadUserRestrictions({{ old('behalf_user_id') }});
            @else
                console.log('Modo: Carga inicial - usuario autenticado');
                // Cargar restricciones del usuario actual al inicio
                loadUserRestrictions();
            @endif

            // Verificar que FullCalendar esté disponible
            if (typeof $.fn.fullCalendar === 'undefined') {
                console.error('FullCalendar no está cargado');
                return;
            }

            const request_time = document.getElementById('request_time');
            let tipoSolicitud = '';
            // Selector del div del calendario
            const calendarEl = document.getElementById('calendar');

            // Asignacion del token a AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            // Asignacion de los dias no laborales
            let events = []
            noworkingdays.forEach(element => {
                events.push({
                    title: element.reason,
                    start: element.day,
                    description: element.reason,
                    rendering: 'background',
                    editable: false,
                    eventStartEditable: false,
                })
            });

            // Solo manejamos vacaciones

            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                locale: 'es',
                editable: true,
                displayEventTime: false,
                allDay: false,
                events: events,
                selectable: true,
                selectHelper: true,
                dragScroll: false,
                eventMaxStack: 1,
                nextDayThreshold: '00:00:00',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
                    'Nov', 'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                select: function(start, end, allDay) {
                    // Verificar que tenemos restricciones cargadas antes de continuar
                    if (!currentUserRestrictions.userName || 
                        (currentUserRestrictions.userName === 'tú' && $('#behalf_user_id').val() !== '')) {
                        displayError('Cargando información del usuario, intenta nuevamente en un momento...');
                        return false;
                    }

                    // Variable de estado (Revisa si la fecha se puede seleccionar)
                    let check = false;
                    //Valida si selecciona un dia no laborable
                    const dates = start.format('YYYY-MM-DD');

                    events.forEach(function(e) {
                        console.log(start);
                        if (dates == e.start) {
                            displayInfo("No puedes seleccionar un día festivo")
                            throw BreakException
                        } else {
                            check = true
                        }
                    });
                    if (events.length === 0) {
                        check = true
                    }
                    if (check == true) {
                        check = false
                        let title = 'Ausente'
                        var startDate = moment(start),
                            endDate = moment(end),
                            date = startDate.clone(),
                            isWeekend = false;
                        end = $.fullCalendar.moment(start);
                        end.add(1, 'hours');

                        while (date.isBefore(endDate)) {
                            if (date.isoWeekday() == 6 || date.isoWeekday() == 7) {
                                isWeekend = true;
                            }
                            date.add(1, 'day');
                        }
                        if (isWeekend) {
                            displayInfo('No se puede seleccionar fin de semana');
                            return false;
                        } else {
                            var start = $.fullCalendar.formatDate(start, "YYYY-MM-DD");
                            var end = $.fullCalendar.formatDate(end, "YYYY-MM-DD");

                            // Validaciones para vacaciones
                            let canSelected = false;
                            
                            // 0. Verificar que haya un período seleccionado
                            if (!selectedPeriod) {
                                displayError('Debes seleccionar un período de vacaciones primero');
                                return false;
                            }
                            
                            // 1. Validar antigüedad mínima
                            if (!currentUserRestrictions.meetsAntiquity) {
                                displayError('El usuario ' + currentUserRestrictions.userName + ' no cumple con la antigüedad mínima de 1 año');
                                return false;
                            }

                            // 2. Validar que tenga días disponibles en el período seleccionado
                            if (selectedPeriod.available_days <= 0) {
                                displayError('El período seleccionado no tiene días disponibles');
                                return false;
                            }

                            // 3. Validar límite del período seleccionado
                            const periodKey = 'period_' + selectedPeriod.period;
                            const currentlyInPeriod = selectedDaysByPeriod[periodKey] ? selectedDaysByPeriod[periodKey].days.length : 0;
                            
                            if (currentlyInPeriod >= selectedPeriod.available_days) {
                                displayError(`Has alcanzado el límite de ${selectedPeriod.available_days} días disponibles en ${selectedPeriod.period_name}`);
                                return false;
                            }
                            
                            // 4. Validar límite máximo por solicitud (dinámico según usuario)
                            let totalSelectedDays = 0;
                            for (let key in selectedDaysByPeriod) {
                                totalSelectedDays += selectedDaysByPeriod[key].days.length;
                            }
                            
                            if (totalSelectedDays >= currentUserRestrictions.maxDays) {
                                displayError('Has alcanzado el límite máximo de ' + currentUserRestrictions.maxDays + ' días que puedes solicitar');
                                canSelected = false;
                            } else {
                                canSelected = true;
                            }

                            // Definir el título del evento
                            let title = 'Vacaciones';

                            if (canSelected) {
                                // Obtener el behalf_user_id si está seleccionado
                                const behalfUserId = $('#behalf_user_id').val();
                                
                                // Usar el período seleccionado directamente
                                const periodInfo = selectedPeriod;
                                
                                // Determinar color según el período
                                const periodColors = {
                                    1: '#28a745', // Verde
                                    2: '#007bff', // Azul
                                    3: '#ffc107', // Amarillo
                                };
                                const eventColor = periodColors[periodInfo.period] || '#6c757d';
                                
                                // Ahora agregar el día al calendario
                                $.ajax({
                                    url: SITEURL + "/vacaciones/ajax",
                                    data: {
                                        title: title,
                                        start: start,
                                        end: end,
                                        allDay: false,
                                        type: 'add',
                                        period: periodInfo.period, // Enviar el número de período
                                        behalf_user_id: behalfUserId || null
                                    },
                                    type: "POST",
                                    success: function(data) {
                                        if (data.exist) {
                                            displayError('Ya has seleccionado este día');
                                            return;
                                        }
                                        calendar.fullCalendar('renderEvent', {
                                            id: data.id,
                                            title: title + ' - ' + periodInfo.period_name,
                                            start: start,
                                            end: end,
                                            allDay: false,
                                            color: eventColor,
                                            periodInfo: periodInfo
                                        }, true);
                                        
                                        // Agregar al resumen de períodos
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
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function(response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                
                                // Eliminar del resumen de períodos
                                removeDayFromPeriod(eventStart);
                                
                                displayMessage("Día eliminado correctamente");
                            }
                        });
                    }
                },

            });
            
            // Establecer tipo de solicitud como Vacaciones (único tipo disponible)
            tipoSolicitud = 'Vacaciones';
        });


        function displayMessage(message) {
            toastr.success(message, 'Solicitud');
        }

        function displayAlert(message) {
            toastr.warning(message, 'Advertencia');
        }

        function displayInfo(message) {
            toastr.info(message, 'Advertencia');
        }

        function displayError(message) {
            toastr.error(message, 'Error');
        }
    </script>
    @endpush


@endsection

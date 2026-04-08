<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="flex card-title mb-0">
                                <a href="{{ url()->previous() }}" class="mr-4">
                                    <svg width="30px" height="30px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path fill="#FFF" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"/><path fill="#FFF" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"/>
                                    </svg>
                                </a>
                                Calendario de Vacaciones
                            </h3>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Filtros -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Filtrar por Departamento</label>
                                <select wire:model.live="departmentFilter" class="form-select">
                                    <option value="">Todos los departamentos</option>
                                    @foreach($this->departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                @if($departmentFilter)
                                    <button wire:click="$set('departmentFilter', '')" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Limpiar
                                    </button>
                                @endif
                            </div>
                        </div>


                        <!-- Calendario -->
                        <div id="vacation-calendar" wire:ignore.self></div>
                        
                        <!-- Datos de eventos para JavaScript -->
                        <div id="calendar-events-data" style="display: none;" data-events='@json($this->getCalendarEvents())'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
        <style>
            #vacation-calendar {
                max-width: 100%;
                margin: 0 auto;
            }
            
            .fc-event {
                cursor: pointer;
                border-radius: 3px;
                padding: 2px 4px;
                font-size: 0.85rem;
            }
            
            .fc-daygrid-event {
                white-space: normal !important;
            }
            
            .fc-event-title {
                font-weight: 500;
            }
            
            /* Mejorar visibilidad de eventos */
            .fc-daygrid-day-frame {
                min-height: 80px;
            }
            
            /* Estilo para el tooltip */
            .vacation-tooltip {
                position: absolute;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 10px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                z-index: 9999;
                max-width: 250px;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js"></script>
        
        <script>
            let vacationCalendar = null;
            
            function initCalendar() {
                console.log('Inicializando calendario de vacaciones...');
                
                const calendarEl = document.getElementById('vacation-calendar');
                
                if (!calendarEl) {
                    console.error('No se encontró el elemento #vacation-calendar');
                    return;
                }
                
                console.log('Elemento del calendario encontrado');
                
                // Obtener eventos del elemento de datos
                const eventsDataEl = document.getElementById('calendar-events-data');
                const calendarEvents = eventsDataEl ? JSON.parse(eventsDataEl.dataset.events) : [];
                console.log('Eventos cargados:', calendarEvents.length);
                
                // Destruir calendario anterior si existe
                if (vacationCalendar) {
                    vacationCalendar.destroy();
                }
                
                vacationCalendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,listMonth'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        list: 'Lista'
                    },
                    height: 'auto',
                    navLinks: true,
                    editable: false,
                    dayMaxEvents: 3,
                    moreLinkText: function(num) {
                        return '+' + num + ' más';
                    },
                    events: calendarEvents,
                    eventClick: function(info) {
                        const event = info.event;
                        const props = event.extendedProps;
                        
                        /* alert(
                            'Empleado: ' + props.userName + '\n' +
                            'Departamento: ' + props.department + '\n' +
                            'Fecha: ' + event.start.toLocaleDateString('es-MX')
                        ); */
                    },
                    eventMouseEnter: function(info) {
                        const event = info.event;
                        const props = event.extendedProps;
                        
                        const tooltip = document.createElement('div');
                        tooltip.className = 'vacation-tooltip';
                        tooltip.innerHTML = `
                            <strong>${props.userName}</strong><br>
                            <small class="text-muted">${props.department}</small><br>
                            <small>${event.start.toLocaleDateString('es-MX')}</small>
                        `;
                        
                        document.body.appendChild(tooltip);
                        
                        const rect = info.el.getBoundingClientRect();
                        tooltip.style.top = (rect.top + window.scrollY - tooltip.offsetHeight - 5) + 'px';
                        tooltip.style.left = (rect.left + window.scrollX) + 'px';
                        
                        info.el._tooltip = tooltip;
                    },
                    eventMouseLeave: function(info) {
                        if (info.el._tooltip) {
                            info.el._tooltip.remove();
                            info.el._tooltip = null;
                        }
                    }
                });
                
                console.log('Renderizando calendario...');
                vacationCalendar.render();
                console.log('Calendario renderizado exitosamente');
            }
            
            // Inicializar al cargar la página
            document.addEventListener('DOMContentLoaded', initCalendar);
            
            // Reinicializar cuando Livewire actualice el componente
            document.addEventListener('livewire:init', () => {
                Livewire.hook('morph.updated', ({ el, component }) => {
                    // Verificar si hay un elemento de datos de eventos actualizado
                    const eventsDataEl = document.getElementById('calendar-events-data');
                    if (eventsDataEl) {
                        console.log('Livewire actualizó el componente, reinicializando calendario...');
                        setTimeout(initCalendar, 100);
                    }
                });
            });
        </script>
    @endpush
</div>

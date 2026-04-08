@extends('layouts.codebase.master')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Solicitar Permiso o Vacaciones</h3>
                        <a href="{{ route('vacaciones.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Volver a mis solicitudes
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('vacaciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Columna izquierda - Formulario -->
                            <div class="col-md-6">
                                <div class="card shadow h-100">
                                    <div class="card-body">
                                        <!-- Tipo de solicitud -->
                                        <div class="form-group mb-3">
                                            <label for="type_request">Tipo de solicitud *</label>
                                            <select name="type_request" id="type_request" class="form-control" required>
                                                <option value="">Seleccione una opción</option>
                                                <option value="Solicitar vacaciones">Solicitar vacaciones</option>
                                                <option value="Salir durante la jornada">Salir durante la jornada</option>
                                                <option value="Faltar a sus labores">Faltar a sus labores</option>
                                                <option value="Fallecimiento de familiar directo">Fallecimiento de familiar directo</option>
                                                <option value="Matrimonio del colaborador">Matrimonio del colaborador</option>
                                                <option value="Motivos academicas/escolares">Motivos académicos/escolares</option>
                                                <option value="Atencion de asuntos personales">Atención de asuntos personales</option>
                                                <option value="Permiso de Paternidad">Permiso de Paternidad</option>
                                            </select>
                                            @error('type_request')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Forma de pago (automática) -->
                                        <div class="form-group mb-3">
                                            <label for="payment">Forma de pago</label>
                                            <input type="text" name="payment" id="payment" class="form-control" readonly placeholder="Se asigna automáticamente">
                                        </div>

                                        <!-- Horarios (solo para salidas durante la jornada) -->
                                        <div id="horarios_section" class="d-none">
                                            <div class="form-group mb-3">
                                                <label for="start">Hora de salida</label>
                                                <input type="time" name="start" id="start" class="form-control">
                                                <small class="text-muted">Llenar únicamente en caso de retirarse</small>
                                                @error('start')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="end">Hora de ingreso/reingreso</label>
                                                <input type="time" name="end" id="end" class="form-control">
                                                <small class="text-muted">Usar en caso de ingresar después de las 8:00 o regresar después de una salida</small>
                                                @error('end')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Opciones especiales -->
                                        <div id="familiar_options" class="form-group mb-3 d-none">
                                            <label>Familiar directo *</label>
                                            <div class="form-check">
                                                <input type="radio" name="opcion" value="Conyuge" class="form-check-input">
                                                <label class="form-check-label">Cónyuge</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="opcion" value="Hijos" class="form-check-input">
                                                <label class="form-check-label">Hijos</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="opcion" value="Padres" class="form-check-input">
                                                <label class="form-check-label">Padres</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="opcion" value="Hermanos" class="form-check-input">
                                                <label class="form-check-label">Hermanos</label>
                                            </div>
                                            @error('opcion')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div id="academic_options" class="form-group mb-3 d-none">
                                            <label>El motivo escolar es de *</label>
                                            <div class="form-check">
                                                <input type="radio" name="opcion" value="Hijo(a)" class="form-check-input">
                                                <label class="form-check-label">Hijo(a)</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="opcion" value="Colaborador(a)" class="form-check-input">
                                                <label class="form-check-label">Colaborador(a)</label>
                                            </div>
                                            @error('opcion')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Razón -->
                                        <div class="form-group mb-3">
                                            <label for="reason">Razón de tu ausencia *</label>
                                            <textarea name="reason" id="reason" class="form-control" rows="4" 
                                                placeholder="Describe las razones de tu ausencia" required>{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Justificante -->
                                        <div class="form-group mb-3">
                                            <label for="archivos_permiso">Anexar justificante (opcional)</label>
                                            <input type="file" name="archivos_permiso[]" id="archivos_permiso" 
                                                class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">Puedes subir múltiples archivos (PDF, JPG, PNG)</small>
                                        </div>

                                        <!-- Responsable -->
                                        <div class="form-group mb-3">
                                            <label for="reveal">¿Quién atenderá tus pendientes? *</label>
                                            <select name="reveal" id="reveal" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($users as $id => $nombre)
                                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                                @endforeach
                                            </select>
                                            @error('reveal')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna derecha - Calendario -->
                            <div class="col-md-6">
                                <div class="card shadow h-100">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Selecciona los días de ausencia *</label>
                                            <p class="text-muted">Haz clic en los días del calendario que no te presentarás</p>
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fa fa-save"></i> Crear Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script>
$(document).ready(function() {
    const noworkingdays = @json($noworkingdays);
    const SITEURL = "{{ url('/') }}";
    
    // Configurar token CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Eventos de días no laborables
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

    // Inicializar calendario
    $('#calendar').fullCalendar({
        editable: true,
        displayEventTime: false,
        events: events,
        selectable: true,
        selectHelper: true,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        
        select: function(start, end, allDay) {
            const dates = start.format('YYYY-MM-DD');
            
            // Verificar si es día festivo
            let isDayOff = events.some(event => dates === event.start);
            if (isDayOff) {
                toastr.error('No puedes seleccionar un día festivo');
                return false;
            }

            // Verificar si es fin de semana
            if (start.isoWeekday() === 6 || start.isoWeekday() === 7) {
                toastr.error('No se puede seleccionar fin de semana');
                return false;
            }

            // Agregar día
            let title = 'Ausente';
            let startDate = start.format('YYYY-MM-DD');
            let endDate = startDate;

            $.ajax({
                url: SITEURL + "/vacaciones/ajax",
                data: {
                    title: title,
                    start: startDate,
                    end: endDate,
                    type: 'add',
                },
                type: "POST",
                success: function(data) {
                    if (data.exist) {
                        toastr.error('Ya has seleccionado este día');
                        return;
                    }
                    
                    $('#calendar').fullCalendar('renderEvent', {
                        id: data.id,
                        title: title,
                        start: startDate,
                        end: endDate,
                        color: '#28a745'
                    }, true);
                    
                    toastr.success('Día seleccionado correctamente');
                    $('#calendar').fullCalendar('unselect');
                }
            });
        },

        eventClick: function(event) {
            if (confirm('¿Eliminar este día seleccionado?')) {
                $.ajax({
                    type: "POST",
                    url: SITEURL + '/vacaciones/ajax',
                    data: {
                        id: event.id,
                        type: 'delete'
                    },
                    success: function(response) {
                        $('#calendar').fullCalendar('removeEvents', event.id);
                        toastr.success('Día eliminado correctamente');
                    }
                });
            }
        }
    });

    // Manejo del cambio de tipo de solicitud
    $('#type_request').on('change', function() {
        const selectedType = $(this).val();
        
        // Resetear todas las secciones
        $('#horarios_section, #familiar_options, #academic_options').addClass('d-none');
        $('input[name="opcion"]').prop('checked', false);
        
        // Determinar tipo de pago
        let paymentType = '';
        switch(selectedType) {
            case 'Solicitar vacaciones':
                paymentType = 'A cuenta de vacaciones';
                break;
            case 'Salir durante la jornada':
            case 'Faltar a sus labores':
                paymentType = 'Descontar Tiempo/Día';
                if (selectedType === 'Salir durante la jornada') {
                    $('#horarios_section').removeClass('d-none');
                }
                break;
            default:
                paymentType = 'Permiso especial';
                break;
        }
        
        $('#payment').val(paymentType);
        
        // Mostrar opciones especiales según el tipo
        if (selectedType === 'Fallecimiento de familiar directo') {
            $('#familiar_options').removeClass('d-none');
        } else if (selectedType === 'Motivos academicas/escolares') {
            $('#academic_options').removeClass('d-none');
        }
    });
});
</script>
@endpush
@endsection
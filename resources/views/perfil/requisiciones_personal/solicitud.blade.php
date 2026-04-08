<x-card>
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-1 rounded dark:bg-red-900 dark:text-red-300">Folio: {{ $requisicion->folio() }}</span>
                </div>
                <div>
                    <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-1 rounded dark:bg-red-900 dark:text-red-300">Estatus: {{ $requisicion->status }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <p class="my-2 fw-bold">Solicitante: {{ $requisicion->solicitante->nombre() }}</p>
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Puesto solicitado:</label>
            <input readonly type="text" class="form-control"
                value="{{ isset($requisicion->puesto_solicitado) ? $requisicion->puesto->name : $requisicion->puesto_nuevo }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Tipo de personal:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->tipo_personal }}">
        </div>
    </div>
    <div class="mt-2 row">
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Motivo de la requisición:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->motivo }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Horario:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->horario }}">
        </div>
    </div>
    <div class="mt-2 row">
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Personas requeridas:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->personas_requeridas }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Último grado de estudios:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->grado_escolar }}">
        </div>
    </div>
    <div class="mt-2 row">
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">¿Realizará trabajo en campo?</label>
            <input readonly type="text" class="form-control"
                value="{{ $requisicion->trabajo_campo == false ? 'NO' : 'SI' }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Años de experiencia:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->experiencia_years }}">
        </div>
    </div>
    <div class="mt-2 row">
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">¿Tendrá trato con clientes o proveedores?</label>
            <input readonly type="text" class="form-control"
                value="{{ $requisicion->trato_clientes == false ? 'NO' : 'SI' }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">¿Deberá tener la capacidad para el manejo de personal?</label>
            <input readonly type="text" class="form-control"
                value="{{ $requisicion->manejo_personal == false ? 'NO' : 'SI' }}">
        </div>
    </div>
    <div class="mt-2 row">
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">¿Se requiere licencia de conducir?</label>
            <input readonly type="text" class="form-control"
                value="{{ $requisicion->licencia_conducir == false ? 'NO' : 'SI' }}">
        </div>
        @if ($requisicion->licencia_conducir == true)
            <div class="col-md-6">
                <label class="m-0 form-label fw-bold">¿Se requiere licencia de conducir?</label>
                <input readonly type="text" class="form-control" value="{{ $requisicion->licencia_tipo }}">
            </div>
        @endif
    </div>
    @if (!empty($requisicion->puesto_nuevo))
        <hr>
        <div class="mt-2 row">
            <div class="col-md-12">
                <label class="m-0 form-label fw-bold">Principales conocimientos</label>
                <ul class="list-group">
                    @foreach ($requisicion->conocimientos as $conocimiento)
                        <li class="list-group-item">{{ $conocimiento }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-3 col-md-12">
                <label class="m-0 form-label fw-bold">Competencias</label>
                <ul class="list-group">
                    @foreach ($requisicion->competencias as $competencia)
                        <li class="list-group-item">{{ $conocimiento }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3 col-md-12">
                <label class="m-0 form-label fw-bold">Principales actividades</label>
                <ul class="list-group">
                    @foreach ($requisicion->actividades as $actividad)
                        <li class="list-group-item">{{ $actividad }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</x-card>

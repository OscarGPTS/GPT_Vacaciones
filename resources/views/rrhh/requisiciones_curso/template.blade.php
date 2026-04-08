<x-card>
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span
                        class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-1 rounded dark:bg-red-900 dark:text-red-300">Folio:
                        {{ $requisicion->id }}</span>
                </div>
                <div>
                    <span
                        class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-1 rounded dark:bg-red-900 dark:text-red-300">Estatus:
                        {{ $requisicion->status }} </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <p class="mt-2 fw-bold">Solicitante: {{ $solicitante->nombre() }}</p>
            <p class="fw-bold">Puesto: {{ $solicitante->job->name }}</p>
        </div>
        <hr class="my-2">
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Fecha de solicitud:</label>
            <div class="form-control">
                {{ $requisicion->created_at->format('Y-m-d') }}
            </div>
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Nombre del curso:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->nombre }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Tipo de capacitacion:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->tipo_capacitacion }}">
        </div>
        <div class="col-md-6">
            <label class="m-0 form-label fw-bold">Motivo:</label>
            <input readonly type="text" class="form-control" value="{{ $requisicion->motivo }}">
        </div>
    </div>
    <div class="my-2 row">
        @if (filled($participantes))
            <div class="col-md-12">
                <label class="m-0 form-label fw-bold">Participantes</label>
                <ul class="list-group">
                    @foreach ($participantes as $participante)
                        <li class="list-group-item">{{ $participante->nombre() }} - {{ $participante->job->name }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="m-0 form-label fw-bold">Beneficios</label>
            <div class="form-control">
                {{ $requisicion->beneficio }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="m-0 form-label fw-bold">Justificacion</label>
            <div class="form-control">
                {{ $requisicion->justificacion }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="m-0 form-label fw-bold">Comentarios</label>
            <div class="form-control">
                {{ $requisicion->comentarios }}
            </div>
        </div>
    </div>
    @if (filled($requisicion->cotizacion()) && filled($requisicion->temario()))
        <div class="pt-4 row">
            <div class="col-md-4">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 ">Documentación:</h2>
                <ul class="max-w-md space-y-1 text-gray-500 list-inside ">
                    <li>
                        <a href="{{ $requisicion->cotizacion()->getUrl()}}" target="_blank"  class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                              </svg>
                            <p>Cotización</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $requisicion->temario()->getUrl()}}" target="_blank"  class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                              </svg>
                            <p>Temario</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    @endif
</x-card>

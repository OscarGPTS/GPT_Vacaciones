<div>
    @if($myrequests->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tipo de Solicitud</th>
                        <th>Estado Jefe Directo</th>
                        <th>Estado RRHH</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myrequests as $request)
                        <tr wire:key="request-{{ $request->id }}">
                            <td>{{ $loop->iteration + ($myrequests->currentPage() - 1) * $myrequests->perPage() }}</td>
                            <td>
                                <span class="badge bg-info">{{ $request->type_request }}</span>
                            </td>
                            <td>
                                @if($request->direct_manager_status == 'Pendiente')
                                    <span class="badge bg-warning">{{ $request->direct_manager_status }}</span>
                                @elseif($request->direct_manager_status == 'Aprobada')
                                    <span class="badge bg-success">{{ $request->direct_manager_status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $request->direct_manager_status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($request->human_resources_status == 'Pendiente')
                                    <span class="badge bg-warning">{{ $request->human_resources_status }}</span>
                                @elseif($request->human_resources_status == 'Aprobada')
                                    <span class="badge bg-success">{{ $request->human_resources_status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $request->human_resources_status }}</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" 
                                        wire:click="showRequest({{ $request->id }})"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetails">
                                    <i class="fa fa-eye"></i> Ver
                                </button>
                                
                                @if($request->direct_manager_status == 'Pendiente' && $request->human_resources_status == 'Pendiente')
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            wire:click="deleteRequest({{ $request->id }})"
                                            onclick="return confirm('¿Estás seguro de eliminar esta solicitud?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $myrequests->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fa fa-calendar-times fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No tienes solicitudes</h4>
            <p class="text-muted">Aún no has creado ninguna solicitud de vacaciones o permisos.</p>
            <a href="{{ route('vacaciones.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Crear primera solicitud
            </a>
        </div>
    @endif

    <!-- Modal para detalles -->
    @if($request)
    <div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="modalDetailsLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailsLabel">
                        Detalles de la Solicitud #{{ $request->id }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Tipo de solicitud:</th>
                                    <td>{{ $request->type_request }}</td>
                                </tr>
                                <tr>
                                    <th>Forma de pago:</th>
                                    <td>{{ $request->payment }}</td>
                                </tr>
                                @if($request->start || $request->end)
                                <tr>
                                    <th>Horarios:</th>
                                    <td>
                                        @if($request->start) Salida: {{ $request->start }}<br> @endif
                                        @if($request->end) Regreso: {{ $request->end }} @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Motivo:</th>
                                    <td>{{ $request->reason }}</td>
                                </tr>
                                @if($request->opcion)
                                <tr>
                                    <th>Opción especial:</th>
                                    <td>{{ $request->opcion }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Estado Jefe Directo:</th>
                                    <td>
                                        @if($request->direct_manager_status == 'Pendiente')
                                            <span class="badge bg-warning">{{ $request->direct_manager_status }}</span>
                                        @elseif($request->direct_manager_status == 'Aprobada')
                                            <span class="badge bg-success">{{ $request->direct_manager_status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $request->direct_manager_status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado RRHH:</th>
                                    <td>
                                        @if($request->human_resources_status == 'Pendiente')
                                            <span class="badge bg-warning">{{ $request->human_resources_status }}</span>
                                        @elseif($request->human_resources_status == 'Aprobada')
                                            <span class="badge bg-success">{{ $request->human_resources_status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $request->human_resources_status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha creación:</th>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($request->approvedRequests && $request->approvedRequests->count() > 0)
                    <div class="mt-3">
                        <h6>Días solicitados:</h6>
                        <div class="row">
                            @foreach($request->approvedRequests as $day)
                                <div class="col-md-4 mb-2">
                                    <span class="badge bg-info">{{ \Carbon\Carbon::parse($day->start)->format('d/m/Y') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($request->doc_permiso)
                    <div class="mt-3">
                        <h6>Documentos adjuntos:</h6>
                        @foreach(explode(',', $request->doc_permiso) as $archivo)
                            <a href="{{ asset('storage/archivosPermisos/' . $archivo) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2 mb-2">
                                <i class="fa fa-file"></i> {{ Str::limit($archivo, 20) }}
                            </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Sección para subir justificante si está pendiente -->
                    @if($editarJustificante && $request->direct_manager_status == 'Pendiente')
                    <div class="mt-3">
                        <h6>Subir/Actualizar justificante:</h6>
                        <div class="mb-3">
                            <input type="file" wire:model="archivos_permiso" multiple class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            @error('archivos_permiso.*') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="button" class="btn btn-primary" wire:click="subirJustificante({{ $request->id }})">
                            Subir archivos
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="cambiarEditarJustificante">
                            Cancelar
                        </button>
                    </div>
                    @elseif(!$request->doc_permiso && $request->direct_manager_status == 'Pendiente')
                    <div class="mt-3">
                        <button type="button" class="btn btn-warning" wire:click="cambiarEditarJustificante">
                            <i class="fa fa-upload"></i> Agregar justificante
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mt-3">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('updateFile'))
        <div class="alert alert-info alert-dismissible fade show mt-3">
            {{ session('updateFile') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

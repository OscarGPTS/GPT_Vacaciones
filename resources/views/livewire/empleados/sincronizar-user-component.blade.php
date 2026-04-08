<div>
    <div class="row">
        <div class="col-lg-12">
            <div>
                <h2>Informacion del colaborador</h2>
            </div>
        </div>
    </div>
    <div class="mb-2 row">
        <div class="col-lg-12">
            <x-card>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img class="avatar" src="{{ $user->profile_image }}"
                            alt="imagen del user">
                        <div class="ms-2">
                            <h6>{{ $user->nombre() }}</h6>
                            <span>{{ $user->job->name }}</span>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-success" wire:click="sincronizarTodo">Sincronizar todo</button>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
    <div class="row">
        {{-- SATECH --}}
        <div class="col-md-6">
            <div class="rounded shadow-lg card">
                <div class="card-body">
                    <h5 class="card-title">Sistema SATECH</h5>
                    @if ($satech)
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Número de empleado:</strong>
                                <span> {{ $satech->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Puesto:</strong>
                                <span> {{ $satech->puesto }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Departamento:</strong>
                                <span> {{ $satech->depto }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Área:</strong>
                                <span> {{ $satech->area }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Admision:</strong>
                                <span> {{ $satech->admission }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Correo:</strong>
                                <span> {{ $satech->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Celular de la empresa:</strong>
                                <span> {{ $satech->phone }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Activo:</strong>
                                @if ($satech->active == 1)
                                    <span class="txt-success"> Si</span>
                                @else
                                    <span class="txt-danger"> No</span>
                                @endif
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success" wire:click="sincronizarUserSatech">Sincronizar
                        informacion</button>
                </div>
            </div>
        </div>
        {{-- IT --}}
        <div class="col-md-6">
            <div class="rounded shadow-lg card">
                <div class="card-body">
                    <h5 class="card-title">Sistema IT-Responsivas</h5>
                    @if ($it)
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Número de empleado:</strong>
                                <span> {{ $it->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Puesto:</strong>
                                <span> {{ $it->puesto }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Departamento:</strong>
                                <span> {{ $it->depto }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Área:</strong>
                                <span> {{ $it->area }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Razon social:</strong>
                                <span> {{ $it->razonSocial->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Admision:</strong>
                                <span> {{ $it->admission }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Correo:</strong>
                                <span> {{ $it->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Celular de la empresa:</strong>
                                <span> {{ $it->phone }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Activo:</strong>
                                @if ($it->active == 1)
                                    <span class="txt-success"> Si</span>
                                @else
                                    <span class="txt-danger"> No</span>
                                @endif
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success" wire:click="sincronizarUserIt">Sincronizar
                        informacion</button>
                </div>
            </div>
        </div>
        {{-- GptServices VCARD --}}
        <div class="col-md-6">
            <div class="rounded shadow-lg card">
                <div class="card-body">
                    <h5 class="card-title">Sistema Gpt services- VCARD</h5>
                    @if ($gpt)
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Número de empleado:</strong>
                                <span> {{ $gpt->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Puesto:</strong>
                                <span> {{ $gpt->puesto }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Empresa:</strong>
                                <span> {{ $gpt->empresa }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Correo:</strong>
                                <span> {{ $gpt->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Celular de la empresa 1:</strong>
                                <span> {{ $gpt->cel_1 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Celular de la empresa 1:</strong>
                                <span> {{ $gpt->cel_2 }}</span>
                            </li>
                            {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Activo:</strong>
                            @if ($gpt->active == 1)
                                <span class="txt-success"> Si</span>
                            @else
                                <span class="txt-danger"> No</span>
                            @endif
                        </li> --}}
                        </ul>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success" wire:click="sincronizarUserVcard">Sincronizar
                        informacion</button>
                </div>
            </div>
        </div>
        {{-- Cumpleaños --}}
        <div class="col-md-6">
            <div class="rounded shadow-lg card">
                <div class="card-body">
                    <h5 class="card-title">Sistema Gpt services- Cumpleaños</h5>
                    @if ($opreport)
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Número de empleado:</strong>
                                <span> {{ $opreport->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Cumpleaños:</strong>
                                <span> {{ $opreport->birthday }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Admision:</strong>
                                <span> {{ $opreport->admission }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Puesto:</strong>
                                <span> {{ $opreport->job }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Departamento:</strong>
                                <span> {{ $opreport->depto }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Área:</strong>
                                <span> {{ $opreport->area }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Correo:</strong>
                                <span> {{ $opreport->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Empresa:</strong>
                                <span> {{ $opreport->business }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Telefono:</strong>
                                <span> {{ $opreport->phone }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Activo:</strong>
                                @if ($opreport->empStatus == 1)
                                    <span class="txt-success"> Si</span>
                                @else
                                    <span class="txt-danger"> No</span>
                                @endif
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success" wire:click="sincronizarUserOpreport">Sincronizar
                        informacion</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    @endpush
</div>

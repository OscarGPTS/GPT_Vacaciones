<x-card title="Comprobante de estudios">
    <div x-data="{ tipo: @entangle('nivelEducativo') }">
        <div class="mb-2 row">
            <div class="col-md-4">
                <x-select label="Nivel educativo"
                    :options="['Primaria', 'Secundaria', 'Media superior', 'Superior', 'Maestria']"
                    wire:model="nivelEducativo" />
            </div>
        </div>
        <div class="my-3 col-md-12" x-show="tipo == 'Superior' || tipo == 'Maestria'" x-transition>
            <div x-show="tipo == 'Superior'">
                <x-select label="Tipo de carrera" :options="['Licenciatura', 'Ingeniería']" wire:model="tipoCarrera" />
            </div>
            <x-input wire:model="nombreCarrera" label="Nombre de la carrera o especialidad" maxlength="500" />
            <x-select label="¿Cuenta con título?" :options="['Si', 'No']" wire:model="titulo" />
            <x-select label="¿Cuenta con cédula?" :options="['Si', 'No']" wire:model="cedula" />
            <div class="mt-2">
                <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de
                    500KB.</span>
                <p>Si cuenta con cédula, cargar PDF</p>
                <x-forms.input-filepond wire:model.live="cedulaPDF" accept="application/pdf" maxFileSize="500KB" />
            </div>
            <hr>
        </div>
        <div class="col-md-12">
            <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 500KB.</span>
            <p>PDF del comprobante de estudios</p>
            <x-forms.input-filepond wire:model.live="comprobanteEstudio" accept="application/pdf" maxFileSize="500KB" />
        </div>
    </div>
    <div>
        <table class="table table-sm ">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nivel educativo
                    </th>
                    <th scope="col" class="p-2">
                        Fecha de subida
                    </th>
                    <th scope="col" class="p-2">
                        Ver
                    </th>
                    @can('ver modulo rrhh')
                    <th>
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (filled($comprobanteEstudiosCollect))
                @foreach ($comprobanteEstudiosCollect as $key => $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->created_at->isoFormat('LLL') }}</td>
                    <td>
                        <x-button.circle positive icon="eye" href="{{ $item->getUrl() }}" target="_blank" />
                    </td>
                    @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash"
                            wire:click="deleteFile('comprobante_estudios',{{ $key }})"
                            spinner="deleteFile('comprobante_estudios',{{ $key }})" />
                    </td>
                    @endcan
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @if (filled($cedulaCollect))
    <div class="mt-3">
        <table class="table table-sm ">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Cédula
                    </th>
                    <th scope="col" class="p-2">
                        Ver
                    </th>
                    {{-- @can('ver modulo rrhh')
                    <th>
                    </th>
                    @endcan --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($cedulaCollect as $key => $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>
                        <x-button.circle positive icon="eye" href="{{ $item->getUrl() }}" target="_blank" />
                    </td>
                    {{-- @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash"
                            wire:click="deleteFile('comprobante_estudios',{{ $key }})"
                            spinner="deleteFile('comprobante_estudios',{{ $key }})" />
                    </td>
                    @endcan --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarComprobanteEstudio' spinner='guardarComprobanteEstudio' />
    </x-slot>
</x-card>

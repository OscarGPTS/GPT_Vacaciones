<x-card title="Identificación oficial">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-2">
                <x-datetime-picker label="Fecha de vencimiento" wire:model="fechaVigencia" without-time="true" />
            </div>
        </div>
    </div>
    <p>Cargar PDF</p>
    <x-forms.input-filepond wire:model.live="identificacionOficial" accept="application/pdf" maxFileSize="500KB" />
    <div>
        <table class="table table-sm " id="comprobante-domicilio">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nombre
                    </th>
                    <th scope="col" class="p-2">
                        Vigencia
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
                @if (filled($this->identificacionOficialCollect))
                @foreach ($this->identificacionOficialCollect as $key => $identificacion)
                <tr>
                    <td>{{ $identificacion->name }}</td>
                    <td>{{ $identificacion->getCustomProperty('fecha_vigencia') }}</td>
                    <td>{{ $identificacion->created_at }}</td>
                    <td>
                        <x-button.circle positive icon="eye" href="{{ $identificacion->getUrl() }}" target="_blank" />
                    </td>
                    @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash"
                            wire:click="deleteFile('identificacion_oficial',{{ $key }})"
                            spinner="deleteFile('identificacion_oficial',{{ $key }})" />
                    </td>
                    @endcan
                </tr>

                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarIdentificacionOficial'
            spinner='guardarIdentificacionOficial' />
    </x-slot>
</x-card>

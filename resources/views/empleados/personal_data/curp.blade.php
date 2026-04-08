<x-card title="CURP">
    <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 500KB.</span>
    <p>Cargar PDF</p>
    <x-forms.input-filepond wire:model.live="curp" accept="application/pdf" maxFileSize="500KB" />
    <div>
        <table class="table table-sm " id="comprobante-domicilio">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nombre
                    </th>
                    <th scope="col" class="p-2">
                        Link
                    </th>
                    <th scope="col" class="p-2">
                        Fecha de subida
                    </th>
                    @can('ver modulo rrhh')
                    <th>
                    </th>
                    @endcan
            </thead>
            <tbody>
                @if (filled($this->curpCollect))
                @foreach ($this->curpCollect as $key => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>
                        <x-button.circle positive icon="eye" href="{{ $item->getUrl() }}" target="_blank" />
                    </td>
                    @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash" wire:click="deleteFile('curp',{{ $key }})"  spinner="deleteFile('curp',{{ $key }})"/>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarCurp' spinner='guardarCurp' />
    </x-slot>
</x-card>

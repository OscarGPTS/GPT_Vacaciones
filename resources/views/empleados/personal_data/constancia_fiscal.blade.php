<x-card title="Constancia de situación fiscal">
    <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 500KB.</span>
    <p>Cargar PDF</p>
    <x-forms.input-filepond wire:model.live="constanciaFiscal" accept="application/pdf" maxFileSize="500KB"/>
    <div>
        <table class="table table-sm " id="comprobante-domicilio">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nombre
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
                @if (filled($constanciaFiscalCollect))
                    @foreach ($constanciaFiscalCollect as $key => $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->created_at->isoFormat('LLL') }}</td>
                            <td> <x-button.circle positive icon="eye" href="{{ $item->getUrl() }}" target="_blank" />
                            </td>
                            @can('ver modulo rrhh')
                            <td>
                                <x-button.circle negative icon="trash" wire:click="deleteFile('constancia_fiscal',{{ $key }})"  spinner="deleteFile('constancia_fiscal',{{ $key }})"/>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarConstanciaFiscal' spinner='guardarConstanciaFiscal' />
    </x-slot>
</x-card>

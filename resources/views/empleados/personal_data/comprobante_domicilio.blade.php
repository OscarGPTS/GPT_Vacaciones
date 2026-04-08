<x-card title="Comprobante de domicilio">
    <span class="font-bold text-danger">NOTA: Solo se aceptan archivos PDF con un peso máximo de 500KB.</span>
    <p>Cargar PDF</p>
    <div class="mt-1">
        {{-- <livewire:dropzone wire:model="comprobanteDomicilio" :rules="['mimes:pdf','max:550']" :multiple="false" /> --}}
    </div>
    <x-forms.input-filepond wire:model.live="comprobanteDomicilio" accept="application/pdf" maxFileSize="500KB" />
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
                        Link
                    </th>
                    @can('ver modulo rrhh')
                    <th>
                    </th>
                    @endcan
            </thead>
            <tbody>
                @if (filled($comprobanteDomicilioCollect))
                @foreach ($comprobanteDomicilioCollect as $key => $comprobante)
                <tr>
                    <td>{{ $comprobante['name'] }}</td>
                    <td>{{ $comprobante['created_at'] }}</td>
                    <td>
                        <x-button.circle positive icon="eye" href="{{ $comprobante->getUrl() }}" target="_blank" />
                    </td>
                    @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash" wire:click="deleteFile('comprobante_domicilio',{{ $key }})"  spinner="deleteFile('comprobante_domicilio',{{ $key }})"/>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarComprobanteDomicilio'
            spinner='guardarComprobanteDomicilio' />
    </x-slot>
</x-card>

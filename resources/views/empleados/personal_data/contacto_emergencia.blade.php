<x-card title="Contacto de emergencia">
    <div>
        <table class="table table-sm" id="contactos-emergencia-table">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nombre
                    </th>
                    <th scope="col" class="p-2">
                        Telefono
                    </th>
                    <th scope="col" class="p-2">
                        Parentesco
                    </th>
                    @can('ver modulo rrhh')
                    <th></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (filled($contactos))
                @foreach ($contactos as $key=> $contactoItem)
                <tr>
                    <td>{{ $contactoItem['nombre'] }}</td>
                    <td>{{ $contactoItem['tel'] }}</td>
                    <td>{{ $contactoItem['parentesco'] }}</td>
                    @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash" wire:click="deleteContacto({{ $key }})"
                            spinner="deleteContacto({{ $key }})" />
                    </td>
                    @endcan
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Agregar" onclick="$openModal('contactoModal')" positive />
    </x-slot>
</x-card>

{{-- modal --}}
<x-modal.card title="Contacto de emergencia" wire:model="contactoModal">
    <div class="row">
        <div class="col-md-4">
            <x-input wire:model="contacto.nombre" label="Nombre" />
        </div>
        <div class="col-md-4">
            <x-inputs.phone wire:model="contacto.tel" label="Telefono" mask="['(##) ####-####']" />
        </div>
        <div class="col-md-4">
            <x-input wire:model="contacto.parentesco" label="Parentesco" />
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button flat label="Cancelar" x-on:click="close" />
            <x-button primary label="Guardar" wire:click="guardarContacto" spinner="guardarContacto" />
        </div>
    </x-slot>
</x-modal.card>

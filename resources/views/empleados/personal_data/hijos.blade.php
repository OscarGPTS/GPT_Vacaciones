<x-card title="Hijos">
    <div>
        <table class="table table-sm" id="hijos-table">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Nombre
                    </th>
                    <th scope="col" class="p-2">
                        Fecha de nacimiento
                    </th>
                    @can('ver modulo rrhh')
                    <th>

                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (filled($hijos))
                @foreach ($hijos as $key => $hijo)
                <tr>
                    <td>{{ $hijo['nombre'] }}</td>
                    <td>{{ $hijo['fecha_nacimiento'] }}</td>
                    @can('ver modulo rrhh')
                    <td>
                        <x-button.circle negative icon="trash" wire:click="deleteHijo({{ $key }})"  spinner="deleteHijo({{ $key }})"/>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Agregar" onclick="$openModal('hijoModal')" positive />
    </x-slot>
</x-card>
{{-- modal --}}
<x-modal.card title="Hijo" wire:model="hijoModal">
    <div>
        <x-input wire:model="hijo.nombre" label="Nombre" />
        <x-datetime-picker label="Fecha de nacimiento" wire:model="hijo.fecha_nacimiento" without-time="true" />
    </div>
    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button flat label="Cancelar" x-on:click="close" />
            <x-button primary label="Guardar" wire:click="guardarHijo" spinner="guardarHijo" />
        </div>
    </x-slot>
</x-modal.card>

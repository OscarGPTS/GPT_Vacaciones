<x-card title="Alergias">
    <div>
        <table class="table table-sm" id="hijos-table">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Tipo
                    </th>
                    @can('ver modulo rrhh')
                    <th>
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (filled($alergiaCollect))
                    @foreach ($alergiaCollect as $key => $alergia)
                        <tr>
                            <td>{{ $alergia }}</td>
                            @can('ver modulo rrhh')
                            <td>
                                <x-button.circle negative icon="trash" wire:click="deleteAlergia({{ $key }})"
                                    spinner="deleteAlergia({{ $key }})" />
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Agregar" onclick="$openModal('alergiaModal')" positive />
    </x-slot>
</x-card>
{{-- modal --}}
<x-modal.card title="Agregar alergia" wire:model="alergiaModal">
    <div>
        <x-input wire:model="tipoAlergia" label="Tipo de alergia" />

    </div>
    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button flat label="Cancelar" x-on:click="close" />
            <x-button primary label="Guardar" wire:click="guardarAlergia" spinner="guardarAlergia" />
        </div>
    </x-slot>
</x-modal.card>

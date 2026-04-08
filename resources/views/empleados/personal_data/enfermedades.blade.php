<x-card title="Enfermedades">
    <div>
        <table class="table table-sm" id="hijos-table">
            <thead>
                <tr>
                    <th scope="col" class="p-2">
                        Tipo
                    </th>
                    <th scope="col" class="p-2">
                        Tratamiento
                    </th>
                    @can('ver modulo rrhh')
                    <th>
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if (filled($enfermedadCollect))
                    @foreach ($enfermedadCollect as $key => $enfermedad)
                        <tr>
                            <td>{{ $enfermedad['tipo'] }}</td>
                            <td>{{ $enfermedad['tratamiento'] }}</td>
                            @can('ver modulo rrhh')
                            <td>
                                <x-button.circle negative icon="trash" wire:click="deleteEnfermedad({{ $key }})"
                                    spinner="deleteEnfermedad({{ $key }})" />
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <x-slot name="footer">
        <x-button label="Agregar" onclick="$openModal('enfermedadModal')" positive />
    </x-slot>
</x-card>
{{-- modal --}}
<x-modal.card title="Agregar enfermedad" wire:model="enfermedadModal">
    <div>
        <x-input wire:model="enfermedad.tipo" label="¿Cuál es la enfermedad?" />
    </div>
    <div class="mt-2">
        <x-textarea wire:model="enfermedad.tratamiento" cols="20" rows="10" />
    </div>
    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button flat label="Cancelar" x-on:click="close" />
            <x-button primary label="Guardar" wire:click="guardarEnfermedad" spinner="guardarEnfermedad" />
        </div>
    </x-slot>
</x-modal.card>

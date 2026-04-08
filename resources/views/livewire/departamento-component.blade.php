<div>
    <div class="row">
        <div class="col-md-12">
            <x-card title="Departamentos" padding="px-4 py-4">
                <x-slot name="action">
                    <x-button positive label="Nuevo departamento" wire:click="crear" />
                </x-slot>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Área</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($departamentos)
                            @foreach ($departamentos as $departamento)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $departamento->name }}</td>
                                    <td>{{ $departamento->area->name}}</td>
                                    <td>
                                        <x-button warning label="Editar"
                                            wire:click="editar('{{ $departamento->id }}')" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>
    {{-- Modal --}}
    <x-modal blur wire:model="modal">
        <x-card title="Departamento">
            <form>
                <x-input wire:model="depto.name" label="Nombre" />
                <x-select label="Área"  :options="$areas" option-value="id" option-label="name"
                    wire:model="depto.area_id" />
            </form>
            <x-slot name="footer">
                <div class="flex justify-between items-center">
                    <x-button label="Cancelar" flat negative x-on:click="close" />
                    <x-button label="Guardar" positive wire:click="guardar" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>

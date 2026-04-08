<div>
    <div class="row">
        <div class="col-md-12">
            <x-card title="Areas" padding="px-4 py-4">
                <x-slot name="action">
                    <x-button positive label="Nueva área" wire:click="crear" />
                </x-slot>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($areas)
                            @foreach ($areas as $area)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $area->name }}</td>
                                    <td>
                                        <x-button warning label="Editar" wire:click="editar('{{ $area->id }}')" />
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
       <x-card title="Área">
            <form>
                <x-input wire:model="area.name" label="Nombre" />
            </form>
            <x-slot name="footer">
                <div class="flex items-center justify-between">
                    <x-button label="Cancelar" flat negative  x-on:click="close"/>
                    <x-button label="Guardar" positive wire:click="guardar" spinner="guardar" loading-delay="short" />
                </div>
            </x-slot>
       </x-card>
    </x-modal>
</div>

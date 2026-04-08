<div>
    <x-button primary label="Nuevo puesto" onclick="$openModal('modal')"/>
    {{-- Modal --}}
    <x-modal blur wire:model="modal">
        <x-card title="Nuevo puesto">
            <form class="px-4">
                <div class="mb-4">
                    <x-input label="Nombre" wire:model.blur="puesto.name" />
                </div>
                <div class="mb-4">
                    <x-select label="Departamento" :options="$departamentos" option-label="name" option-value="id"
                        wire:model.blur="puesto.depto_id" />
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button positive label="Guardar" wire:click="guardar" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>

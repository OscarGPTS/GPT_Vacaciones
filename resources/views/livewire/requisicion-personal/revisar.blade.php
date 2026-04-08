<div>
    <x-card>
        <form>
            <div class="mb-3">
                <x-textarea label="Escriba el motivo de su respuesta" wire:model='motivo' rows="6"
                    maxlength="255" />
            </div>
        </form>
        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <x-button label="Rechazar" negative wire:click="respuesta('rechazar')" />
                <x-button label="Aceptar" positive wire:click="respuesta('aceptar')" />
            </div>
        </x-slot>
    </x-card>
</div>

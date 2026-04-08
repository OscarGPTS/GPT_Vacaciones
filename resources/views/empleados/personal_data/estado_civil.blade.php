<x-card title="Estado Civil">
    <div x-data="{ tipo: @entangle('estadoCivil.tipo') }">
        <div class="row">
            <div class="col-md-4">
                <x-select label="Tipo" :options="['Soltero', 'Casado', 'Unión libre']" wire:model.live="estadoCivil.tipo" />
            </div>
            <div class="col-md-4">
                <div x-show="tipo == 'Casado' || tipo == 'Unión libre'" x-transition>
                    <x-input wire:model="estadoCivil.nombre_pareja" label="Nombre de la pareja"
                        maxlength="100" />
                </div>
            </div>
            <div class="col-md-4">
                <div x-show="tipo == 'Casado' || tipo == 'Unión libre'" x-transition>
                    <x-input wire:model="estadoCivil.telefono_pareja" label="Telefono de la pareja"
                        maxlength="30" />
                </div>
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarEstadoCivil' spinner='guardarEstadoCivil' />
    </x-slot>
</x-card>

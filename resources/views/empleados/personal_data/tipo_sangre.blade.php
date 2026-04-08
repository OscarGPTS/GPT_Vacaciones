<x-card title="Tipo de sangre">
    <div class="mb-2 row">
        <div class="col-md-4">
            <x-select label="Tipo" :options="['A positivo (A+)','A negativo (A-)','B positivo (B+)','B negativo (B-)','AB positivo (AB+)','AB negativo (AB-)','O positivo (O+)','O negativo (O-)']" wire:model="tipoSangre" />
        </div>
    </div>
    <div>
        <p>
            Tipo de sangre: {{ $personalData->tipo_sangre }}
        </p>
    </div>
    <x-slot name="footer">
        <x-button label="Guardar" positive wire:click='guardarTipoSangre' spinner='guardarTipoSangre' />
    </x-slot>
</x-card>

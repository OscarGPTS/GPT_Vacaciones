<div class="row">
    <div class="col-lg-12">
        <x-card padding="px-4 py-5">
            <form class="row g-3">
                <div class="col-md-4">
                    @if ($view == 'create')
                        <x-input wire:model="empleado.id" label="Número del empleado" />
                    @else
                        <p class="fw-bold">Número del empleado</p>
                        <x-badge lg flat primary label="{{ $empleado->id }}" />
                    @endif
                </div>
                <div class="col-md-4">
                    <x-input wire:model="empleado.first_name" label="Nombre" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="empleado.last_name" label="Apellidos" />
                </div>
                <div class="col-md-4">
                    <x-datetime-picker label="Admision" wire:model="empleado.admission" without-time="false"
                        :max="now()->addDays(14)" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="empleado.email" label="Correo" />
                </div>
                <div class="col-md-4">
                    <x-select label="Puestos" :options="$puestos" wire:model.live="puestoId" option-label="name"
                        option-value="id" />
                    @if (filled($puesto))
                        <div>
                            <p class="m-0">Departamento: {{ $puesto->departamento->name }}</p>
                            <p class="m-0">Área: {{ $puesto->departamento->area->name }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <x-select label="Razon social" :options="$razonSocial" wire:model="empleado.business_name_id"
                        option-label="name" option-value="id" />
                </div>
                <div class="col-md-4">
                    <x-select label="Jefe inmediato" :options="$empleados" wire:model="empleado.boss_id"
                        option-label="first_name" option-description="last_name" option-value="id" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="empleado.phone" label="Telefono de la empresa" />
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-select label="Activo" :options="[['id' => 1, 'name' => 'SI'], ['id' => 2, 'name' => 'NO']]" wire:model="empleado.active" option-label="name"
                            option-value="id" />
                    </div>
                    <div class="col-md-4">
                        <x-input label="Libreta de mar" wire:model="empleado.libreta_mar" />
                    </div>
                </div>
                <div class="row" x-data="{ escolaridad: @entangle('empleado.escolaridad').live }">
                    <div class="col-md-4">
                        <x-select label="Escolaridad" :options="['Primaria', 'Secundaria', 'Bachillerato', 'Licenciatura','Carrera Técnica', 'Maestría']" wire:model.live="empleado.escolaridad" />
                    </div>
                    <div class="col-md-4" x-show="escolaridad == 'Licenciatura'" x-transition>
                        <x-input label="Cédula" wire:model="empleado.cedula" placeholder="123456" />
                    </div>
                    <div class="col-md-4" x-show="escolaridad == 'Licenciatura'" x-transition>
                        <x-input label="Nombre de la licenciatura" wire:model="empleado.escolaridad_nombre"
                            placeholder="Licenciatura en Ingeniería Química Petrolera " />
                    </div>
                </div>
                <hr>
                <div class="col-md-4">
                    <x-datetime-picker label="Cumpleaños" wire:model="personalData.birthday" without-time="false" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="personalData.curp" label="CURP" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="personalData.rfc" label="RFC" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="personalData.nss" label="NSS" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="personalData.personal_mail" label="Correo personal" />
                </div>
                <div class="col-md-4">
                    <x-input wire:model="personalData.personal_phone" label="Telefono personal" />
                </div>
                <div class="col-12">
                    <x-button positive label="Guardar" wire:click="guardar" spinner="guardar" loading-delay="short" />
                </div>
            </form>
        </x-card>
    </div>
</div>

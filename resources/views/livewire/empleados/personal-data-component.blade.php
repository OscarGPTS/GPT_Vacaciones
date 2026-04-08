<div>
    @can ('ver modulo rrhh')
        <div class="row">
            <div class="col-lg-12">
                <nav class="breadcrumb breadcrumb-icon">
                    <li class="breadcrumb-item">
                        <a href="{{ route('empleados.index') }}">Lista de empleados</a>
                    </li>
                    <li class="breadcrumb-item">Empleado</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('empleados.show', $personalData->user_id) }}">{{ $personalData->user_id }}</a>
                    </li>
                </nav>
            </div>
        </div>
    @endcan
    <div class="mb-2 row">
        <div class="col-md-4">
            <x-select label="Da clic para desplegar la lista y llenar la información"
             :options="$opciones" wire:model.live="opcion" option-label="name"
                option-value="id" />
        </div>
        <div class="col-md-8">
            <div class="text-end">
                <x-button icon="document-download" positive label="Descargas documentos" wire:click="downloadFiles" spinner="downloadFiles" loading-delay="long"  />
            </div>
        </div>
    </div>
    <div class="row" x-data="{ opcion: $wire.entangle('opcion') }">
        {{-- Estado Civil --}}
        <div class="col-md-12" x-show="opcion == 1" x-transition x-cloak>
            @include('empleados.personal_data.estado_civil')
        </div>
        {{-- Hijos --}}
        <div class="col-md-12" x-show="opcion == 2" x-transition x-cloak>
            @include('empleados.personal_data.hijos')
        </div>
        {{-- Comprobante de domicilio --}}
        <div class="col-md-12" x-show="opcion == 3" x-transition x-cloak>
            @include('empleados.personal_data.comprobante_domicilio')
        </div>
        {{-- contacto de emergencia --}}
        <div class="col-md-12" x-show="opcion == 4" x-transition x-cloak>
            @include('empleados.personal_data.contacto_emergencia')
        </div>
        {{-- constancia situacion fiscal --}}
        <div class="col-md-12" x-show="opcion == 5" x-transition x-cloak>
            @include('empleados.personal_data.constancia_fiscal')
        </div>
        {{-- cursos externos --}}
        <div class="col-md-12" x-show="opcion == 6" x-transition x-cloak>
            @include('empleados.personal_data.curso_externo')
        </div>
        {{-- comprobante de estudio --}}
        <div class="col-md-12" x-show="opcion == 7" x-transition x-cloak>
            @include('empleados.personal_data.comprobante_estudios')
        </div>
        {{-- alergias --}}
        <div class="col-md-12" x-show="opcion == 8" x-transition x-cloak>
            @include('empleados.personal_data.alergias')
        </div>
        {{-- tipo de sangre --}}
        <div class="col-md-12" x-show="opcion == 9" x-transition x-cloak>
            @include('empleados.personal_data.tipo_sangre')
        </div>
        {{-- enfermedades --}}
        <div class="col-md-12" x-show="opcion == 10" x-transition x-cloak>
            @include('empleados.personal_data.enfermedades')
        </div>
        {{-- enfermedades --}}
        <div class="col-md-12" x-show="opcion == 11" x-transition x-cloak>
            @include('empleados.personal_data.identificacion_oficial')
        </div>
        {{-- curp --}}
        <div class="col-md-12" x-show="opcion == 12" x-transition x-cloak>
            @include('empleados.personal_data.curp')
        </div>
        {{-- pasaporte --}}
        <div class="col-md-12" x-show="opcion == 13" x-transition x-cloak>
            @include('empleados.personal_data.pasaporte')
        </div>
        {{-- pasaporte --}}
        <div class="col-md-12" x-show="opcion == 14" x-transition x-cloak>
            @include('empleados.personal_data.visa')
        </div>
    </div>
</div>

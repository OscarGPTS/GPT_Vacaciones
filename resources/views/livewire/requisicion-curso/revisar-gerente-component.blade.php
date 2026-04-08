<div>
    <div class="row">
        <div class="col-md-12">
            <nav class="breadcrumb breadcrumb-icon">
                <li class="breadcrumb-item">
                    <a href="{{ route('gerente.requisiciones.curso.indexGerente') }}">Lista de solicitudes</a>
                </li>
                <li class="breadcrumb-item">Ver</li>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            @include('perfil.requisiciones_curso.template')
        </div>
        <div class="col-md-4">
            @if ($requisicion->status()->canBe('En revisión por dirección general') || $requisicion->status()->canBe('Rechazada por gerente'))
            <x-card title="Revisión">
                <form>
                    <x-textarea label="Observaciones" wire:model='observaciones' maxlength="499" />
                </form>
                <x-slot name="footer">
                    <div class="flex items-center justify-between">
                        <x-button label="Rechazar"  negative wire:click="respuesta('rechazado')" spinner="respuesta" loading-delay="long" />
                        <x-button label="Aceptar" positive wire:click="respuesta('aceptado')" spinner="respuesta" loading-delay="long" />
                    </div>
                </x-slot>
            </x-card>
            @endif
        </div>
    </div>
</div>

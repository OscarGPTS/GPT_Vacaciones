@extends('layouts.codebase.master')
{{-- @extends('layouts.flowbite.master') --}}
@push('css')
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('empleados.show', $empleado->id) }}">Empleado</a>
            </li>
            <li class="breadcrumb-item">Editar</li>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div>
            <h2>Información del colaborador</h2>
        </div>
        <div>

        </div>
    </div>
</div>

@livewire('empleados.create', ['view' => 'edit', 'empleado' => $empleado->id])
<!-- Script para poder validar formularios -->
@push('scripts')
@endpush
@endsection

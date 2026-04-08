@extends('layouts.codebase.master')
{{-- @extends('layouts.flowbite.master') --}}

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <nav class="breadcrumb breadcrumb-icon">
                <li class="breadcrumb-item">
                    <a href="{{ route('empleados.index') }}">Lista de empleados</a>
                </li>
                <li class="breadcrumb-item">Nuevo colaborador</li>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div>
                <h2>Crear nuevo colaborador</h2>
            </div>
        </div>
    </div>
    @livewire('empleados.create')
@endsection

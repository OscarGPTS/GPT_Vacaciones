@extends('layouts.codebase.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('empleados.index') }}">Lista de empleados</a>
            </li>
            <li class="breadcrumb-item">Empleado</li>
            <li class="breadcrumb-item">
                <a href="{{ route('empleados.show', $user->id) }}">{{ $user->id }}</a>
            </li>
        </nav>
    </div>
</div>
<div class="mb-2 row">
    <div class="col-md-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">Editar curriculum del colaborador</h4>
                <div class="flex-row gap-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <strong>{{ $user->nombre() }}</strong>
                        <small>{{ $user->job->name }}</small>
                    </div>
                    <x-button teal icon="document-text" spinner href="{{ route('empleados.cv.otros.pdf', $user) }}" />
                </div>
            </div>
        </x-card>
    </div>
</div>
@livewire('perfil.cv-component', ['editRrhh' => true, 'user' => $user])
@endsection
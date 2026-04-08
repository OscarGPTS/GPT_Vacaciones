@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hint.min.css') }}">
@endpush
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('empleados.show', $empleado->id) }}">Empleado</a>
            </li>
            <li class="breadcrumb-item">Sincronizar</li>
            <li class="breadcrumb-item">{{ $empleado->id }}</li>
        </nav>
    </div>
</div>
@livewire('empleados.sincronizar-user-component', ['user_id' => $empleado->id])
@endsection
@extends('layouts.codebase.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('perfil.requisiciones.personal.index') }}">Lista de solicitudes</a>
            </li>
            <li class="breadcrumb-item">Ver</li>
        </nav>
    </div>
</div>

<div class="mb-2 row">
    <div class="col-lg-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">Requisición de personal solicitada</h5>
            </div>
        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        @include('perfil.requisiciones_personal.solicitud')
    </div>
    <div class="col-md-5">
        @include('perfil.requisiciones_personal.historial')
    </div>
</div>
@endsection
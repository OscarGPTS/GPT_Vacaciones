@extends('layouts.codebase.master')
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <nav class="breadcrumb breadcrumb-icon">
                <li class="breadcrumb-item">
                    <a href="{{ route('rrhh.requisiciones.curso.historial') }}">Historial de solicitudes</a>
                </li>
                <li class="breadcrumb-item">Ver</li>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('perfil.requisiciones_curso.template')
        </div>
        <div class="col-md-12">
            @include('perfil.requisiciones_curso.historial')
        </div>
    </div>
</div>
@endsection

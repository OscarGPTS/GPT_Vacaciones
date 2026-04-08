@extends('layouts.codebase.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('requisiciones.curso.index') }}">Lista de solicitudes</a>
            </li>
            <li class="breadcrumb-item">Ver</li>
        </nav>
    </div>
</div>
@include('perfil.requisiciones_curso.template')
@endsection
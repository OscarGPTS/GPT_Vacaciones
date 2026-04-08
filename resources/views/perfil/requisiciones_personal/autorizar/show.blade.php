@extends('layouts.codebase.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('perfil.requisiciones.personal.autorizar.index') }}">Lista de solicitudes</a>
            </li>
            <li class="breadcrumb-item">Revisar</li>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <x-card>
            <h5 class="m-0">Requisición de personal para revisar</h5>
        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <x-card>
            @include('perfil.requisiciones_personal.solicitud')
        </x-card>
    </div>
    @if (
    $requisicion->status()->canBe('en reclutamiento') ||
    $requisicion->status()->canBe('rechazada por dirección general'))
    <div class="col-lg-5">
        @livewire('requisicion-personal.autorizar', ['requisicion' => $requisicion])
    </div>
    @endif
</div>
@endsection
@extends('layouts.codebase.master')
@section('content')
@push('css')
@endpush

<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('perfil.requisiciones.personal.revisar.index') }}">Lista de solicitudes</a>
            </li>
            <li class="breadcrumb-item">Revisar</li>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">Requisición de personal para revisar</h5>
            </div>
        </x-card>

    </div>
</div>
<div class="row">
    <div class='col-lg-7'>
        <x-card>
            @include('perfil.requisiciones_personal.solicitud')
        </x-card>
    </div>
    @if (
    $requisicion->status()->canBe('en revisión por dirección general') ||
    $requisicion->status()->canBe('rechazada por jefe directo'))
    <div class="col-lg-5">
        @livewire('requisicion-personal.revisar', ['requisicion' => $requisicion])
    </div>
    @endif
</div>
@push('scripts')
@endpush
@endsection
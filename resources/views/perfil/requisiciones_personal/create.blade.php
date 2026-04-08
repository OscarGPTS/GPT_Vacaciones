@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
@endpush
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('perfil.requisiciones.personal.index') }}">Lista de requisiciones</a>
            </li>
            <li class="breadcrumb-item">Nueva requisición</li>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 mb-2">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">Requisición de personal</h5>
                <p class="m-0">Ingresa los datos solicitados.</p>
            </div>
        </x-card>
    </div>
</div>
@livewire('requisicion-personal.create')
@push('scripts')
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
@endpush
@endsection
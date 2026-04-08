@extends('layouts.pruebas.index')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hint.min.css') }}">
    @endpush
    {{-- <div class="row">
        <div class="col-lg-12">
            <nav class="breadcrumb breadcrumb-icon">
                <li class="breadcrumb-item">
                    <a href="{{ route('empleados.index') }}">Lista de empleados</a>
                </li>
            </nav>
        </div>
    </div> --}}
    @livewire('empleados.upload-excel-component')
@endsection

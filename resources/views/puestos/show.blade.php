@extends('layouts.codebase.master')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a class="active" href="{{ route('puestos.index') }}">Puestos</a>
            </li>
            <li class="breadcrumb-item">Descripción del puesto</li>
        </nav>
    </div>
    <div class="col-md-6 text-end">
        <x-button negative icon="document" label="PDF" href="{{ route('puestos.pdf', $puesto) }}" />
    </div>
</div>
<div class="pb-5">
    @livewire('puestos.descripcion', ['puesto' => $puesto])
</div>
@endsection
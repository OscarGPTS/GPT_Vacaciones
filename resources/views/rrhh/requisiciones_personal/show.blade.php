@extends('layouts.codebase.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('rrhh.requisiciones.personal.index') }}">Lista de solicitudes</a>
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
                <div>
                    <a href="{{ route('rrhh.requisiciones.personal.pdf', $requisicion->id) }}"
                        class="px-3 btn btn-success" target="_blank"><i class="fa fa-file-pdf-o me-2"></i>Ver PDF</a>
                    @if ($requisicion->estatus == 1 || $requisicion->estatus == 2)
                    <form class="d-inline"
                        action="{{ route('rrhh.requisiciones.personal.notificar', $requisicion->id) }}" method="POST">
                        @method('POST')
                        @csrf
                        <button type="submit" class="px-3 btn btn-info"><i class="fa fa-link me-2"></i>Reenviar
                            link de aprobación</button>
                    </form>
                    @endif
                    @if ($requisicion->status()->canBe('finalizada'))
                    <form class="d-inline"
                        action="{{ route('rrhh.requisiciones.personal.finalizar', $requisicion->id) }}" method="POST">
                        @method('POST')
                        @csrf
                        <button type="submit" class="px-3 btn btn-success">
                            <i class="fa fa-check-circle-o me-2"></i>Finalizar solicitud
                        </button>
                    </form>
                    @endif
                </div>
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
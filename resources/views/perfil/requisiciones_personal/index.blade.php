@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush
<div class="mb-2 row">
    <div class="col-lg-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0">Lista de requisiciones de personal</h5>
                <x-button primary label="Nueva requisición"
                    href="{{ route('perfil.requisiciones.personal.create') }}" />
            </div>

        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <table class="table text-center" id="tabla-basica">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Puesto solicitado</th>
                        <th>Personas requeridas</th>
                        <th>Fecha de solicitud</th>
                        <th>Estatus</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisiciones as $requisicion)
                    <tr>
                        <th scope="row">{{ $requisicion->folio() }}</th>
                        <td>
                            @isset($requisicion->puesto)
                            @if ($requisicion->puesto->id == 73)
                            Nueva creación
                            @else
                            {{ $requisicion->puesto->name }}
                            @endif
                            @else
                            Nueva creación
                            @endisset
                        </td>
                        <td>{{ $requisicion->personas_requeridas }}</td>
                        <td>{{ $requisicion->created_at }}</td>
                        <td>
                            {{ $requisicion->status }}
                        </td>
                        <td>
                            <x-button green icon="eye"
                                href="{{ route('perfil.requisiciones.personal.show', $requisicion->id) }}" />
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/datatable/jquery-3.7.0.js') }}"></script>
<script src="{{ asset('assets/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush
@endsection
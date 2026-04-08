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
            </div>
        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <div class="table-responsive-md">
                <table class="table text-center" id="tabla-basica">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Solicitante</th>
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
                            <td>{{ $requisicion->solicitante->nombre() }}</td>
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
                                @switch($requisicion->estatus)
                                @case(1)
                                <a href="{{ route('perfil.requisiciones.personal.revisar.show', $requisicion->id) }}"
                                    class="btn btn-success hint--left" aria-label="Ver requisición"><i
                                        class="fa fa-eye"></i>
                                </a>
                                @break

                                @default
                                <a href="{{ route('perfil.requisiciones.personal.revisar.show', $requisicion->id) }}"
                                    class="btn btn-success hint--left" aria-label="Ver requisición"><i
                                        class="fa fa-eye"></i>
                                    @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
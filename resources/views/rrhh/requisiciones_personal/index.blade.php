@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush
<div class="mb-2 row">
    <div class="col-lg-12">
        <x-card>
            <h5 class="m-0">Lista de requisiciones de personal</h5>
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
                            <th align="center" valign="middle" scope="row">{{ $requisicion->folio() }}</th>
                            <td align="center" valign="middle">{{ $requisicion->solicitante->nombre() }}</td>
                            <td align="center" valign="middle">
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
                            <td align="center" valign="middle">{{ $requisicion->personas_requeridas }}</td>
                            <td align="center" valign="middle">{{ $requisicion->created_at }}</td>
                            <td align="center" valign="middle">
                                {{ $requisicion->status }}
                            </td>
                            <td align="center" valign="middle">
                                <x-button primary icon="eye"
                                    href="{{ route('rrhh.requisiciones.personal.show', $requisicion->id) }}" />
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
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush
@endsection
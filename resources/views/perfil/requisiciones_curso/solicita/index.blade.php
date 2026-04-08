@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Lista de requisiciones de curso</h5>
                    <x-button primary label="Nueva requisición" href="{{ route('requisiciones.curso.create') }}" />
                </div>

            </x-card>
        </div>
    </div>
    <div class="col-md-12">
        <x-card>
            <table class="table text-center" id="tabla-mis-rq">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo capacitacion</th>
                        <th>Fecha de solicitud</th>
                        <th>Estatus</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisiciones as $requisicion)
                    <tr>
                        <th scope="row">{{ $requisicion->id }}</th>
                        <td>{{ $requisicion->nombre }}</td>
                        <td>{{ $requisicion->tipo_capacitacion }}</td>
                        <td>{{ $requisicion->created_at->isoFormat('LLL') }}</td>
                        <td>
                            {{ $requisicion->status }}
                        </td>
                        <td>
                            <x-button green icon="eye"
                                href="{{ route('requisiciones.curso.show', $requisicion->id) }}" />
                        </td>
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
<script src="{{ asset('assets/js/datatable/datatable_rq_cursos.js') }}"></script>
@endpush
@endsection
@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hint.min.css') }}">
@endpush
<div class="mb-2 row">
    <div class="col-lg-12">
        <x-card>
            <div class="d-flex justify-content-between align-items-center">
                <h2>Puestos</h2>
                @livewire('puestos.puesto-component')
            </div>
        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <div class="table-responsive-md">
                <table class="table" id="tabla-basica">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Pertenece a </th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($puestos as $puesto)
                        <tr>
                            <td>{{ $puesto->id }}</td>
                            <td>{{ $puesto->name }}</td>
                            <td>{{ $puesto->departamento->name }}</td>
                            <td>
                                <x-button.circle icon="eye" positive href="{{ route('puestos.show', $puesto) }}" />
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
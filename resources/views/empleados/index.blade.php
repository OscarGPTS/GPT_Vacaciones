@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endpush
<div class="mb-2 row">
    <div class="col-lg-12">
        <x-card>
            <div class="justify-content-between d-flex align-items-center">
                @can('ver modulo rrhh')
                <x-button href="{{ route('empleados.create') }}" label="Nuevo empleado" info icon="users" />
                @endcan
                <div class="gap-1 d-flex justify-content-between align-items-center">
                    @can('ver modulo rrhh')
                    @livewire('empleados.upload-excel-curso-certificacion')
                    @endcan
                    <x-button href="{{ route('empleados.documentos.check.excel') }}"
                        label="Lista documentos de contratación" icon="table" green />
                    @can('ver modulo rrhh')
                    <x-button href="{{ route('empleados.excel') }}" label="Lista de colaboradores" icon="table"
                        positive />
                    @endcan
                </div>
            </div>
        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <x-card title="Lista de empleados">
            <div class="table-responsive-md">
                <table class="table table-sm tabla-basica">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activos as $empleado)
                        <tr>
                            <td scope="row">{{ $empleado->id }}</td>
                            <td><img src="{{ $empleado->profile_image }}" alt="imagen del empleado" class="avatar">
                            </td>
                            <td>{{ $empleado->first_name }}</td>
                            <td>{{ $empleado->last_name }}</td>
                            <td>{{ $empleado->email }}</td>
                            <td>
                                <x-button.circle href="{{ route('empleados.cv.otros.pdf', $empleado) }}" icon="document"
                                    blue target="_blank" />
                                <x-button.circle href="{{ route('empleados.show', $empleado) }}" icon="eye" positive />
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

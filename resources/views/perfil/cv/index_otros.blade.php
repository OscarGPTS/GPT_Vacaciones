@extends('layouts.codebase.master')
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hint.min.css') }}">
@endpush
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
                        @foreach ($empleados as $empleado)
                        <tr>
                            <td scope="row">{{ $empleado->id }}</td>
                            <td><img src="{{ $empleado->profile_image }}" alt="imagen del empleado" class="avatar">
                            </td>
                            <td>{{ $empleado->first_name }}</td>
                            <td>{{ $empleado->last_name }}</td>
                            <td>{{ $empleado->email }}</td>
                            <td>
                                <x-button.circle href="{{ route('perfil.cv.show.otros', $empleado) }}" icon="eye"
                                    positive />
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
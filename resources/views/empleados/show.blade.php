@extends('layouts.codebase.master')
{{-- @extends('layouts.flowbite.master') --}}
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hint.min.css') }}">
@endpush
<div class="row">
    <div class="col-lg-12">
        <nav class="breadcrumb breadcrumb-icon">
            <li class="breadcrumb-item">
                <a href="{{ route('empleados.index') }}">Lista de empleados</a>
            </li>
            <li class="breadcrumb-item">Empleado</li>
            <li class="breadcrumb-item">{{ $empleado->id }}</li>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div>
            <h2>Perfil del colaborador</h2>
        </div>
    </div>
</div>
<div class="mb-2 row">
    <div class="col-lg-12">
        <x-card>
            <div>
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                    class="flex items-center text-sm font-medium text-gray-900 rounded-full pe-1 hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                    type="button">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-10 h-10 rounded-full me-2" src="{{ $empleado->profile_image }}" alt="user photo">
                    {{ $empleado->nombre() }}
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownAvatarName"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">

                    <ul class="px-0 py-2 text-sm text-dark-500 dark:text-gray-200"
                        aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                        @can('ver modulo rrhh')
                        <li>
                            <a href="{{ route('empleados.foto', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Foto</a>
                        </li>
                        <li>
                            <a href="{{ route('empleados.edit', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Editar</a>
                        </li>
                        <li>
                            <a href="{{ route('empleados.credencial', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Credencial</a>
                        </li>
                        <li>
                            <a href="{{ route('empleados.aniversario', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Aniversario</a>
                        </li>
                        <li>
                            <a href="{{ route('empleados.informacion_personal', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Datos
                                personales</a>
                        </li>
                        <li>
                            <a href="{{ route('empleados.cv.editar', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">CV</a>
                        </li>
                        @endcan
                        {{-- @if ($empleado->belongsToDepartamento()) --}}
                        <li>
                            <a href="{{ route('empleados.cv.certificado.pdf', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Certificado</a>
                        </li>
                        {{-- @endif --}}
                        <li>
                            <a href="{{ route('empleados.documentos', $empleado->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Check
                                documentos</a>
                        </li>
                    </ul>

                </div>
            </div>
        </x-card>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <x-card>
            <div>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Número de empleado:</strong>
                                <span> {{ $empleado->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Razon social:</strong>
                                <span> {{ $empleado->razonSocial->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Admision:</strong>
                                <span> {{ $empleado->admission->format('d-m-Y') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Correo:</strong>
                                <span> {{ $empleado->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Celular de la empresa:</strong>
                                <span> {{ $empleado->phone }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Activo:</strong>
                                @if ($empleado->active == 1)
                                <span class="txt-success">Si</span>
                                @else
                                <span class="txt-danger">No</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Cumpleaños:</strong>
                                <span> {{ $empleado->personalData->birthday->format('d-m-Y') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>CURP:</strong>
                                <span> {{ $empleado->personalData->curp }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>RFC:</strong>
                                <span> {{ $empleado->personalData->rfc }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>NSS:</strong>
                                <span> {{ $empleado->personalData->nss }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Correo personal:</strong>
                                <span> {{ $empleado->personalData->personal_mail }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Celular personal:</strong>
                                <span> {{ $empleado->personalData->personal_phone }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection

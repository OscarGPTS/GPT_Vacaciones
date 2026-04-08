@extends('layouts.codebase.master')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-envelope-open-text me-2"></i>
                Prueba de Envío de Correo
            </h3>
            <div class="block-options">
                <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                    🧪 HERRAMIENTA DE PRUEBA
                </span>
            </div>
        </div>
        <div class="block-content">
            <!-- Alerta de Información - PRUEBA -->
            <div class="alert alert-warning d-flex align-items-center border-3 border-warning" role="alert">
                <div class="flex-shrink-0">
                    <i class="fa fa-exclamation-triangle fa-3x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="alert-heading mb-2">
                        <strong>⚠️ Herramienta de Prueba de Sistema</strong>
                    </h5>
                    <p class="mb-0">
                        Esta funcionalidad te permite enviar un correo de prueba a cualquier dirección para verificar que el sistema de envío de correos está funcionando correctamente. 
                        <strong class="text-danger">El correo estará claramente identificado como PRUEBA.</strong>
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div class="flex-shrink-0">
                        <i class="fa fa-check-circle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-0"><strong>{!! session('success') !!}</strong></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <div class="flex-shrink-0">
                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-0"><strong>{!! session('error') !!}</strong></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <h5 class="alert-heading">
                        <i class="fa fa-times-circle me-2"></i>Errores de Validación
                    </h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-paper-plane me-2"></i>
                                Enviar Correo de Prueba
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.test-email.send') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold" for="email">
                                                <i class="fa fa-envelope me-2"></i>
                                                Correo Electrónico de Destino
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input 
                                                type="email" 
                                                class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                                id="email" 
                                                name="email" 
                                                placeholder="ejemplo@correo.com"
                                                value="{{ old('email') }}"
                                                required
                                            >
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fa fa-info-circle me-1"></i>
                                                El correo incluirá información sobre quién lo envió y estará marcado claramente como mensaje de prueba.
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fa fa-paper-plane me-2"></i>
                                                Enviar Correo de Prueba
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <!-- Información del remitente -->
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="card-title mb-3">
                                                    <i class="fa fa-user me-2"></i>
                                                    Información del Remitente
                                                </h6>
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Nombre:</small>
                                                    <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>
                                                </div>
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Correo:</small>
                                                    <strong class="text-break">{{ auth()->user()->email }}</strong>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Fecha:</small>
                                                    <strong>{{ now()->format('d/m/Y H:i') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-question-circle me-2"></i>
                Información sobre el Correo de Prueba
            </h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-success mb-3">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-check me-2"></i>¿Qué incluye el correo?
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li class="mb-2">
                                    <i class="fa fa-badge-check text-warning me-2"></i>
                                    <strong>Badge prominente:</strong> Marca clara de "🧪 CORREO DE PRUEBA"
                                </li>
                                <li class="mb-2">
                                    <i class="fa fa-user text-primary me-2"></i>
                                    <strong>Información del remitente:</strong> Nombre y correo de quien envía
                                </li>
                                <li class="mb-2">
                                    <i class="fa fa-calendar text-info me-2"></i>
                                    <strong>Fecha y hora:</strong> Timestamp exacto del envío
                                </li>
                                <li class="mb-2">
                                    <i class="fa fa-file-alt text-secondary me-2"></i>
                                    <strong>Mensaje explicativo:</strong> Indicando que es una prueba del sistema
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fa fa-shield-alt me-2"></i>Seguridad y Control
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li class="mb-2">
                                    <i class="fa fa-lock text-danger me-2"></i>
                                    <strong>Permisos restringidos:</strong> Solo usuarios con permisos de RRHH pueden enviarlo
                                </li>
                                <li class="mb-2">
                                    <i class="fa fa-history text-warning me-2"></i>
                                    <strong>Registro automático:</strong> Se registra quién envía cada correo de prueba
                                </li>
                                <li class="mb-2">
                                    <i class="fa fa-eye-slash text-success me-2"></i>
                                    <strong>Sin datos sensibles:</strong> No contiene información confidencial
                                </li>
                                <li class="mb-2">
                                    <i class="fa fa-check-circle text-primary me-2"></i>
                                    <strong>Verificación del sistema:</strong> Confirma que el servidor de correo funciona
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

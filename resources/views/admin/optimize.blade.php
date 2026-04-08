@extends('layouts.codebase.master')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-cogs me-2"></i>
                Optimización del Sistema
            </h3>
            <div class="block-options">
                <span class="badge bg-info text-white fs-6 px-3 py-2">
                    <i class="fa fa-server me-1"></i>
                    Servidor Compartido
                </span>
            </div>
        </div>
        <div class="block-content">
            <!-- Alerta de Información -->
            <div class="alert alert-info d-flex align-items-center border-3 border-info" role="alert">
                <div class="flex-shrink-0">
                    <i class="fa fa-info-circle fa-3x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="alert-heading mb-2">
                        <strong>🔧 Herramienta de Optimización</strong>
                    </h5>
                    <p class="mb-0">
                        Ejecuta comandos de Laravel sin necesidad de acceso SSH. Útil para limpiar cachés, optimizar rutas y configuración en servidores compartidos.
                        <strong>Solo usuarios con permisos de RRHH pueden ejecutar estos comandos.</strong>
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-start alert-dismissible fade show" role="alert">
                    <div class="flex-shrink-0">
                        <i class="fa fa-check-circle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div>{!! session('success') !!}</div>
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

            <!-- Comando de Optimización Completa -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-rocket me-2"></i>
                                Optimización Completa
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                <i class="fa fa-info-circle text-info me-2"></i>
                                Ejecuta todos los comandos de optimización en secuencia (limpia cachés y regenera optimizaciones).
                            </p>
                            <form action="{{ route('admin.optimize.all') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100" onclick="return confirm('¿Ejecutar optimización completa del sistema?')">
                                    <i class="fa fa-bolt me-2"></i>
                                    Ejecutar Optimización Completa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comandos Individuales -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-terminal me-2"></i>
                                Comandos Individuales
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Limpiar Cachés -->
                                <div class="col-md-6">
                                    <div class="card border-danger h-100">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0">
                                                <i class="fa fa-trash-alt me-2"></i>
                                                Limpiar Cachés
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="command" value="cache:clear">
                                                <button type="submit" class="btn btn-danger w-100 mb-2">
                                                    <i class="fa fa-broom me-2"></i>
                                                    Limpiar Caché General
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="command" value="config:clear">
                                                <button type="submit" class="btn btn-outline-danger w-100 mb-2">
                                                    <i class="fa fa-cog me-2"></i>
                                                    Limpiar Caché de Configuración
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="command" value="route:clear">
                                                <button type="submit" class="btn btn-outline-danger w-100 mb-2">
                                                    <i class="fa fa-route me-2"></i>
                                                    Limpiar Caché de Rutas
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="command" value="view:clear">
                                                <button type="submit" class="btn btn-outline-danger w-100">
                                                    <i class="fa fa-eye me-2"></i>
                                                    Limpiar Caché de Vistas
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Generar Cachés -->
                                <div class="col-md-6">
                                    <div class="card border-success h-100">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0">
                                                <i class="fa fa-plus-circle me-2"></i>
                                                Generar Optimizaciones
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="command" value="optimize">
                                                <button type="submit" class="btn btn-success w-100 mb-2">
                                                    <i class="fa fa-rocket me-2"></i>
                                                    Optimizar Sistema
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="command" value="config:cache">
                                                <button type="submit" class="btn btn-outline-success w-100 mb-2">
                                                    <i class="fa fa-cog me-2"></i>
                                                    Cachear Configuración
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST" class="mb-2">
                                                @csrf
                                                <input type="hidden" name="command" value="route:cache">
                                                <button type="submit" class="btn btn-outline-success w-100 mb-2">
                                                    <i class="fa fa-route me-2"></i>
                                                    Cachear Rutas
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.optimize.execute') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="command" value="view:cache">
                                                <button type="submit" class="btn btn-outline-success w-100">
                                                    <i class="fa fa-eye me-2"></i>
                                                    Cachear Vistas
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Otros Comandos -->
                                <div class="col-md-12">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-dark">
                                            <h6 class="mb-0">
                                                <i class="fa fa-tools me-2"></i>
                                                Utilidades
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="{{ route('admin.optimize.execute') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="command" value="storage:link">
                                                        <button type="submit" class="btn btn-warning w-100">
                                                            <i class="fa fa-link me-2"></i>
                                                            Crear Enlace Simbólico Storage
                                                        </button>
                                                    </form>
                                                    <small class="text-muted d-block mt-2">
                                                        <i class="fa fa-info-circle me-1"></i>
                                                        Necesario para acceder a archivos públicos
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Sistema -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-info-circle me-2"></i>
                Información Útil
            </h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-question-circle me-2"></i>
                                ¿Cuándo usar?
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0 small">
                                <li class="mb-2">Después de actualizar archivos de código</li>
                                <li class="mb-2">Cuando cambias archivos de configuración</li>
                                <li class="mb-2">Si las rutas no funcionan correctamente</li>
                                <li class="mb-2">Cuando las vistas no se actualizan</li>
                                <li>Después de modificar archivos .env</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-shield-alt me-2"></i>
                                Seguridad
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0 small">
                                <li class="mb-2"><strong>Acceso restringido:</strong> Solo usuarios RRHH</li>
                                <li class="mb-2"><strong>Comandos seguros:</strong> Lista permitida predefinida</li>
                                <li class="mb-2"><strong>Sin SSH:</strong> No requiere acceso al servidor</li>
                                <li class="mb-2"><strong>Registro:</strong> Se registra quién ejecuta comandos</li>
                                <li><strong>Confirmación:</strong> Algunos comandos requieren confirmar</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-lightbulb me-2"></i>
                                Recomendaciones
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0 small">
                                <li class="mb-2"><strong>Modo desarrollo:</strong> Limpia cachés frecuentemente</li>
                                <li class="mb-2"><strong>Modo producción:</strong> Cachea para mejor rendimiento</li>
                                <li class="mb-2"><strong>Optimización completa:</strong> Usa después de desplegar</li>
                                <li class="mb-2"><strong>Storage link:</strong> Solo ejecutar una vez</li>
                                <li><strong>Precaución:</strong> En producción, regenera cachés después de limpiar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

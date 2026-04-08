<div>
    <style>
        .th-aniversario {
            background-color: #2563EB !important;
            color: #ffffff !important;
        }
        .th-saldo-anterior {
            background-color: #BDD7EE !important;
            color: #000000 !important;
        }
        .th-antes-aniversario {
            background-color: #FFFF00 !important;
            color: #000000 !important;
        }
        .th-despues-aniversario {
            background-color: #F4A460 !important;
            color: #000000 !important;
        }
        .th-default {
            background-color: #DCE6F1 !important;
            color: #000000 !important;
        }
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-bordered thead th {
            border-bottom-width: 2px !important;
        }
    </style>

    <div class="content">
        <div class="block block-rounded">
            <div class="flex justify-between card-header bg-primary text-white rounded p-3">
                <h3 class="flex card-title mb-0">
                    <a href="{{ url()->previous() }}" class="mr-4">
                        <svg width="30px" height="30px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path fill="#FFF" d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"/><path fill="#FFF" d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"/>
                        </svg>
                    </a>
                    Importación Masiva de Vacaciones
                </h3>
                <div class="block-options">
                    <button type="button" class="" wire:click="downloadTemplate">
                        <i class="fa fa-download me-1"></i>
                        Descargar Plantilla
                    </button>
                </div>
            </div>

            <div class="block-content">
                {{-- Paso 1: Subir archivo --}}
                @if($step === 1)
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="text-center mb-4">
                                <i class="fa fa-cloud-upload fa-3x text-primary mb-3"></i>
                                <h4>Importación de Vacaciones</h4>
                                <p class="text-muted">Sube el archivo Excel con el formato estándar de GPT Services</p>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Archivo Excel</label>
                                    <input type="file" 
                                           class="form-control @error('importFile') is-invalid @enderror" 
                                           wire:model="importFile"
                                           accept=".xlsx,.xls">
                                    @error('importFile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($importFile)
                                        <div class="mt-2">
                                            <small class="text-success">
                                                <i class="fa fa-check-circle me-1"></i>
                                                {{ $importFile->getClientOriginalName() }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" 
                                            class="btn btn-primary w-100"
                                            wire:click="processFile"
                                            wire:loading.attr="disabled"
                                            wire:target="processFile"
                                            @disabled(!$importFile)>
                                        <span wire:loading.remove wire:target="processFile">
                                            <i class="fa fa-arrow-right me-1"></i>
                                            Procesar
                                        </span>
                                        <span wire:loading wire:target="processFile">
                                            <i class="fa fa-spinner fa-spin me-1"></i>
                                            Procesando...
                                        </span>
                                    </button>
                                </div>
                            </div>

                            {{-- Ejemplo visual del formato esperado --}}
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fa fa-table me-2 text-primary"></i>
                                        Formato Esperado del Archivo
                                    </h5>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#instructionsModal">
                                        <i class="fa fa-info-circle me-1"></i> Ver Instrucciones
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0" style="font-size: 11px;">
                                            <thead>
                                                <tr style="font-size: 10px; white-space: normal; vertical-align: middle; text-align: center;">
                                                    <th class="th-default" style="width: 40px;">No.</th>
                                                    <th class="th-default" style="min-width: 180px; text-align: left;">NOMBRE</th>
                                                    <th class="th-saldo-anterior" style="min-width: 100px;">Saldo Pendiente Periodo {{ $periodoAnterior }}</th>
                                                    <th class="th-aniversario" style="min-width: 100px;">Fecha de Aniversario</th>
                                                    <th class="th-default" style="width: 80px;">Antigüedad</th>
                                                    <th class="th-default" style="min-width: 120px;">Dias De vacaciones Correspondientes Periodo {{ $periodoActual }}</th>
                                                    <th class="th-antes-aniversario" style="min-width: 110px;">Días disfrutados antes de la fecha de Aniversario</th>
                                                    <th class="th-default" style="min-width: 100px;">Dias Difrutados periodo {{ $periodoActual }}</th>
                                                    <th class="th-despues-aniversario" style="min-width: 130px;">Días disfrutados despues de fecha de aniversario</th>
                                                    <th class="th-default" style="min-width: 100px;">Saldo Pendiente Periodo {{ $periodoActual }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="font-size: 11px;">
                                                    <td class="text-center">13</td>
                                                    <td>PATERNO MATERNO NOMBRE</td>
                                                    <td class="text-center">23</td>
                                                    <td class="text-center">25-may-26</td>
                                                    <td class="text-center">12</td>
                                                    <td class="text-center">24</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">24</td>
                                                </tr>
                                                <tr style="font-size: 11px;">
                                                    <td class="text-center">14</td>
                                                    <td>PATERNO MATERNO NOMBRE</td>
                                                    <td class="text-center">18</td>
                                                    <td class="text-center">22-ago-26</td>
                                                    <td class="text-center">15</td>
                                                    <td class="text-center">24</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">24</td>
                                                </tr>
                                                <tr style="font-size: 11px;">
                                                    <td class="text-center">18</td>
                                                    <td>PATERNO MATERNO NOMBRE</td>
                                                    <td class="text-center">14</td>
                                                    <td class="text-center">14-jul-26</td>
                                                    <td class="text-center">12</td>
                                                    <td class="text-center">24</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">24</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal de Instrucciones --}}
                            <div class="modal fade" id="instructionsModal" tabindex="-1" aria-labelledby="instructionsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg bg-white">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="instructionsModalLabel">
                                                <i class="fa fa-info-circle me-2"></i>
                                                Instrucciones de Importación
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info">
                                                <strong><i class="fa fa-file-excel me-1"></i> Estructura del Archivo:</strong>
                                                <ul class="mb-0 mt-2">
                                                    <li>Los datos deben comenzar en la <strong>fila 5</strong></li>
                                                    <li>Las primeras 3 filas son encabezados, la fila 4 contiene los nombres de columnas</li>
                                                    <li>Columnas vacías se consideran automáticamente como <strong>0</strong></li>
                                                </ul>
                                            </div>

                                            <h6 class="text-primary mt-3"><i class="fa fa-table me-1"></i> Columnas del Archivo (B–Q, datos desde fila 5)</h6>
                                            <table class="table table-sm table-bordered small">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Col.</th>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td>B</td><td>No.</td><td>Número de empleado (opcional)</td></tr>
                                                    <tr><td>C</td><td>NOMBRE</td><td>Nombre completo del empleado (requerido para identificarlo)</td></tr>
                                                    <tr class="table-secondary"><td colspan="3"><strong>Periodo 2025-2026 — solo referencia, no se importa</strong></td></tr>
                                                    <tr><td>D</td><td>Fecha de Aniversario</td><td>Fecha del aniversario del periodo anterior</td></tr>
                                                    <tr><td>E</td><td>Antigüedad</td><td>Años de servicio</td></tr>
                                                    <tr><td>F</td><td>Días Correspondientes</td><td>Días según antigüedad</td></tr>
                                                    <tr style="background-color:#fefce8;"><td>G</td><td>Días disfrutados antes del aniversario</td><td></td></tr>
                                                    <tr><td>H</td><td>Días disfrutados del periodo</td><td></td></tr>
                                                    <tr style="background-color:#fff7ed;"><td>I</td><td>Días disfrutados después del aniversario</td><td></td></tr>
                                                    <tr class="table-info"><td>J</td><td><strong>Saldo Pendiente 2025-2026</strong></td><td>Referencia que se muestra en el preview</td></tr>
                                                    <tr class="table-success"><td colspan="3"><strong>Periodo 2026-2027 — SE IMPORTA</strong></td></tr>
                                                    <tr style="background-color:#dbeafe;"><td>K</td><td><strong>Fecha de Aniversario 2026-2027</strong></td><td>Fecha inicio del <strong>nuevo periodo</strong> (dd/mm/yyyy)</td></tr>
                                                    <tr><td>L</td><td>Antigüedad</td><td>Años de servicio actuales</td></tr>
                                                    <tr><td>M</td><td>Días Correspondientes</td><td>Días de vacaciones que corresponden</td></tr>
                                                    <tr style="background-color:#fefce8;"><td>N</td><td>Días disfrutados antes del aniversario</td><td></td></tr>
                                                    <tr><td>O</td><td>Días disfrutados del periodo</td><td>Total de días tomados en el periodo</td></tr>
                                                    <tr style="background-color:#fff7ed;"><td>P</td><td>Días disfrutados después del aniversario</td><td></td></tr>
                                                    <tr><td>Q</td><td>Saldo Pendiente 2026-2027</td><td>Días disponibles restantes</td></tr>
                                                </tbody>
                                            </table>

                                            <div class="alert alert-warning mt-2">
                                                <strong><i class="fa fa-exclamation-triangle me-1"></i> Validaciones Automáticas:</strong>
                                                <ul class="mb-0 small">
                                                    <li>Los días disfrutados no pueden exceder los días que corresponden</li>
                                                    <li>Los empleados se identifican automáticamente por nombre completo</li>
                                                    <li>Los registros sin usuario identificado se marcan en amarillo en la previsualización</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Paso 2: Revisar y asignar usuarios --}}
                @if($step === 2)
                    {{-- Resumen del archivo cargado --}}
                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                        <i class="fa fa-file-excel fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Preview de Datos del Excel</h5>
                            <p class="mb-0">
                                Total de registros encontrados: <strong>{{ count($validRecords) }}</strong>
                            </p>
                        </div>
                    </div>

                    {{-- Tabla con datos del Excel --}}
                    <div class="block block-rounded mb-4">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="fa fa-table text-primary me-2"></i>
                                Datos del Archivo Excel
                            </h3>
                            <div class="block-options">
                                <span class="badge bg-primary fs-sm">{{ count($validRecords) }} registros</span>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                <table class="table table-sm table-hover table-vcenter table-bordered mb-0">
                                    <thead class="sticky-top">
                                        <tr style="font-size: 10px; white-space: normal; vertical-align: middle; text-align: center;">
                                            <th class="th-default" style="width: 40px;">No.</th>
                                            <th class="th-default" style="min-width: 180px; text-align: left;">NOMBRE</th>
                                            <th class="th-saldo-anterior" style="min-width: 100px;">Saldo Pendiente Periodo {{ $periodoAnterior }}</th>
                                            <th class="th-aniversario" style="min-width: 100px;">Fecha de Aniversario</th>
                                            <th class="th-default" style="width: 80px;">Antigüedad</th>
                                            <th class="th-default" style="min-width: 120px;">Dias De vacaciones Correspondientes Periodo {{ $periodoActual }}</th>
                                            <th class="th-antes-aniversario" style="min-width: 110px;">Días disfrutados antes de la fecha de Aniversario</th>
                                            <th class="th-default" style="min-width: 100px;">Dias Difrutados periodo {{ $periodoActual }}</th>
                                            <th class="th-despues-aniversario" style="min-width: 130px;">Días disfrutados despues de fecha de aniversario</th>
                                            <th class="th-default" style="min-width: 100px;">Saldo Pendiente Periodo {{ $periodoActual }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($validRecords as $index => $record)
                                            <tr style="font-size: 11px;" class="">
                                                <td class="text-center">{{ $record['numero_empleado'] ?: '' }}</td>
                                                <td>{{ $record['nombre_completo'] }}</td>
                                                <td class="text-center">{{ ($record['periodo_anterior']['saldo_pendiente'] ?? '') !== '' ? $record['periodo_anterior']['saldo_pendiente'] : '0' }}</td>
                                                <td class="text-center">{{ $record['fecha_aniversario'] }}</td>
                                                <td class="text-center">{{ $record['antiguedad'] !== '' ? $record['antiguedad'] : '0' }}</td>
                                                <td class="text-center">{{ $record['dias_corresponden'] !== '' ? $record['dias_corresponden'] : '0' }}</td>
                                                <td class="text-center">{{ $record['dias_disfrutados_antes'] !== '' ? $record['dias_disfrutados_antes'] : '0' }}</td>
                                                <td class="text-center">{{ $record['dias_disfrutados_actual'] !== '' ? $record['dias_disfrutados_actual'] : '0' }}</td>
                                                <td class="text-center">{{ $record['dias_disfrutados_despues'] !== '' ? $record['dias_disfrutados_despues'] : '0' }}</td>
                                                <td class="text-center">{{ $record['saldo_pendiente'] !== '' ? $record['saldo_pendiente'] : '0' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" 
                                        class="btn btn-alt-secondary"
                                        wire:click="resetImport">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    Cancelar
                                </button>

                                <button type="button" 
                                        class="btn btn-success btn-lg"
                                        wire:click="executeImport"
                                        wire:loading.attr="disabled"
                                        wire:target="executeImport"
                                        @disabled(count($validRecords) === 0)>
                                    <span wire:loading.remove wire:target="executeImport">
                                        <i class="fa fa-check me-1"></i>
                                        Importar {{ count($validRecords) }} Registro(s)
                                    </span>
                                    <span wire:loading wire:target="executeImport">
                                        <i class="fa fa-spinner fa-spin me-1"></i>
                                        Importando...
                                    </span>
                                </button>
                            </div>

                            @if(count($unmatchedRecords) > 0)
                                <div class="alert alert-info mt-3" role="alert">
                                    <i class="fa fa-info-circle me-2"></i>
                                    Quedan <strong>{{ count($unmatchedRecords) }}</strong> registro(s) sin asignar. 
                                    Puedes continuar con la importación de los registros válidos o asignar todos primero.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Paso 3: Resultados --}}
                @if($step === 3 && $importResults)
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-4">
                                <i class="fa fa-check-circle fa-4x text-success mb-3"></i>
                                <h3>Importación Completada</h3>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-primary mb-0">{{ $importResults['total'] }}</h2>
                                            <small class="text-muted">Total Procesados</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-success mb-0">{{ $importResults['updated'] }}</h2>
                                            <small class="text-muted">Actualizados</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-warning mb-0">{{ $importResults['skipped'] }}</h2>
                                            <small class="text-muted">Omitidos</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-danger mb-0">{{ count($importResults['errors']) }}</h2>
                                            <small class="text-muted">Errores</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(count($importResults['errors']) > 0)
                                <div class="alert alert-info border-info bg-light" role="alert">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="alert-heading text-info">
                                                <i class="fas fa-tools me-2"></i>
                                                ¿Cómo solucionar las incidencias?
                                            </h5>
                                            <p class="mb-2">
                                                Si los errores son por <strong>usuarios inactivos</strong> o <strong>fechas de admisión incorrectas</strong>, 
                                                puedes corregirlos directamente desde el sistema:
                                            </p>
                                            <ol class="mb-3">
                                                <li>Ve al <strong>Reporte de Vacaciones</strong></li>
                                                <li>Busca la sección <strong>"Usuarios con Incidencias"</strong> (aparecerá automáticamente si hay errores)</li>
                                                <li>Edita la <strong>fecha de admisión</strong> y/o el <strong>estado del usuario</strong></li>
                                                <li>Guarda los cambios y las incidencias se marcarán como resueltas</li>
                                                <li>Vuelve aquí y carga nuevamente el archivo Excel</li>
                                            </ol>
                                            <a href="{{ route('vacaciones.reporte') }}" class="btn btn-info">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                Ir al Reporte de Vacaciones para Resolver Incidencias
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-danger" role="alert">
                                    <h5 class="alert-heading">
                                        <i class="fa fa-exclamation-circle me-2"></i>
                                        Registros con Errores - Requieren Corrección
                                    </h5>
                                    <p class="mb-3">
                                        Los siguientes registros no pudieron importarse debido a inconsistencias en los datos.
                                    </p>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered bg-white">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 25%;">Empleado</th>
                                                    <th style="width: 70%;">Motivo del Error</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($importResults['errors'] as $index => $error)
                                                    <tr>
                                                        <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                                                        <td><strong>{{ $error['nombre'] }}</strong></td>
                                                        <td>
                                                            <i class="fa fa-times-circle text-danger me-1"></i>
                                                            {{ $error['error'] }}
                                                            
                                                            @if(str_contains($error['error'], 'fecha similar'))
                                                                <div class="alert alert-warning mt-2 mb-0">
                                                                    <i class="fa fa-lightbulb me-1"></i>
                                                                    <strong>Solución:</strong> Verifique la fecha exacta en el sistema y actualícela en el Excel para que coincida.
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if($importResults['pending'] > 0)
                                <div class="alert alert-warning" role="alert">
                                    <i class="fa fa-info-circle me-2"></i>
                                    {{ $importResults['pending'] }} registro(s) quedaron sin procesar por falta de asignación.
                                </div>
                            @endif

                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <a href="{{ route('vacaciones.reporte') }}" class="btn btn-primary">
                                    <i class="fa fa-chart-bar me-1"></i>
                                    Ver Reporte de Vacaciones
                                </a>
                                <button type="button" class="btn btn-alt-secondary" wire:click="resetImport">
                                    <i class="fa fa-redo me-1"></i>
                                    Nueva Importación
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

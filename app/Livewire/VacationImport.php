<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\VacationsAvailable;
use App\Models\SystemLog;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use Rap2hpoutre\FastExcel\FastExcel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VacationImport extends Component
{
    use WithFileUploads, Actions;

    public $importFile;
    public $step = 1; // 1: Upload, 2: Review & Match, 3: Results
    
    // Datos procesados
    public $validRecords = [];
    public $unmatchedRecords = [];
    public $importResults = null;
    
    // Mapeo manual de usuarios no identificados
    public $userMatches = []; // ['index' => 'user_id']
    public $pendingUserAssignments = [];

    // Períodos detectados dinámicamente del encabezado del Excel (fila 4)
    public $periodos = [];
    public $periodoAnterior = '2025-2026';
    public $periodoActual   = '2026-2027';
    public $periodosPorColumna = [];

    protected $rules = [
        'importFile' => 'required|mimes:xlsx,xls|max:5120', // 5MB max
    ];

    public function mount()
    {
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    public function render()
    {
        $allUsers = User::where('active', 1)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => trim($user->last_name . ' ' . $user->first_name)
                ];
            });

        return view('livewire.vacation-import', [
            'allUsers' => $allUsers
        ])->layout('layouts.codebase.master-livewire');
    }

    public function processFile()
    {
        $this->validate();

        try {
            $spreadsheet = IOFactory::load($this->importFile->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $this->detectPeriods($sheet);
            $highestRow = $sheet->getHighestDataRow();

            if ($highestRow < 5) {
                $this->notification()->error('Archivo vacío', 'El archivo no contiene datos para importar.');
                return;
            }

            $this->validRecords   = [];
            $this->unmatchedRecords = [];

            // Datos comienzan en fila 5, columnas B(2) a Q(17)
            for ($row = 5; $row <= $highestRow; $row++) {
                $noEmpleado = trim((string) ($sheet->getCell('B' . $row)->getValue() ?? ''));
                $nombre     = trim((string) ($sheet->getCell('C' . $row)->getValue() ?? ''));

                if ($noEmpleado === '' && $nombre === '') {
                    continue; // fila vacía
                }

                // Leer columnas B(2) a Q(17) tal como se ven en Excel
                $rowValues = [];
                for ($colIdx = 2; $colIdx <= 17; $colIdx++) {
                    $coord = Coordinate::stringFromColumnIndex($colIdx) . $row;
                    $cell  = $sheet->getCell($coord);
                    $val   = $this->getCellDisplayValue($cell);

                    $rowValues[] = $val;
                }

                $record = $this->parseRow($rowValues, $row - 5);
                $this->validRecords[] = $record;
            }

            $this->step = 2;

            $this->notification()->success(
                'Archivo cargado',
                sprintf('Se encontraron %d registros en el archivo.', count($this->validRecords))
            );

        } catch (\Exception $e) {
            Log::error('Error procesando archivo de importación: ' . $e->getMessage());
            $this->notification()->error('Error', 'No se pudo procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Lee la fila 4 para detectar los rangos de año (Periodo YYYY-YYYY) en las cabeceras.
     * Detecta automáticamente cualquier cantidad de períodos: el último será $periodoActual
     * y el penúltimo $periodoAnterior.
     */
    protected function detectPeriods(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): void
    {
        $found = [];
        $this->periodosPorColumna = [];
        for ($colIdx = 2; $colIdx <= 17; $colIdx++) {
            $coord = Coordinate::stringFromColumnIndex($colIdx) . '4';
            $text  = (string) $sheet->getCell($coord)->getValue();

            $column = Coordinate::stringFromColumnIndex($colIdx);
            $period = null;
            $meses = null;

            if (preg_match('/(\d{4})\s*-\s*(\d{4})/', $text, $m)) {
                $period = $m[1] . '-' . $m[2];
                $found[$period] = true;
            }

            if (preg_match('/\((\d+)\s*mes(?:es)?\)/i', $text, $mMeses)) {
                $meses = (int) $mMeses[1];
            }

            if ($period !== null || $meses !== null) {
                $this->periodosPorColumna[$column] = [
                    'periodo' => $period,
                    'meses' => $meses,
                    'header' => trim($text),
                ];
            }
        }

        if (empty($found)) {
            return; // Mantener defaults si no se detectan períodos
        }

        $periods = array_keys($found);
        sort($periods); // Orden cronológico ascendente

        $count = count($periods);
        $this->periodos        = $periods;
        $this->periodoActual   = $periods[$count - 1];
        $this->periodoAnterior = $count >= 2 ? $periods[$count - 2] : $periods[0];
    }

    /**
     * Lee el valor de una celda tal como aparece en Excel.
     *
     * PhpSpreadsheet puede devolver "General" literalmente cuando el formato de la celda
     * es "General" — en ese caso getCalculatedValue() es más confiable.
     * Para celdas con formato de fecha u otros formatos específicos se usa getFormattedValue().
     */
    protected function getCellDisplayValue(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell): string
    {
        $formatCode = (string) $cell->getStyle()->getNumberFormat()->getFormatCode();

        $normalize = static function ($value): string {
            if (is_object($value) && method_exists($value, 'getPlainText')) {
                return trim((string) $value->getPlainText());
            }

            if (is_float($value) && $value == floor($value)) {
                return (string) (int) $value;
            }

            return trim((string) $value);
        };

        $isGeneralToken = static function (string $text): bool {
            $token = strtolower(trim(str_replace(['"', "'", ' ', '\\'], '', $text)));
            return $token === 'general' || $token === '@' || $token === '';
        };

        // Si el formato es General (o equivalente), el valor calculado es más confiable.
        if ($isGeneralToken($formatCode)) {
            try {
                $calc = $cell->getCalculatedValue();
                $calcText = $normalize($calc);
                if (!$isGeneralToken($calcText)) {
                    return $calcText;
                }
            } catch (\Exception $e) {
            }
        }

        // Intento principal para formatos no-Generales (fechas, etc.).
        try {
            $formatted = $normalize($cell->getFormattedValue());
            if ($formatted !== '' && !$isGeneralToken($formatted) && $formatted !== $normalize($formatCode)) {
                return $formatted;
            }
        } catch (\Exception $e) {
        }

        // Fallback 1: valor calculado.
        try {
            $calc = $cell->getCalculatedValue();
            $calcText = $normalize($calc);
            if (!$isGeneralToken($calcText)) {
                return $calcText;
            }
        } catch (\Exception $e) {
        }

        // Fallback 2: valor crudo.
        $raw = $normalize($cell->getValue());
        return $isGeneralToken($raw) ? '' : $raw;
    }

    protected function parseRow(array $values, int $index): array
    {
        // Todas las celdas se guardan como string tal como vienen del Excel.
        // Los campos numéricos se convierten a float solo al momento de importar.
        $clean = fn($v) => trim((string)($v ?? ''));

        $numeroEmpleado = $clean($values[0] ?? '');
        $nombreCompleto = $clean($values[1] ?? '');

        // D-J = referencia periodo anterior (solo display + actualización BD)
        $fechaAniversarioAnterior        = $clean($values[2] ?? '');             // D display
        $fechaAniversarioAnteriorImport  = $this->parseDate($values[2] ?? null); // D normalizado Y-m-d
        $antiguedadAnterior              = $clean($values[3] ?? '');             // E
        $diasCorrespondenAnterior        = $clean($values[4] ?? '');             // F
        $diasDisfrutadosAntesAnterior    = $clean($values[5] ?? '');             // G
        $diasDisfrutadosActualAnterior   = $clean($values[6] ?? '');             // H
        $diasDisfrutadosDespuesAnterior  = $clean($values[7] ?? '');             // I
        $saldoPendienteAnterior          = $clean($values[8] ?? '');             // J

        $fechaAniversarioPreview  = $clean($values[9] ?? '');            // K display
        $fechaAniversarioImport   = $this->parseDate($values[9] ?? null); // K normalizado

        $antiguedad            = $clean($values[10] ?? '');  // L
        $diasCorresponden      = $clean($values[11] ?? '');  // M
        $diasDisfrutadosAntes  = $clean($values[12] ?? '');  // N
        $diasDisfrutadosPeriodo = $clean($values[13] ?? ''); // O
        $diasDisfrutadosDespues = $clean($values[14] ?? ''); // P
        $saldoPendiente        = $clean($values[15] ?? '');  // Q

        $fechaInicio = $fechaAniversarioImport;
        $fechaFin = $fechaAniversarioImport
            ? Carbon::parse($fechaAniversarioImport)->addYear()->format('Y-m-d')
            : null;

        $status = 'actual';
        if ($fechaFin && Carbon::now()->greaterThan(Carbon::parse($fechaFin))) {
            $status = 'vencido';
        }

        // Intentar identificar primero por columna B (si corresponde a users.id), luego por nombre.
        $user = null;
        $userError = null;
        $inactiveUserId = null; // ID del usuario inactivo detectado
        
        if ($numeroEmpleado !== '' && ctype_digit($numeroEmpleado)) {
            $user = User::where('id', (int) $numeroEmpleado)
                ->where('active', 1)
                ->first();

            if (!$user) {
                $existingUserById = User::select(['id', 'active'])->find((int) $numeroEmpleado);
                if ($existingUserById && (int) $existingUserById->active === 2) {
                    $userError = 'Usuario encontrado, pero está en estado inactivo, actualiza su estado para poder importarlo e intenta importar las vacaciones nuevamente.';
                    $inactiveUserId = $existingUserById->id; // Guardar ID del usuario inactivo
                }
            }
        }
        if (!$user && $nombreCompleto !== '') {
            $user = $this->findUserByName($nombreCompleto);

            if (!$user && !$userError) {
                $inactiveUser = $this->findInactiveUserByName($nombreCompleto);
                if ($inactiveUser && (int) $inactiveUser->active === 2) {
                    $userError = 'Usuario encontrado, pero está en estado inactivo, actualiza su estado para poder importarlo e intenta importar las vacaciones nuevamente.';
                    $inactiveUserId = $inactiveUser->id; // Guardar ID del usuario inactivo
                }
            }
        }

        // Metadatos de periodos tomados desde fila 4 para uso dinámico en importación.
        $periodoM = $this->periodosPorColumna['M']['periodo'] ?? null; // Dias correspondientes
        $periodoQ = $this->periodosPorColumna['Q']['periodo'] ?? null; // Saldo pendiente
        $periodoI = $this->periodosPorColumna['I']['periodo'] ?? null; // Días después (bloque anterior)
        $mesesI   = $this->periodosPorColumna['I']['meses'] ?? null;

        return [
            'index'           => $index,
            'numero_empleado' => $numeroEmpleado,
            'nombre_completo' => $nombreCompleto,
            'user'            => $user,
            'user_error'      => $userError,
            'inactive_user_id' => $inactiveUserId, // ID de usuario inactivo si se detectó
            'periodos_headers' => [
                'dias_corresponden_col_m' => $periodoM,
                'saldo_pendiente_col_q' => $periodoQ,
                'dias_despues_col_i' => $periodoI,
                'dias_despues_col_i_meses' => $mesesI,
            ],
            'periodo_anterior' => [
                'fecha_aniversario' => $fechaAniversarioAnterior,
                'fecha_aniversario_import' => $fechaAniversarioAnteriorImport,
                'antiguedad'               => $antiguedadAnterior,
                'dias_corresponden'        => $diasCorrespondenAnterior,
                'dias_disfrutados_antes'   => $diasDisfrutadosAntesAnterior,
                'dias_disfrutados_actual'  => $diasDisfrutadosActualAnterior,
                'dias_disfrutados_despues' => $diasDisfrutadosDespuesAnterior,
                'saldo_pendiente'          => $saldoPendienteAnterior,
            ],
            'fecha_aniversario'           => $fechaAniversarioPreview,   // K tal cual del Excel
            'fecha_aniversario_import'    => $fechaAniversarioImport,    // K normalizado Y-m-d
            'fecha_inicio_periodo_actual' => $fechaInicio,
            'fecha_fin_periodo_actual'    => $fechaFin,
            'antiguedad'            => $antiguedad,
            'dias_corresponden'     => $diasCorresponden,
            'dias_disfrutados_antes'  => $diasDisfrutadosAntes,
            'dias_disfrutados_actual' => $diasDisfrutadosPeriodo,
            'dias_disfrutados_despues' => $diasDisfrutadosDespues,
            'saldo_pendiente'       => $saldoPendiente,
            'status'                => $status,
        ];
    }

    protected function findUserByName(string $nombreCompleto): ?User
    {
        $target = $this->normalizeUserName($nombreCompleto);
        if ($target === '') {
            return null;
        }

        $users = User::where('active', 1)
            ->select(['id', 'first_name', 'last_name'])
            ->get();

        foreach ($users as $user) {
            $full = $this->normalizeUserName(trim($user->last_name . ' ' . $user->first_name));
            if ($full === $target) {
                return $user;
            }
        }

        foreach ($users as $user) {
            $full = $this->normalizeUserName(trim($user->last_name . ' ' . $user->first_name));
            if (str_contains($full, $target) || str_contains($target, $full)) {
                return $user;
            }
        }

        return null;
    }

    protected function findInactiveUserByName(string $nombreCompleto): ?User
    {
        $target = $this->normalizeUserName($nombreCompleto);
        if ($target === '') {
            return null;
        }

        $users = User::where('active', 2)
            ->select(['id', 'active', 'first_name', 'last_name'])
            ->get();

        foreach ($users as $user) {
            $full = $this->normalizeUserName(trim($user->last_name . ' ' . $user->first_name));
            if ($full === $target) {
                return $user;
            }
        }

        foreach ($users as $user) {
            $full = $this->normalizeUserName(trim($user->last_name . ' ' . $user->first_name));
            if (str_contains($full, $target) || str_contains($target, $full)) {
                return $user;
            }
        }

        return null;
    }

    protected function normalizeUserName(string $text): string
    {
        $text = strtoupper(trim(preg_replace('/\s+/', ' ', $text)));
        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

        return $ascii !== false ? $ascii : $text;
    }

    protected function parseDate($value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        try {
            if (preg_match('/^(\d{2})[\/\-](\d{2})[\/\-](\d{2,4})$/', $value, $m)) {
                $year = strlen($m[3]) === 2 ? '20' . $m[3] : $m[3];
                return Carbon::createFromFormat('d-m-Y', $m[1] . '-' . $m[2] . '-' . $year)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("Error parseando fecha: {$value} - {$e->getMessage()}");
            return null;
        }
    }

    public function confirmAssignUser($recordIndex)
    {
        $userId = $this->pendingUserAssignments[$recordIndex] ?? null;
        
        if (!$userId) {
            $this->notification([
                'title' => 'Selección requerida',
                'description' => 'Debes seleccionar un empleado primero',
                'icon' => 'error'
            ]);
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            return;
        }

        // Buscar el registro en unmatchedRecords
        foreach ($this->unmatchedRecords as $index => $record) {
            if ($record['index'] === $recordIndex) {
                $this->unmatchedRecords[$index]['user'] = $user;
                $this->userMatches[$recordIndex] = $userId;
                
                // Mover a validRecords
                $this->validRecords[] = $this->unmatchedRecords[$index];
                unset($this->unmatchedRecords[$index]);
                
                // Reindexar array
                $this->unmatchedRecords = array_values($this->unmatchedRecords);
                
                // Limpiar asignación pendiente
                unset($this->pendingUserAssignments[$recordIndex]);
                
                $this->notification([
                    'title' => '✓ Asignado',
                    'description' => "{$user->first_name} {$user->last_name}",
                    'icon' => 'success'
                ]);
                
                break;
            }
        }
    }

    public function updateRecordValue($recordIndex, $field, $value)
    {
        $value = floatval($value);
        
        // Validar que no sea negativo
        if ($value < 0) {
            $this->notification([
                'title' => '✗ Negativo',
                'description' => 'No permitido',
                'icon' => 'error'
            ]);
            return;
        }

        // Buscar y actualizar en validRecords
        foreach ($this->validRecords as $index => $record) {
            if ($record['index'] === $recordIndex) {
                $this->validRecords[$index][$field] = $value;
                
                // Validar días disfrutados <= días disponibles
                $diasDisponibles = $this->validRecords[$index]['dias_disponibles'];
                $diasDisfrutados = $this->validRecords[$index]['dias_disfrutados'];
                
                if ($diasDisfrutados > $diasDisponibles) {
                    $this->notification([
                        'title' => '⚠ Excede',
                        'description' => "Disfrutados: {$diasDisfrutados} > Disponibles: {$diasDisponibles}",
                        'icon' => 'warning'
                    ]);
                } else {
                    $this->notification([
                        'title' => '✓ OK',
                        'description' => 'Actualizado',
                        'icon' => 'success'
                    ]);
                }
                
                return;
            }
        }
    }

    public function executeImport()
    {
        if (empty($this->validRecords)) {
            $this->notification()->warning(
                'Sin datos',
                'No hay registros válidos para importar.'
            );
            return;
        }

        DB::beginTransaction();
        try {
            $updated = 0;
            $skipped = 0;
            $errors = [];

            foreach ($this->validRecords as $record) {
                // Si el usuario no existe en BD, notificar en resultados y continuar con el siguiente.
                if (empty($record['user'])) {
                    $errorMsg = $record['user_error'] ?? 'Usuario no identificado (no existe en la BD o no se pudo mapear).';
                    $errors[] = [
                        'nombre' => $record['nombre_completo'] ?: 'N/D',
                        'error' => $errorMsg
                    ];
                    
                    // Registrar en logs del sistema (usar inactive_user_id si está disponible)
                    SystemLog::logError(
                        'vacation_import',
                        $errorMsg,
                        $record['inactive_user_id'] ?? null, // Usar ID de usuario inactivo si existe
                        [
                            'nombre_completo' => $record['nombre_completo'],
                            'numero_empleado' => $record['numero_empleado'] ?? null,
                            'fecha_aniversario' => $record['fecha_aniversario_import'] ?? null,
                        ]
                    );
                    continue;
                }

                $userId = $record['user']->id ?? null;
                $fechaAniversarioActual = $record['fecha_aniversario_import'] ?? null; // Columna K

                if (!$userId || !$fechaAniversarioActual) {
                    $errorMsg = 'Falta fecha de aniversario (columna K)';
                    $errors[] = [
                        'nombre' => $record['nombre_completo'],
                        'error' => $errorMsg
                    ];
                    
                    // Registrar en logs del sistema
                    SystemLog::logError(
                        'vacation_import',
                        $errorMsg,
                        $userId,
                        [
                            'nombre_completo' => $record['nombre_completo'],
                        ]
                    );
                    continue;
                }

                try {
                    // 1. Actualizar período ACTUAL (fecha aniversario = date_end)
                    $periodoActual = VacationsAvailable::where('users_id', $userId)
                        ->where('date_end', $fechaAniversarioActual)
                        ->first();

                    if ($periodoActual) {
                        // Columna Q: saldo pendiente → days_availables
                        $diasDisponiblesActual = (float) str_replace([',', ' '], '', $record['saldo_pendiente']);
                        
                        // CALCULADO: days_enjoyed = total - Q
                        // Usar relación con catálogo centralizado
                        $totalActual = (float) ($periodoActual->vacationPerYear->days ?? 0);
                        $diasDisfrutadosActual = max(0, $totalActual - $diasDisponiblesActual);
                        
                        // Columna N: días antes de aniversario
                        $diasAntesAniversario = (float) str_replace([',', ' '], '', $record['dias_disfrutados_antes'] ?: 0);
                        
                        // Columna P: días después de aniversario (3 meses)
                        $diasDespuesAniversario = (float) str_replace([',', ' '], '', $record['dias_disfrutados_despues'] ?: 0);

                        $periodoActual->update([
                            'days_availables' => $diasDisponiblesActual,
                            'days_enjoyed' => $diasDisfrutadosActual,
                            'days_enjoyed_before_anniversary' => $diasAntesAniversario,
                            'days_enjoyed_after_anniversary' => $diasDespuesAniversario,
                        ]);

                        $updated++;
                    } else {
                        $skipped++;
                        
                        // Buscar la fecha real de aniversario del usuario
                        $usuario = $record['user'];
                        $fechaAdmisionReal = $usuario->admission ? Carbon::parse($usuario->admission)->format('d-m-Y') : 'N/D';
                        $fechaAniversarioReal = $usuario->admission ? Carbon::parse($usuario->admission)->format('d-m-Y') : 'N/D';
                        $fechaExcel = Carbon::parse($fechaAniversarioActual)->format('d-m-Y');
                        
                        $errorMsg = "No se encontró período con fecha fin {$fechaExcel}. Este usuario tiene fecha de admisión {$fechaAdmisionReal} (aniversario {$fechaAniversarioReal}). Verifique que está usando la fecha correcta en el Excel.";
                        
                        $errors[] = [
                            'nombre' => $record['nombre_completo'],
                            'error' => $errorMsg
                        ];
                        
                        // Registrar en logs del sistema
                        SystemLog::logError(
                            'vacation_import',
                            $errorMsg,
                            $userId,
                            [
                                'nombre_completo' => $record['nombre_completo'],
                                'fecha_excel' => $fechaExcel,
                                'fecha_admision_real' => $fechaAdmisionReal,
                                'fecha_aniversario_real' => $fechaAniversarioReal,
                            ]
                        );
                    }

                    // 2. Actualizar período ANTERIOR (fecha aniversario - 1 año)
                    // Columna J: saldo pendiente → days_availables
                    // CALCULADO: days_enjoyed = total - J (sin desglose antes/después)
                    $saldoPendienteAnterior = trim((string) ($record['periodo_anterior']['saldo_pendiente'] ?? ''));
                    
                    if ($saldoPendienteAnterior !== '') {
                        $fechaAniversarioAnterior = Carbon::parse($fechaAniversarioActual)->subYear()->format('Y-m-d');
                        
                        $periodoAnterior = VacationsAvailable::where('users_id', $userId)
                            ->where('date_end', $fechaAniversarioAnterior)
                            ->first();

                        if ($periodoAnterior) {
                            $diasDisponiblesAnterior = (float) str_replace([',', ' '], '', $saldoPendienteAnterior);
                            // Usar relación con catálogo centralizado
                            $totalAnterior = (float) ($periodoAnterior->vacationPerYear->days ?? 0);
                            $diasDisfrutadosAnterior = max(0, $totalAnterior - $diasDisponiblesAnterior);

                            $periodoAnterior->update([
                                'days_availables' => $diasDisponiblesAnterior,
                                'days_enjoyed' => $diasDisfrutadosAnterior,
                            ]);
                        }
                        // Si no existe período anterior, se omite silenciosamente (no es error)
                    }

                } catch (\Exception $e) {
                    $errorMsg = $e->getMessage();
                    $errors[] = [
                        'nombre' => $record['nombre_completo'],
                        'error' => $errorMsg
                    ];
                    Log::error('Error importando registro: ' . $errorMsg, $record);
                    
                    // Registrar en logs del sistema
                    SystemLog::logError(
                        'vacation_import',
                        'Error al procesar importación: ' . $errorMsg,
                        $userId ?? null,
                        [
                            'nombre_completo' => $record['nombre_completo'],
                            'exception' => get_class($e),
                            'trace' => $e->getTraceAsString(),
                        ]
                    );
                }
            }

            DB::commit();

            $this->importResults = [
                'total' => count($this->validRecords),
                'updated' => $updated,
                'skipped' => $skipped,
                'errors' => $errors,
                'pending' => count($this->unmatchedRecords)
            ];

            $this->step = 3;

            $this->notification()->success(
                'Importación completada',
                sprintf(
                    'Se procesaron %d registros: %d actualizados, %d omitidos.',
                    count($this->validRecords),
                    $updated,
                    $skipped
                )
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en importación masiva: ' . $e->getMessage());
            $this->notification()->error(
                'Error',
                'Ocurrió un error durante la importación: ' . $e->getMessage()
            );
        }
    }

    public function downloadTemplate()
    {
        // Ruta del archivo template (layout_vacations_example.xlsx)
        $templatePath = storage_path('app/templates/layout_vacations_example.xlsx');
        
        // Verificar que el template existe
        if (!file_exists($templatePath)) {
            $this->notification()->error(
                'Error',
                'No se encontró el archivo template. Contacte al administrador.'
            );
            return;
        }

        // Nombre del archivo de descarga
        $fileName = 'plantilla_importacion_vacaciones.xlsx';
        $downloadPath = storage_path('app/public/' . $fileName);

        // Copiar el template a la ubicación de descarga
        copy($templatePath, $downloadPath);

        return response()->download($downloadPath)->deleteFileAfterSend(true);
    }

    public function resetImport()
    {
        $this->reset([
            'importFile',
            'step',
            'validRecords',
            'unmatchedRecords',
            'importResults',
            'userMatches'
        ]);
    }
}

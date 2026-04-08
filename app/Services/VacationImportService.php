<?php

namespace App\Services;

use App\Models\User;
use App\Models\VacationsAvailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Border;

/**
 * Servicio para importar vacaciones masivamente desde Excel
 */
class VacationImportService
{
    /**
     * Importar vacaciones desde archivo Excel
     */
    public function importFromFile(string $filePath): array
    {
        try {
            $rows = (new FastExcel)->import($filePath)->toArray();
            return $this->processRows($rows);
        } catch (\Exception $e) {
            Log::error('Error al cargar archivo Excel: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al leer el archivo: ' . $e->getMessage(),
                'processed' => 0,
                'updated' => 0,
                'created' => 0,
                'errors' => 0,
                'details' => []
            ];
        }
    }

    /**
     * Importar desde datos ya parseados (para Livewire)
     */
    public function importFromArray(array $rows): array
    {
        return $this->processRows($rows);
    }

    /**
     * Procesar filas del Excel
     */
    protected function processRows(array $rows): array
    {
        $processed = 0;
        $updated = 0;
        $created = 0;
        $errors = 0;
        $errorDetails = [];

        // FastExcel ya maneja los encabezados automáticamente
        if (empty($rows)) {
            return [
                'success' => false,
                'message' => 'El archivo está vacío',
                'processed' => 0,
                'updated' => 0,
                'created' => 0,
                'errors' => 0,
                'details' => []
            ];
        }

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 porque Excel headers en fila 1, datos en fila 2+

                // Saltar filas vacías
                if (empty(array_filter($row))) {
                    continue;
                }

                $processed++;

                try {
                    $result = $this->processRow($row);
                    if ($result['success']) {
                        if ($result['action'] === 'created') {
                            $created++;
                        } else {
                            $updated++;
                        }
                    } else {
                        $errors++;
                        $errorDetails[] = [
                            'row' => $rowNumber,
                            'message' => $result['message']
                        ];
                    }
                } catch (\Exception $e) {
                    $errors++;
                    $errorDetails[] = [
                        'row' => $rowNumber,
                        'message' => $e->getMessage()
                    ];
                    Log::error("Error procesando fila {$rowNumber}: " . $e->getMessage());
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Importación completada',
                'processed' => $processed,
                'updated' => $updated,
                'created' => $created,
                'errors' => $errors,
                'details' => $errorDetails
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en importación masiva: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error en la importación: ' . $e->getMessage(),
                'processed' => $processed,
                'updated' => $updated,
                'created' => $created,
                'errors' => $errors,
                'details' => $errorDetails
            ];
        }
    }

    /**
     * Validar encabezados del Excel
     */
    protected function validateHeaders(array $headers): bool
    {
        $requiredHeaders = [
            'user_id',
            'date_start',
            'date_end',
            'days_availables',
            // 'dv', // ❌ ELIMINADO - campo deprecado
            'days_enjoyed',
            'days_reserved',
            'status'
        ];

        foreach ($requiredHeaders as $required) {
            if (!isset($headers[$required])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Procesar una fila individual
     */
    protected function processRow(array $row): array
    {
        // FastExcel provee arrays asociativos con las claves de los encabezados
        $data = [
            'user_id' => $row['user_id'] ?? null,
            'date_start' => $row['date_start'] ?? null,
            'date_end' => $row['date_end'] ?? null,
            'days_availables' => $row['days_availables'] ?? null,
            // 'dv' => $row['dv'] ?? 0, // ❌ ELIMINADO - campo deprecado
            'days_enjoyed' => $row['days_enjoyed'] ?? 0,
            'days_reserved' => $row['days_reserved'] ?? 0,
            'status' => $row['status'] ?? 'actual',
        ];

        // Validar datos
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'days_availables' => 'required|numeric|min:0',
            // 'dv' => 'nullable|numeric|min:0', // ❌ ELIMINADO - campo deprecado
            'days_enjoyed' => 'nullable|numeric|min:0',
            'days_reserved' => 'nullable|numeric|min:0',
            'status' => 'required|in:actual,vencido',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => implode(', ', $validator->errors()->all())
            ];
        }

        // Buscar período existente por user_id y date_start
        $dateStart = Carbon::parse($data['date_start']);
        $dateEnd = Carbon::parse($data['date_end']);

        $period = VacationsAvailable::where('users_id', $data['user_id'])
            ->where('date_start', $dateStart->format('Y-m-d'))
            ->where('is_historical', false)
            ->first();

        // Calcular año de período basado en antigüedad real del usuario
        $periodNumber = $this->calculatePeriodNumber($data['user_id'], $dateStart);

        if ($period) {
            // Actualizar período existente
            $period->date_end = $dateEnd->format('Y-m-d');
            $period->days_availables = $data['days_availables'];
            // $period->dv = $data['dv']; // ❌ ELIMINADO - campo deprecado
            $period->days_enjoyed = $data['days_enjoyed'];
            $period->days_reserved = $data['days_reserved'];
            $period->status = $data['status'];
            $period->save();

            Log::info("Período actualizado para usuario {$data['user_id']}", [
                'period_id' => $period->id,
                'date_start' => $dateStart->format('Y-m-d'),
                'date_end' => $dateEnd->format('Y-m-d')
            ]);

            return [
                'success' => true,
                'message' => 'Período actualizado correctamente',
                'action' => 'updated'
            ];
        } else {
            // Crear nuevo período
            $newPeriod = VacationsAvailable::create([
                'users_id' => $data['user_id'],
                'period' => $periodNumber,
                'date_start' => $dateStart->format('Y-m-d'),
                'date_end' => $dateEnd->format('Y-m-d'),
                'days_availables' => $data['days_availables'],
                // 'dv' => $data['dv'], // ❌ ELIMINADO - campo deprecado
                'days_enjoyed' => $data['days_enjoyed'],
                'days_reserved' => $data['days_reserved'],
                'status' => $data['status'],
                'is_historical' => false,
            ]);

            Log::info("Período creado para usuario {$data['user_id']}", [
                'period_id' => $newPeriod->id,
                'period_number' => $periodNumber,
                'date_start' => $dateStart->format('Y-m-d'),
                'date_end' => $dateEnd->format('Y-m-d')
            ]);

            return [
                'success' => true,
                'message' => 'Período creado correctamente',
                'action' => 'created'
            ];
        }
    }

    /**
     * Calcular número de período basado en la fecha de inicio
     * Cuenta cuántos períodos tiene el usuario antes de esta fecha
     */
    protected function calculatePeriodNumber(int $userId, Carbon $dateStart): int
    {
        $user = User::select(['id', 'admission'])->find($userId);
        if ($user && !empty($user->admission) && $user->admission !== '0000-00-00' && $user->admission !== '0000-00-00 00:00:00') {
            try {
                $admissionDate = Carbon::parse($user->admission);
                return max(1, $dateStart->diffInYears($admissionDate) + 1);
            } catch (\Exception $e) {
                // Fallback a conteo secuencial si la fecha de ingreso no es válida.
            }
        }

        $existingPeriodsCount = VacationsAvailable::where('users_id', $userId)
            ->where('is_historical', false)
            ->where('date_start', '<', $dateStart->format('Y-m-d'))
            ->count();

        return $existingPeriodsCount + 1;
    }

    /**
     * Generar plantilla Excel de ejemplo
     */
    public function generateTemplate(): string
    {
        $fileName = 'plantilla_importacion_vacaciones_' . date('YmdHis') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        // Datos de ejemplo
        $data = collect([
            [
                'user_id' => 52,
                'date_start' => '2024-08-08',
                'date_end' => '2025-08-08',
                'days_availables' => 12.00,
                // 'dv' => 0, // ❌ ELIMINADO - campo deprecado
                'days_enjoyed' => 5.00,
                'days_reserved' => 2.50,
                'status' => 'actual'
            ],
            [
                'user_id' => 52,
                'date_start' => '2023-08-08',
                'date_end' => '2024-08-08',
                'days_availables' => 12.00,
                // 'dv' => 1, // ❌ ELIMINADO - campo deprecado
                'days_enjoyed' => 12.00,
                'days_reserved' => 0.00,
                'status' => 'vencido'
            ],
            [
                'user_id' => 53,
                'date_start' => '2024-01-15',
                'date_end' => '2025-01-15',
                'days_availables' => 14.00,
                // 'dv' => 0, // ❌ ELIMINADO - campo deprecado
                'days_enjoyed' => 8.00,
                'days_reserved' => 3.00,
                'status' => 'actual'
            ],
        ]);

        (new FastExcel($data))->export($filePath);

        return $fileName;
    }
}

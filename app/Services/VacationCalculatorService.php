<?php

namespace App\Services;

use App\Models\User;
use App\Models\VacationsAvailable;
use App\Models\VacationPerYear;
use App\Models\RequestVacations;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VacationCalculatorService
{
    /**
     * Fecha de cambio de política (ajustar según necesidad)
     * Empleados contratados desde 2023 en adelante usan esquema nuevo
     */
    const POLICY_CHANGE_DATE = '2023-01-01';

    /**
     * Días de vacaciones según esquema antiguo
     */
    const OLD_SCHEME_DAYS = [
        1 => 6,
        2 => 8,
        3 => 10,
        4 => 12,
        // 5 años en adelante: +2 días por año hasta máximo 32
    ];

    /**
     * Días de vacaciones según esquema actual
     */
    const CURRENT_SCHEME_DAYS = [
        1 => 12,
        2 => 14,
        3 => 16,
        4 => 18,
        5 => 20,
        // 5 años en adelante: +2 días por año hasta máximo 32
    ];

    /**
     * Máximo de días de vacaciones
     */
    const MAX_VACATION_DAYS = 32;

    /**
     * Periodo de vencimiento en meses (15 meses después del fin del periodo)
     */
    const EXPIRATION_MONTHS = 15;

    /**
     * Calcular y generar vacaciones para un usuario
     */
    public function calculateVacationsForUser(User $user): array
    {
        if (!$user->admission) {
            return [
                'success' => false,
                'message' => 'El usuario no tiene fecha de ingreso registrada'
            ];
        }

        // Validar fecha de admisión válida
        try {
            $admissionDate = Carbon::parse($user->admission);
            if ($admissionDate->year < 1900 || $admissionDate->isFuture()) {
                Log::warning("User {$user->id} has invalid admission date: {$user->admission}");
                return [
                    'success' => false,
                    'message' => 'Fecha de ingreso inválida'
                ];
            }
        } catch (\Exception $e) {
            Log::error("Error parsing admission date for user {$user->id}: {$e->getMessage()}");
            return [
                'success' => false,
                'message' => 'Error al procesar fecha de ingreso'
            ];
        }

        $policyChangeDate = Carbon::parse(self::POLICY_CHANGE_DATE);
        $today = Carbon::today();

        // Determinar si usa esquema antiguo o actual
        $usesOldScheme = $admissionDate->lt($policyChangeDate);

        DB::beginTransaction();
        try {
            $results = [];

            // Generación de registros bajo el esquema anterior (pre-2023) deshabilitada.
            // Ya es 2026; los empleados con ingreso previo a 2023 pueden tener esos registros ya en BD.
            // La variable $usesOldScheme se mantiene para que calculateCurrentScheme
            // calcule correctamente el año de inicio y la antigüedad acumulada.
            /*
            if ($usesOldScheme) {
                $historicalResults = $this->generateHistoricalRecords($user, $admissionDate, $policyChangeDate);
                $results['historical'] = $historicalResults;
            }
            */

            // Calcular vacaciones del esquema actual
            $currentResults = $this->calculateCurrentScheme($user, $admissionDate, $today, $usesOldScheme, $policyChangeDate);
            $results['current'] = $currentResults;

            DB::commit();

            return [
                'success' => true,
                'message' => 'Vacaciones calculadas exitosamente',
                'data' => $results
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error calculating vacations for user ' . $user->id . ': ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error al calcular vacaciones: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generar registros históricos del esquema antiguo
     * Solo crea registros que no existen, preserva datos existentes
     */
    protected function generateHistoricalRecords(User $user, Carbon $admissionDate, Carbon $policyChangeDate): array
    {
        $records = [];
        $startYear = $admissionDate->year;
        $endYear = $policyChangeDate->year - 1;

        for ($year = $startYear; $year <= $endYear; $year++) {
            $yearsSeniority = $year - $admissionDate->year + 1;
            $daysForYear = $this->getDaysForSeniority($yearsSeniority, self::OLD_SCHEME_DAYS);

            // Fecha de inicio y fin del periodo
            $dateStart = Carbon::create($year, $admissionDate->month, $admissionDate->day);
            $dateEnd = $dateStart->copy()->addYear();
            $cutoffDate = $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS);

            // Verificar si ya existe el registro
            $existingRecord = VacationsAvailable::where('users_id', $user->id)
                ->where('date_start', $dateStart)
                ->where('is_historical', true)
                ->first();

            if ($existingRecord) {
                // El registro ya existe, lo agregamos a la lista pero NO lo modificamos
                // days_total_period eliminado - se obtiene de relación vacationPerYear
                $records[] = $existingRecord;
                Log::info("Período histórico ya existe, se preservan datos", [
                    'user_id' => $user->id,
                    'date_start' => $dateStart->format('Y-m-d'),
                    'days_reserved' => $existingRecord->days_reserved ?? 0
                ]);
            } else {
                // Solo crear si no existe
                $record = VacationsAvailable::create([
                    'users_id' => $user->id,
                    'period' => max(1, $yearsSeniority),
                    // days_total_period eliminado - se obtiene de relación vacationPerYear
                    'days_availables' => $daysForYear,
                    // 'dv' => 0, // ❌ ELIMINADO - campo deprecado
                    'days_enjoyed' => $daysForYear, // Marcados como tomados
                    'days_reserved' => 0,
                    'date_start' => $dateStart,
                    'date_end' => $dateEnd,
                    'cutoff_date' => $cutoffDate,
                    'is_historical' => true,
                ]);

                $records[] = $record;
                Log::info("Nuevo período histórico creado", [
                    'user_id' => $user->id,
                    'date_start' => $dateStart->format('Y-m-d')
                ]);
            }
        }

        return $records;
    }

    /**
     * Calcular vacaciones del esquema actual
     * Solo crea períodos nuevos, actualiza solo days_availables en períodos activos sin tocar days_reserved
     */
    protected function calculateCurrentScheme(User $user, Carbon $admissionDate, Carbon $today, bool $usesOldScheme, Carbon $policyChangeDate): array
    {
        $records = [];
        
        // Determinar el año de inicio para el esquema actual
        $startYear = $usesOldScheme ? $policyChangeDate->year : $admissionDate->year;
        $currentYear = $today->year;

        for ($year = $startYear; $year <= $currentYear; $year++) {
            // Calcular años de antigüedad desde la admisión
            $anniversaryDate = Carbon::create($year, $admissionDate->month, $admissionDate->day);
            
            // Solo calcular si ya cumplió al menos 1 año
            if ($anniversaryDate->gt($today)) {
                continue;
            }

            $yearsSeniority = $year - $admissionDate->year + 1;
            $daysForYear = $this->getDaysForSeniority($yearsSeniority, self::CURRENT_SCHEME_DAYS);

            // Fecha de inicio y fin del periodo
            $dateStart = $anniversaryDate->copy();
            $dateEnd = $dateStart->copy()->addYear();

            // Verificar si ya existe el registro
            $existingRecord = VacationsAvailable::where('users_id', $user->id)
                ->where('date_start', $dateStart)
                ->where('is_historical', false)
                ->first();

            if ($existingRecord) {
                // El registro ya existe - solo actualizar si es el periodo actual
                $this->checkAndMarkExpired($existingRecord, $today);
                
                // Solo actualizar acumulación si estamos en el periodo actual y aún no termina
                if ($today->between($dateStart, $dateEnd)) {
                    $accumulatedDays = $this->calculateDailyAccumulation($dateStart, $today, $daysForYear);
                    
                    // IMPORTANTE: Solo actualizar days_availables, preservar days_reserved y days_enjoyed
                    $existingRecord->days_availables = $accumulatedDays;
                    // days_total_period eliminado - se obtiene de relación vacationPerYear
                    $existingRecord->save();
                    
                    Log::info("Acumulación diaria actualizada (preservando days_reserved)", [
                        'user_id' => $user->id,
                        'period' => $existingRecord->period,
                        'date_start' => $dateStart->format('Y-m-d'),
                        'days_availables' => $accumulatedDays,
                        'days_reserved' => $existingRecord->days_reserved ?? 0,
                        'days_enjoyed' => $existingRecord->days_enjoyed
                    ]);
                }
                
                $records[] = $existingRecord;
            } else {
                // Registro no existe - crear nuevo
                // Calcular días acumulados
                $endCalculation = $today->lte($dateEnd) ? $today : $dateEnd;
                $accumulatedDays = $this->calculateDailyAccumulation($dateStart, $endCalculation, $daysForYear);

                // Calcular días disfrutados de solicitudes aprobadas
                $daysEnjoyed = $this->calculateDaysEnjoyed($user, $dateStart, $dateEnd);

                // Determinar si el periodo ya está vencido al momento de creación
                $expirationDate = $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS);
                $status = $today->gt($expirationDate) ? 'vencido' : 'actual';

                $record = VacationsAvailable::create([
                    'users_id' => $user->id,
                    'period' => max(1, $yearsSeniority),
                    // days_total_period eliminado - se obtiene de relación vacationPerYear
                    'days_availables' => $accumulatedDays,
                    // 'dv' => 0, // ❌ ELIMINADO - campo deprecado
                    'days_enjoyed' => $daysEnjoyed,
                    'days_reserved' => 0, // Inicializar en 0 para nuevos registros
                    'date_start' => $dateStart,
                    'date_end' => $dateEnd,
                    'cutoff_date' => $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS),
                    'is_historical' => false,
                    'status' => $status,
                ]);

                $records[] = $record;
                
                Log::info("Nuevo período creado", [
                    'user_id' => $user->id,
                    'period' => $record->period,
                    'date_start' => $dateStart->format('Y-m-d'),
                    'days_availables' => $accumulatedDays
                ]);
            }
        }

        return $records;
    }

    /**
     * Verificar y marcar periodos como vencidos si han pasado 15 meses desde el fin del periodo
     */
    protected function checkAndMarkExpired(VacationsAvailable $vacation, Carbon $today): void
    {
        // No marcar históricos como vencidos (ya lo están implícitamente)
        if ($vacation->is_historical) {
            return;
        }

        // Calcular fecha de vencimiento: 15 meses después del fin del periodo
        $expirationDate = $vacation->date_end->copy()->addMonths(self::EXPIRATION_MONTHS);

        // Si ya pasó la fecha de vencimiento y no está marcado como vencido
        if ($today->gt($expirationDate) && $vacation->status !== 'vencido') {
            $vacation->status = 'vencido';
            $vacation->save();

            Log::info("Periodo de vacaciones vencido automáticamente", [
                'vacation_id' => $vacation->id,
                'user_id' => $vacation->users_id,
                'period' => $vacation->period,
                'date_end' => $vacation->date_end->format('Y-m-d'),
                'expiration_date' => $expirationDate->format('Y-m-d'),
                'days_remaining' => $vacation->days_availables - $vacation->days_enjoyed // saldo = fijo - tomados
            ]);
        }
    }

    /**
     * Calcular acumulación diaria proporcional
     */
    protected function calculateDailyAccumulation(Carbon $startDate, Carbon $endDate, int $annualDays): float
    {
        $year = $startDate->year;
        $isLeapYear = $startDate->isLeapYear();
        $totalDaysInYear = $isLeapYear ? 366 : 365;

        // Días trabajados en el periodo
        $daysWorked = $startDate->diffInDays($endDate) + 1;

        // Cálculo proporcional
        $accumulatedDays = ($annualDays * $daysWorked) / $totalDaysInYear;

        // Redondear a 2 decimales
        return round($accumulatedDays, 2);
    }

    /**
     * Calcular días disfrutados en un periodo
     */
    protected function calculateDaysEnjoyed(User $user, Carbon $startDate, Carbon $endDate): int
    {
        return RequestVacations::where('user_id', $user->id)
            ->where('human_resources_status', 'Aprobada')
            ->whereHas('requestDays', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start', [$startDate, $endDate]);
            })
            ->with('requestDays')
            ->get()
            ->sum(function ($request) use ($startDate, $endDate) {
                return $request->requestDays->filter(function ($day) use ($startDate, $endDate) {
                    $dayDate = Carbon::parse($day->start);
                    return $dayDate->between($startDate, $endDate);
                })->count();
            });
    }

    /**
     * Obtener días de vacaciones según antigüedad
     */
    /**
     * Obtener días de vacaciones según antigüedad
     * Usa la tabla vacation_per_years como fuente central de verdad
     */
    protected function getDaysForSeniority(int $years, array $scheme): int
    {
        // Primero intentar obtener de la tabla centralizada
        $days = VacationPerYear::getDaysForYear($years);
        
        if ($days > 0) {
            return $days;
        }
        
        // Fallback al esquema hardcodeado (solo si la tabla no está poblada)
        if ($years <= 4) {
            return $scheme[$years] ?? 0;
        }

        // Rangos según LFT México (fallback)
        $ranges = [
            [5, 5, 20],
            [6, 10, 22],
            [11, 15, 24],
            [16, 20, 26],
            [21, 25, 28],
            [26, 30, 30],
            [31, 35, 32],
        ];

         foreach ($ranges as [$min, $max, $days]) {
            if ($years >= $min && $years <= $max) {
                return $days;
            }
        }

        return self::MAX_VACATION_DAYS;
    }

    /**
     * Obtener días disponibles totales para un usuario
     * Excluye periodos históricos, vencidos y aquellos cuyo cutoff_date ya pasó
     */
    public function getAvailableDaysForUser(User $user): array
    {
        $totalAvailable = 0;
        $totalEnjoyed = 0;
        $totalRemaining = 0;
        $today = \Carbon\Carbon::today();

        $allVacations = VacationsAvailable::where('users_id', $user->id)
            ->where('is_historical', false)
            ->where('status', '!=', 'vencido')
            ->get();

        // Solo periodos dentro del rango vigente: date_end <= hoy <= cutoff_date
        // Antes de date_end el empleado no ha cumplido el año, no puede usar los días
        $vacations = $allVacations->filter(function ($vacation) use ($today) {
            $dateEnd = \Carbon\Carbon::parse($vacation->date_end);
            $cutoff = !empty($vacation->cutoff_date)
                ? \Carbon\Carbon::parse($vacation->cutoff_date)
                : $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS);
            return $today->gte($dateEnd) && $today->lte($cutoff);
        })->values();

        foreach ($vacations as $vacation) {
            $available = $vacation->days_availables;
            $enjoyed = $vacation->days_enjoyed;
            $remaining = $available - $enjoyed;

            $totalAvailable += $available;
            $totalEnjoyed += $enjoyed;
            $totalRemaining += $remaining;
        }

        return [
            'total_available' => round($totalAvailable, 2),
            'total_enjoyed' => $totalEnjoyed,
            'total_remaining' => round($totalRemaining, 2),
            'periods' => $vacations,
        ];
    }

    /**
     * Recalcular vacaciones para todos los usuarios
     */
    public function recalculateAllUsers(): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        User::whereHas('job')->chunk(100, function ($users) use (&$results) {
            foreach ($users as $user) {
                $result = $this->calculateVacationsForUser($user);
                if ($result['success']) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                    $results['errors'][] = [
                        'user_id' => $user->id,
                        'message' => $result['message']
                    ];
                }
            }
        });
        
        return $results;
    }

    /**
     * Verificar y marcar periodos vencidos para todos los usuarios
     * Debe ejecutarse diariamente para mantener los estados actualizados
     */
    public function checkExpiredPeriodsForAllUsers(): array
    {
        $results = [
            'checked' => 0,
            'expired' => 0,
            'errors' => []
        ];

        $today = Carbon::today();

        try {
            // Obtener todos los periodos activos (no históricos y no vencidos)
            VacationsAvailable::where('is_historical', false)
                ->where('status', '!=', 'vencido')
                ->chunk(100, function ($vacations) use (&$results, $today) {
                    foreach ($vacations as $vacation) {
                        try {
                            $results['checked']++;
                            
                            // Calcular fecha de vencimiento
                            $expirationDate = $vacation->date_end->copy()->addMonths(self::EXPIRATION_MONTHS);
                            
                            // Verificar si debe vencer
                            if ($today->gt($expirationDate)) {
                                $vacation->status = 'vencido';
                                $vacation->save();
                                $results['expired']++;
                                
                                Log::info("Periodo vencido automáticamente en verificación masiva", [
                                    'vacation_id' => $vacation->id,
                                    'user_id' => $vacation->users_id,
                                    'period' => $vacation->period,
                                    'date_end' => $vacation->date_end->format('Y-m-d'),
                                    'expiration_date' => $expirationDate->format('Y-m-d')
                                ]);
                            }
                        } catch (\Exception $e) {
                            $results['errors'][] = [
                                'vacation_id' => $vacation->id,
                                'message' => $e->getMessage()
                            ];
                        }
                    }
                });
        } catch (\Exception $e) {
            Log::error('Error al verificar periodos vencidos: ' . $e->getMessage());
            $results['errors'][] = [
                'general' => $e->getMessage()
            ];
        }

        return $results;
    }
}

<?php

namespace App\Services;

use App\Models\User;
use App\Models\VacationsAvailable;
use App\Models\RequestVacations;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Servicio responsable ÚNICAMENTE de crear nuevos períodos de vacaciones.
 * No modifica períodos existentes, solo crea los que faltan.
 */
class VacationPeriodCreatorService
{
    /**
     * Fecha de cambio de política
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
    ];

    /**
     * Días de vacaciones según esquema actual (LFT México)
     */
    const CURRENT_SCHEME_DAYS = [
        1 => 12,
        2 => 14,
        3 => 16,
        4 => 18,
        5 => 20,
    ];

    /**
     * Máximo de días de vacaciones
     */
    const MAX_VACATION_DAYS = 32;

    /**
     * Periodo de vencimiento en meses
     */
    const EXPIRATION_MONTHS = 15;

    /**
     * Crear períodos de vacaciones faltantes para un usuario.
     * Solo crea períodos nuevos, NO modifica existentes.
     */
    public function createMissingPeriodsForUser(User $user): array
    {
        if (!$user->admission) {
            return [
                'success' => false,
                'message' => 'El usuario no tiene fecha de ingreso registrada'
            ];
        }

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
        $usesOldScheme = $admissionDate->lt($policyChangeDate);

        DB::connection('mysql_vacations')->beginTransaction();
        try {
            $created = [];

            /**
             * Nota: Creación de períodos históricos (pre-2023) deshabilitada en producción.
             * La variable $usesOldScheme se conserva para calcular correctamente el año de inicio
             * y la antigüedad acumulada en createCurrentPeriods.
             */

            // Crear períodos del esquema actual
            $currentCreated = $this->createCurrentPeriods($user, $admissionDate, $today, $usesOldScheme, $policyChangeDate);
            $created['current'] = $currentCreated;

            DB::connection('mysql_vacations')->commit();

            $totalCreated = count($created['historical'] ?? []) + count($created['current'] ?? []);

            return [
                'success' => true,
                'message' => "Se crearon {$totalCreated} períodos nuevos",
                'data' => $created
            ];
        } catch (\Exception $e) {
            DB::connection('mysql_vacations')->rollBack();
            Log::error('Error creating periods for user ' . $user->id . ': ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error al crear períodos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Crear solo períodos históricos faltantes
     */
    protected function createHistoricalPeriods(User $user, Carbon $admissionDate, Carbon $policyChangeDate): array
    {
        $created = [];
        $startYear = $admissionDate->year;
        $endYear = $policyChangeDate->year - 1;

        for ($year = $startYear; $year <= $endYear; $year++) {
            $yearsSeniority = $year - $admissionDate->year + 1;
            $daysForYear = $this->getDaysForSeniority($yearsSeniority, self::OLD_SCHEME_DAYS);

            $dateStart = Carbon::create($year, $admissionDate->month, $admissionDate->day);
            $dateEnd = $dateStart->copy()->addYear();
            $cutoffDate = $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS);

            $exists = VacationsAvailable::where('users_id', $user->id)
                ->whereYear('date_start', $dateStart->year)
                ->whereMonth('date_start', $dateStart->month)
                ->where('is_historical', true)
                ->exists();

            if (!$exists) {
                $record = VacationsAvailable::create([
                    'users_id' => $user->id,
                    'period' => max(1, $yearsSeniority),
                    'days_availables' => $daysForYear,
                    'days_calculated' => 0,
                    'days_enjoyed' => $daysForYear,
                    'days_reserved' => 0,
                    'date_start' => $dateStart,
                    'date_end' => $dateEnd,
                    'cutoff_date' => $cutoffDate,
                    'is_historical' => true,
                ]);

                $created[] = $record;
                
                Log::info("Período histórico creado", [
                    'user_id' => $user->id,
                    'date_start' => $dateStart->format('Y-m-d'),
                    'days' => $daysForYear
                ]);
            }
        }

        return $created;
    }

    /**
     * Crear solo períodos actuales faltantes
     */
    protected function createCurrentPeriods(User $user, Carbon $admissionDate, Carbon $today, bool $usesOldScheme, Carbon $policyChangeDate): array
    {
        $created = [];
        $startYear = $usesOldScheme ? $policyChangeDate->year : $admissionDate->year;
        $currentYear = $today->year;
        $anniversaryMonth = (int) $admissionDate->month;
        $anniversaryDay = (int) $admissionDate->day;

        $lastPeriod = VacationsAvailable::where('users_id', $user->id)
            ->where('is_historical', false)
            ->orderBy('date_end', 'desc')
            ->first();

        if ($lastPeriod && $today->gte($lastPeriod->date_end)) {
            $nextPeriodStart = $lastPeriod->date_end->copy();
            $nextPeriodEnd = $nextPeriodStart->copy()->addYear();
            $isAnniversaryStart = (int) $nextPeriodStart->month === $anniversaryMonth
                && (int) $nextPeriodStart->day === $anniversaryDay;
            $isWithinAllowedRange = $nextPeriodStart->year <= $currentYear && $nextPeriodStart->lte($today);
            
            $nextExists = VacationsAvailable::where('users_id', $user->id)
                ->whereYear('date_start', $nextPeriodStart->year)
                ->whereMonth('date_start', $nextPeriodStart->month)
                ->where('is_historical', false)
                ->exists();
            
            if (!$nextExists && $isAnniversaryStart && $isWithinAllowedRange) {
                $yearsSeniority = $nextPeriodStart->diffInYears($admissionDate) + 1;
                $daysForYear = $this->getDaysForSeniority($yearsSeniority, self::CURRENT_SCHEME_DAYS);
                
                $endCalculation = $today->lte($nextPeriodEnd) ? $today : $nextPeriodEnd;
                $accumulatedDays = $this->calculateDailyAccumulation($nextPeriodStart, $endCalculation, $daysForYear);
                
                $daysEnjoyed = $this->calculateDaysEnjoyed($user, $nextPeriodStart, $nextPeriodEnd);
                
                $expirationDate = $nextPeriodEnd->copy()->addMonths(self::EXPIRATION_MONTHS);
                $status = $today->gt($expirationDate) ? 'vencido' : 'actual';
                
                $record = VacationsAvailable::create([
                    'users_id' => $user->id,
                    'period' => max(1, $yearsSeniority),
                    'days_availables' => $accumulatedDays,
                    'days_calculated' => $accumulatedDays,
                    'days_enjoyed' => $daysEnjoyed,
                    'days_reserved' => 0,
                    'date_start' => $nextPeriodStart,
                    'date_end' => $nextPeriodEnd,
                    'cutoff_date' => $nextPeriodEnd->copy()->addMonths(self::EXPIRATION_MONTHS),
                    'is_historical' => false,
                    'status' => $status,
                ]);
                
                $created[] = $record;
                
                Log::info("Nuevo período creado (siguiente al último)", [
                    'user_id' => $user->id,
                    'period' => $record->period,
                    'date_start' => $nextPeriodStart->format('Y-m-d'),
                    'date_end' => $nextPeriodEnd->format('Y-m-d'),
                    'days_availables' => $accumulatedDays,
                    'status' => $status
                ]);
            } elseif (!$nextExists && (!$isAnniversaryStart || !$isWithinAllowedRange)) {
                Log::warning('Período omitido por no cumplir validación de aniversario o rango permitido', [
                    'user_id' => $user->id,
                    'candidate_start' => $nextPeriodStart->format('Y-m-d'),
                    'candidate_end' => $nextPeriodEnd->format('Y-m-d'),
                    'today' => $today->format('Y-m-d'),
                    'is_anniversary_start' => $isAnniversaryStart,
                    'is_within_allowed_range' => $isWithinAllowedRange,
                ]);
            }
        }

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $anniversaryDate = Carbon::create($year, $admissionDate->month, $admissionDate->day);
            
            if ($anniversaryDate->gt($today)) {
                continue;
            }

            $yearsSeniority = $year - $admissionDate->year + 1;
            $daysForYear = $this->getDaysForSeniority($yearsSeniority, self::CURRENT_SCHEME_DAYS);

            $dateStart = $anniversaryDate->copy();
            $dateEnd = $dateStart->copy()->addYear();

            $exists = VacationsAvailable::where('users_id', $user->id)
                ->whereYear('date_start', $dateStart->year)
                ->whereMonth('date_start', $dateStart->month)
                ->where('is_historical', false)
                ->exists();

            if (!$exists) {
                $endCalculation = $today->lte($dateEnd) ? $today : $dateEnd;
                $accumulatedDays = $this->calculateDailyAccumulation($dateStart, $endCalculation, $daysForYear);

                $daysEnjoyed = $this->calculateDaysEnjoyed($user, $dateStart, $dateEnd);

                $expirationDate = $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS);
                $status = $today->gt($expirationDate) ? 'vencido' : 'actual';

                $record = VacationsAvailable::create([
                    'users_id' => $user->id,
                    'period' => max(1, $yearsSeniority),
                    'days_availables' => $accumulatedDays,
                    'days_calculated' => $accumulatedDays,
                    'days_enjoyed' => $daysEnjoyed,
                    'days_reserved' => 0,
                    'date_start' => $dateStart,
                    'date_end' => $dateEnd,
                    'cutoff_date' => $dateEnd->copy()->addMonths(self::EXPIRATION_MONTHS),
                    'is_historical' => false,
                    'status' => $status,
                ]);

                $created[] = $record;
                
                Log::info("Período actual creado", [
                    'user_id' => $user->id,
                    'period' => $record->period,
                    'date_start' => $dateStart->format('Y-m-d'),
                    'days_availables' => $accumulatedDays,
                    'status' => $status
                ]);
            }
        }

        return $created;
    }

    /**
     * Calcular acumulación diaria proporcional
     */
    protected function calculateDailyAccumulation(Carbon $startDate, Carbon $endDate, int $annualDays): float
    {
        $isLeapYear = $startDate->isLeapYear();
        $totalDaysInYear = $isLeapYear ? 366 : 365;
        $daysWorked = $startDate->diffInDays($endDate) + 1;
        $accumulatedDays = ($annualDays * $daysWorked) / $totalDaysInYear;

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
     * Obtener días de vacaciones según antigüedad.
     * Prioriza la tabla vacation_per_years como fuente centralizada.
     */
    protected function getDaysForSeniority(int $years, array $scheme): int
    {
        // Primero intentar obtener de la tabla centralizada
        $days = \App\Models\VacationPerYear::getDaysForYear($years);
        
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
     * Crear períodos para todos los usuarios
     */
    public function createMissingPeriodsForAllUsers(): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'total_created' => 0,
            'errors' => []
        ];

        User::where('active', 1)->chunk(100, function ($users) use (&$results) {
            foreach ($users as $user) {
                $result = $this->createMissingPeriodsForUser($user);
                if ($result['success']) {
                    $results['success']++;
                    $totalCreated = count($result['data']['historical'] ?? []) + count($result['data']['current'] ?? []);
                    $results['total_created'] += $totalCreated;
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
     * Método público para obtener días según antigüedad (útil para testing)
     */
    public function calculateDaysForYears(int $years): int
    {
        return $this->getDaysForSeniority($years, self::CURRENT_SCHEME_DAYS);
    }
}

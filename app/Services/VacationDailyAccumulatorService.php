<?php

namespace App\Services;

use App\Models\VacationsAvailable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Servicio responsable de actualizar la acumulación diaria de días.
 * Solo actualiza days_calculated en períodos activos, no crea ni elimina períodos.
 */
class VacationDailyAccumulatorService
{
    /**
     * Periodo de vencimiento en meses
     */
    const EXPIRATION_MONTHS = 15;

    /**
     * Actualizar acumulación diaria para un período específico
     */
    public function updateDailyAccumulation(VacationsAvailable $vacation): bool
    {
        try {
            if ($vacation->is_historical) {
                return false;
            }

            $today = Carbon::today();
            
            $this->checkAndMarkExpired($vacation, $today);

            if ($vacation->status === 'vencido') {
                return false;
            }

            if (!$today->between($vacation->date_start, $vacation->date_end)) {
                return false;
            }

            $annualDays = (float) ($vacation->vacationPerYear->days ?? 0);
            if ($annualDays <= 0) {
                $annualDays = $this->getExpectedDaysForPeriod($vacation);
            }
            $accumulatedDays = $this->calculateDailyAccumulation($vacation->date_start, $today, $annualDays);

            $oldValue = $vacation->days_calculated;
            $vacation->days_calculated = $accumulatedDays;
            $vacation->save();

            Log::info("Acumulación diaria actualizada", [
                'vacation_id' => $vacation->id,
                'user_id' => $vacation->users_id,
                'period' => $vacation->period,
                'old_value' => $oldValue,
                'new_value' => $accumulatedDays,
                'days_reserved' => $vacation->days_reserved ?? 0,
                'days_enjoyed' => $vacation->days_enjoyed
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Error actualizando acumulación diaria: " . $e->getMessage(), [
                'vacation_id' => $vacation->id
            ]);
            return false;
        }
    }

    /**
     * Actualizar acumulación diaria para todos los períodos de un usuario
     */
    public function updateDailyAccumulationForUser(int $userId): array
    {
        $results = [
            'updated' => 0,
            'skipped' => 0,
            'expired' => 0,
        ];

        $vacations = VacationsAvailable::where('users_id', $userId)
            ->where('is_historical', false)
            ->get();

        foreach ($vacations as $vacation) {
            $today = Carbon::today();
            
            if ($this->checkAndMarkExpired($vacation, $today)) {
                $results['expired']++;
                continue;
            }

            if ($this->updateDailyAccumulation($vacation)) {
                $results['updated']++;
            } else {
                $results['skipped']++;
            }
        }

        return $results;
    }

    /**
     * Actualizar acumulación diaria para todos los usuarios (proceso masivo)
     */
    public function updateDailyAccumulationForAllUsers(): array
    {
        $results = [
            'users_processed' => 0,
            'periods_updated' => 0,
            'periods_skipped' => 0,
            'periods_expired' => 0,
            'errors' => [],
            'details' => []
        ];

        $today = Carbon::today();

        try {
            VacationsAvailable::with(['user.job.departamento'])
                ->where('is_historical', false)
                ->where('status', '!=', 'vencido')
                ->chunk(100, function ($vacations) use (&$results, $today) {
                    foreach ($vacations as $vacation) {
                        try {
                            if ($this->checkAndMarkExpired($vacation, $today)) {
                                $results['periods_expired']++;
                                continue;
                            }

                            $oldValue = $vacation->days_calculated;

                            if ($this->updateDailyAccumulation($vacation)) {
                                $results['periods_updated']++;

                                $vacation->refresh();
                                $newValue = $vacation->days_calculated;

                                if (abs($newValue - ($oldValue ?? 0)) > 0.01) {
                                    $user = $vacation->user;
                                    $planta = 'N/D';
                                    
                                    if ($user && $user->job && $user->job->departamento) {
                                        $planta = $user->job->departamento->name ?? 'N/D';
                                    }

                                    $results['details'][] = [
                                        'planta' => $planta,
                                        'usuario' => $user ? trim($user->first_name . ' ' . $user->last_name) : 'Usuario ID ' . $vacation->users_id,
                                        'periodo' => $vacation->period,
                                        'dias_anteriores' => $oldValue ?? 0,
                                        'dias_actualizados' => $newValue,
                                        'incremento' => $newValue - ($oldValue ?? 0)
                                    ];
                                }
                            } else {
                                $results['periods_skipped']++;
                            }
                        } catch (\Exception $e) {
                            $results['errors'][] = [
                                'vacation_id' => $vacation->id,
                                'user_id' => $vacation->users_id,
                                'message' => $e->getMessage()
                            ];
                        }
                    }
                });


            $results['users_processed'] = VacationsAvailable::where('is_historical', false)
                ->distinct('users_id')
                ->count('users_id');

        } catch (\Exception $e) {
            Log::error('Error en actualización masiva de acumulación diaria: ' . $e->getMessage());
            $results['errors'][] = [
                'general' => $e->getMessage()
            ];
        }

        return $results;
    }

    /**
     * Verificar y marcar periodo como vencido si corresponde.
     * @return bool True si el periodo fue marcado como vencido, false en otro caso.
     */
    protected function checkAndMarkExpired(VacationsAvailable $vacation, Carbon $today): bool
    {
        if ($vacation->is_historical || $vacation->status === 'vencido') {
            return false;
        }

        $expirationDate = $vacation->date_end->copy()->addMonths(self::EXPIRATION_MONTHS);

        if ($today->gt($expirationDate)) {
            $vacation->status = 'vencido';
            $vacation->save();

            Log::info("Periodo marcado como vencido", [
                'vacation_id' => $vacation->id,
                'user_id' => $vacation->users_id,
                'period' => $vacation->period,
                'date_end' => $vacation->date_end->format('Y-m-d'),
                'expiration_date' => $expirationDate->format('Y-m-d'),
                'days_remaining' => $vacation->days_availables - $vacation->days_enjoyed - ($vacation->days_reserved ?? 0)
            ]);

            return true;
        }

        return false;
    }

    /**
     * Calcular acumulación diaria proporcional.
     * La acumulación nunca supera el total anual definido.
     */
    protected function calculateDailyAccumulation(Carbon $startDate, Carbon $endDate, float $annualDays): float
    {
        $isLeapYear = $startDate->isLeapYear();
        $totalDaysInYear = $isLeapYear ? 366 : 365;
        $daysWorked = $startDate->diffInDays($endDate) + 1;
        $accumulatedDays = ($annualDays * $daysWorked) / $totalDaysInYear;

        return round(min($accumulatedDays, $annualDays), 2);
    }

    /**
     * Obtener días anuales esperados para un período.
     * Determina el esquema de vacaciones aplicable según la fecha de inicio del período.
     */
    protected function getExpectedDaysForPeriod(VacationsAvailable $vacation): int
    {
        $policyChangeDate = Carbon::parse('2023-01-01');
        
        if ($vacation->date_start->lt($policyChangeDate)) {
            $scheme = [
                1 => 6, 2 => 8, 3 => 10, 4 => 12,
            ];
        } else {
            $scheme = [
                1 => 12, 2 => 14, 3 => 16, 4 => 18, 5 => 20,
            ];
        }

        $user = $vacation->user;
        if (!$user || !$user->admission) {
            return 12;
        }

        $admissionDate = Carbon::parse($user->admission);
        $yearsSeniority = $vacation->date_start->diffInYears($admissionDate) + 1;

        return $this->getDaysForSeniority($yearsSeniority, $scheme);
    }

    /**
     * Obtener días según antigüedad.
     */
    protected function getDaysForSeniority(int $years, array $scheme): int
    {
        if ($years <= 4) {
            return $scheme[$years] ?? 12;
        }

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

        return 32; // Máximo
    }

    /**
     * Verificar y marcar periodos vencidos para todos los usuarios
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
            VacationsAvailable::where('is_historical', false)
                ->where('status', '!=', 'vencido')
                ->chunk(100, function ($vacations) use (&$results, $today) {
                    foreach ($vacations as $vacation) {
                        try {
                            $results['checked']++;
                            
                            if ($this->checkAndMarkExpired($vacation, $today)) {
                                $results['expired']++;
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
            Log::error('Error verificando periodos vencidos: ' . $e->getMessage());
            $results['errors'][] = [
                'general' => $e->getMessage()
            ];
        }

        return $results;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\VacationsAvailable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateVacationAccrual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacations:update-accrual 
                            {--user= : ID del usuario específico a actualizar}
                            {--all : Actualizar todos los usuarios}
                            {--force : Forzar actualización incluso si ya se ejecutó hoy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza la acumulación diaria proporcional de días de vacaciones para empleados activos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando actualización de acumulación de vacaciones...');
        $this->newLine();

        $userId = $this->option('user');
        $all = $this->option('all');
        $force = $this->option('force');

        if (!$userId && !$all) {
            $this->error('Debes especificar --user=ID o --all para actualizar todos los usuarios');
            return 1;
        }

        $today = Carbon::today();
        
        if ($userId) {
            // Actualizar usuario específico
            $user = User::with('job')->find($userId);
            
            if (!$user) {
                $this->error("Usuario con ID {$userId} no encontrado.");
                return 1;
            }

            $this->info("Actualizando vacaciones para: {$user->first_name} {$user->last_name}");
            $result = $this->updateUserVacationAccrual($user, $today, $force);
            
            if ($result['success']) {
                $this->info("✓ {$result['message']}");
                
                if (!empty($result['updated_periods'])) {
                    $this->table(
                        ['Período', 'Días Anteriores', 'Días Nuevos', 'Incremento'],
                        $result['updated_periods']
                    );
                }
            } else {
                $this->warn("⚠ {$result['message']}");
            }
        } else {
            // Actualizar todos los usuarios
            $this->info('Actualizando vacaciones para todos los usuarios activos...');
            $this->newLine();
            
            $users = User::whereHas('job')
                ->where('active', 1)
                ->get();

            $bar = $this->output->createProgressBar($users->count());
            $bar->start();

            $successCount = 0;
            $skippedCount = 0;
            $errorCount = 0;
            $totalIncrement = 0;

            foreach ($users as $user) {
                try {
                    $result = $this->updateUserVacationAccrual($user, $today, $force);
                    
                    if ($result['success']) {
                        $successCount++;
                        if (!empty($result['updated_periods'])) {
                            foreach ($result['updated_periods'] as $period) {
                                $totalIncrement += $period[3]; // Incremento
                            }
                        }
                    } else {
                        $skippedCount++;
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error("Error updating vacation accrual for user {$user->id}: {$e->getMessage()}");
                }
                
                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            // Mostrar resumen
            $this->info('Resumen de actualización:');
            $this->table(
                ['Estado', 'Cantidad'],
                [
                    ['Actualizados', $successCount],
                    ['Omitidos', $skippedCount],
                    ['Errores', $errorCount],
                    ['Total procesados', $users->count()],
                ]
            );

            $this->info("Total de días incrementados: " . number_format($totalIncrement, 2));
        }

        $this->newLine();
        $this->info('Actualización de acumulación completada exitosamente!');
        
        return 0;
    }

    /**
     * Actualizar acumulación de vacaciones para un usuario
     */
    private function updateUserVacationAccrual(User $user, Carbon $today, bool $force = false): array
    {
        // Validar fecha de admisión
        if (empty($user->admission) || $user->admission < '1900-01-01') {
            return [
                'success' => false,
                'message' => 'Fecha de admisión inválida'
            ];
        }

        try {
            $admissionDate = Carbon::parse($user->admission);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al procesar fecha de admisión'
            ];
        }

        // Verificar que tenga al menos 1 año de antigüedad
        if ($admissionDate->diffInYears($today) < 1) {
            return [
                'success' => false,
                'message' => 'Sin antigüedad mínima (< 1 año)'
            ];
        }

        // Obtener períodos actuales (no históricos) del usuario
        $currentPeriods = VacationsAvailable::where('users_id', $user->id)
            ->where('is_historical', false)
            ->get();

        if ($currentPeriods->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Sin períodos de vacaciones registrados'
            ];
        }

        $updatedPeriods = [];

        DB::beginTransaction();
        try {
            foreach ($currentPeriods as $period) {
                // Verificar si ya se actualizó hoy (evitar múltiples actualizaciones)
                $lastUpdate = Carbon::parse($period->updated_at);
                if (!$force && $lastUpdate->isToday()) {
                    continue;
                }

                // Leer días calculados anteriormente (days_calculated)
                $oldDays = $period->days_calculated ?? 0;
                
                // Calcular días acumulados hasta hoy
                $startDate = Carbon::parse($period->date_start);
                $endDate = Carbon::parse($period->date_end);
                
                // Solo actualizar si el período está activo (hoy está dentro del rango)
                if (!$today->between($startDate, $endDate)) {
                    continue;
                }
                
                $daysWorked = $startDate->diffInDays($today) + 1; // +1 para incluir el día actual
                
                // Determinar si el año es bisiesto
                $year = $startDate->year;
                $daysInYear = Carbon::create($year)->isLeapYear() ? 366 : 365;
                
                // Obtener días anuales correspondientes al período
                $annualDays = $this->getAnnualDaysForPeriod($period->period);
                
                // Calcular días proporcionales acumulados
                $accruedDays = ($annualDays / $daysInYear) * $daysWorked;
                
                // Asegurar que no exceda el máximo anual
                $accruedDays = min($accruedDays, $annualDays);
                
                // Actualizar days_calculated (cálculo automático)
                // days_availables se preserva para importación desde Excel
                if (abs($accruedDays - $oldDays) > 0.01) {
                    $period->days_calculated = round($accruedDays, 2);
                    $period->save();
                    
                    $updatedPeriods[] = [
                        $period->period,
                        number_format($oldDays, 2),
                        number_format($period->days_calculated, 2),
                        number_format($period->days_calculated - $oldDays, 2)
                    ];
                }
            }

            DB::commit();

            if (empty($updatedPeriods)) {
                return [
                    'success' => false,
                    'message' => 'Ya actualizado hoy (sin cambios)'
                ];
            }

            return [
                'success' => true,
                'message' => count($updatedPeriods) . ' período(s) actualizado(s)',
                'updated_periods' => $updatedPeriods
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating vacation accrual for user {$user->id}: {$e->getMessage()}");
            
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener días anuales según período de antigüedad (esquema actual)
     */
    private function getAnnualDaysForPeriod(int $period): int
    {
        $days = [
            1 => 12,
            2 => 14,
            3 => 16,
            4 => 18,
            5 => 20,
        ];

        if ($period <= 5) {
            return $days[$period] ?? 12;
        }

        $ranges = [
            [6, 10, 22],
            [11, 15, 24],
            [16, 20, 26],
            [21, 25, 28],
            [26, 30, 30],
            [31, 35, 32],
        ];

        foreach ($ranges as [$min, $max, $annualDays]) {
            if ($period >= $min && $period <= $max) {
                return $annualDays;
            }
        }

        return 32;
    }
}


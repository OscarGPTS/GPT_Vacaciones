<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\VacationsAvailable;
use App\Services\VacationPeriodCreatorService;
use App\Services\VacationDailyAccumulatorService;
use Carbon\Carbon;

class TestVacationCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:test {user_id? : ID del usuario a probar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba y valida el cálculo de vacaciones según regulaciones mexicanas';

    protected $periodCreator;
    protected $dailyAccumulator;

    public function __construct(
        VacationPeriodCreatorService $periodCreator,
        VacationDailyAccumulatorService $dailyAccumulator
    ) {
        parent::__construct();
        $this->periodCreator = $periodCreator;
        $this->dailyAccumulator = $dailyAccumulator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Iniciando pruebas de cálculo de vacaciones...');
        $this->newLine();

        $userId = $this->argument('user_id');

        if ($userId) {
            // Probar un usuario específico
            $user = User::find($userId);
            if (!$user) {
                $this->error("Usuario con ID {$userId} no encontrado.");
                return 1;
            }
            $this->testSingleUser($user);
        } else {
            // Probar escenarios de validación
            $this->testVacationScheme();
            $this->newLine();
            
            // Preguntar si quiere probar con un usuario real
            if ($this->confirm('¿Deseas probar con un usuario real de la base de datos?', true)) {
                $this->testWithRealUser();
            }
        }

        return 0;
    }

    /**
     * Probar el esquema de días según antigüedad (regulaciones mexicanas)
     */
    protected function testVacationScheme()
    {
        $this->info('📋 Validando esquema de días según Ley Federal del Trabajo (México):');
        $this->newLine();

        $expectedDays = [
            1 => 12,
            2 => 14,
            3 => 16,
            4 => 18,
            5 => 20,
            6 => 22,
            7 => 22,
            10 => 22,
            11 => 24,
            15 => 24,
            16 => 26,
            20 => 26,
            21 => 28,
            25 => 28,
            26 => 30,
            30 => 30,
            31 => 32,
            35 => 32,
            40 => 32,
        ];

        $headers = ['Años', 'Días Esperados', 'Días Calculados', 'Estado'];
        $rows = [];

        foreach ($expectedDays as $years => $expected) {
            $calculated = $this->periodCreator->calculateDaysForYears($years);
            $status = $calculated === $expected ? '✅' : '❌';
            
            $rows[] = [
                $years . ($years === 1 ? ' año' : ' años'),
                $expected,
                $calculated,
                $status
            ];
        }

        $this->table($headers, $rows);
    }

    /**
     * Probar con un usuario real
     */
    protected function testWithRealUser()
    {
        // Obtener usuarios con fecha de ingreso
        $users = User::whereNotNull('admission')
            ->whereHas('job')
            ->orderBy('admission', 'asc')
            ->take(10)
            ->get();

        if ($users->isEmpty()) {
            $this->warn('No se encontraron usuarios con fecha de ingreso.');
            return;
        }

        $this->info('Usuarios disponibles:');
        $userOptions = [];
        foreach ($users as $user) {
            $admission = Carbon::parse($user->admission);
            $years = $admission->diffInYears(now());
            $userOptions[] = [
                'id' => $user->id,
                'name' => "{$user->first_name} {$user->last_name}",
                'admission' => $admission->format('d/m/Y'),
                'years' => $years,
            ];
            $this->line("  [{$user->id}] {$user->first_name} {$user->last_name} - Ingreso: {$admission->format('d/m/Y')} ({$years} años)");
        }

        $userId = $this->ask('Ingresa el ID del usuario a probar');
        $user = User::find($userId);

        if (!$user) {
            $this->error('Usuario no encontrado.');
            return;
        }

        $this->testSingleUser($user);
    }

    /**
     * Probar un usuario específico
     */
    protected function testSingleUser(User $user)
    {
        $this->newLine();
        $this->info("👤 Probando usuario: {$user->first_name} {$user->last_name} (ID: {$user->id})");
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        if (!$user->admission) {
            $this->error('❌ El usuario no tiene fecha de ingreso registrada.');
            return;
        }

        $admission = Carbon::parse($user->admission);
        $today = Carbon::today();
        $yearsWorked = $admission->diffInYears($today);
        $monthsWorked = $admission->diffInMonths($today) % 12;

        $this->info("📅 Fecha de ingreso: {$admission->format('d/m/Y')}");
        $this->info("⏱️  Antigüedad: {$yearsWorked} años y {$monthsWorked} meses");
        $this->newLine();

        // Mostrar períodos existentes ANTES del cálculo
        $this->info('📦 Períodos ANTES del cálculo:');
        $periodsBefore = VacationsAvailable::where('users_id', $user->id)
            ->orderBy('date_start', 'asc')
            ->get();

        if ($periodsBefore->isEmpty()) {
            $this->warn('  No hay períodos registrados.');
        } else {
            $headersBefore = ['Período', 'Inicio', 'Fin', 'Disponibles', 'Disfrutados', 'Reservados', 'Histórico'];
            $rowsBefore = [];
            foreach ($periodsBefore as $p) {
                $rowsBefore[] = [
                    $p->period,
                    $p->date_start->format('d/m/Y'),
                    $p->date_end->format('d/m/Y'),
                    $p->days_availables,
                    $p->days_enjoyed,
                    $p->days_reserved ?? 0,
                    $p->is_historical ? 'Sí' : 'No',
                ];
            }
            $this->table($headersBefore, $rowsBefore);
        }

        $this->newLine();
        
        // Ejecutar el cálculo
        if ($this->confirm('¿Ejecutar creación de períodos faltantes para este usuario?', true)) {
            $this->info('🔄 Creando períodos faltantes...');
            $result = $this->periodCreator->createMissingPeriodsForUser($user);

            if (!$result['success']) {
                $this->error('❌ Error: ' . $result['message']);
                return;
            }

            $totalCreated = count($result['data']['historical'] ?? []) + count($result['data']['current'] ?? []);
            $this->info("✅ Proceso completado. Períodos creados: {$totalCreated}");
            
            // Actualizar acumulación diaria
            if ($totalCreated === 0) {
                $this->info('🔄 Actualizando acumulación diaria...');
                $updateResult = $this->dailyAccumulator->updateDailyAccumulationForUser($user->id);
                $this->info("  • Períodos actualizados: {$updateResult['updated']}");
                $this->info("  • Períodos omitidos: {$updateResult['skipped']}");
                $this->info("  • Períodos vencidos: {$updateResult['expired']}");
            }
            
            $this->newLine();

            // Mostrar períodos DESPUÉS del cálculo
            $this->info('📦 Períodos DESPUÉS del cálculo:');
            $periodsAfter = VacationsAvailable::where('users_id', $user->id)
                ->orderBy('date_start', 'asc')
                ->get();

            $headersAfter = ['Período', 'Inicio', 'Fin', 'Disponibles', 'Disfrutados', 'Reservados', 'Estado'];
            $rowsAfter = [];
            $totalAvailable = 0;
            $totalEnjoyed = 0;
            $totalReserved = 0;

            foreach ($periodsAfter as $p) {
                // $available = $p->days_availables + ($p->dv ?? 0); // ❌ ELIMINADO - dv deprecado
                $available = $p->days_availables; // Campo dv eliminado
                $enjoyed = $p->days_enjoyed;
                $reserved = $p->days_reserved ?? 0;
                $remaining = $available - $enjoyed - $reserved;

                if (!$p->is_historical && $p->status !== 'vencido') {
                    $totalAvailable += $available;
                    $totalEnjoyed += $enjoyed;
                    $totalReserved += $reserved;
                }

                $status = $p->is_historical ? 'Histórico' : ($p->status ?? 'Actual');
                
                $rowsAfter[] = [
                    $p->period,
                    $p->date_start->format('d/m/Y'),
                    $p->date_end->format('d/m/Y'),
                    number_format($available, 2),
                    $enjoyed,
                    $reserved,
                    $status,
                ];
            }
            $this->table($headersAfter, $rowsAfter);

            // Resumen
            $this->newLine();
            $this->info('📊 RESUMEN (períodos activos):');
            $totalRemaining = $totalAvailable - $totalEnjoyed - $totalReserved;
            $this->line("  • Total disponible: " . number_format($totalAvailable, 2) . " días");
            $this->line("  • Total disfrutado: {$totalEnjoyed} días");
            $this->line("  • Total reservado: {$totalReserved} días");
            $this->line("  • <fg=green>Días libres para usar: " . number_format($totalRemaining, 2) . " días</>");

            // Validar preservación de days_reserved
            $this->newLine();
            $this->info('🔍 Validación de preservación de datos:');
            $preserved = true;
            foreach ($periodsBefore as $before) {
                $after = $periodsAfter->firstWhere('id', $before->id);
                if ($after) {
                    $reservedBefore = $before->days_reserved ?? 0;
                    $reservedAfter = $after->days_reserved ?? 0;
                    
                    if ($reservedBefore != $reservedAfter) {
                        $this->error("  ❌ Período {$before->period}: days_reserved cambió de {$reservedBefore} a {$reservedAfter}");
                        $preserved = false;
                    }
                }
            }
            
            if ($preserved) {
                $this->info('  ✅ Todos los days_reserved se preservaron correctamente');
            }
        }
    }
}


<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemLog;
use App\Services\VacationDailyAccumulatorService;

class UpdateDailyAccumulation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:update-daily 
                            {user_id? : ID del usuario específico}
                            {--all : Actualizar para todos los usuarios}
                            {--check-expired : Solo verificar y marcar períodos vencidos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar acumulación diaria de días de vacaciones (preserva days_reserved y days_enjoyed)';

    protected $accumulator;

    public function __construct(VacationDailyAccumulatorService $accumulator)
    {
        parent::__construct();
        $this->accumulator = $accumulator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $all = $this->option('all');
        $checkExpired = $this->option('check-expired');

        // --check-expired alone: solo verificar períodos vencidos
        if ($checkExpired && !$all) {
            return $this->checkExpiredPeriods();
        }

        if ($all) {
            $exitCode = $this->updateForAllUsers();
            // Si también se pidió verificar vencidos, ejecutarlo después de la acumulación
            if ($checkExpired) {
                $this->checkExpiredPeriods();
            }
            return $exitCode;
        }

        if ($userId) {
            return $this->updateForUser($userId);
        }

        $this->error('Debes especificar un user_id, usar --all, o --check-expired');
        return 1;
    }

    protected function updateForUser(int $userId)
    {
        $this->info("Actualizando acumulación diaria para usuario ID: {$userId}");
        
        $results = $this->accumulator->updateDailyAccumulationForUser($userId);

        $this->info('✅ Actualización completada:');
        $this->line("  • Períodos actualizados: {$results['updated']}");
        $this->line("  • Períodos omitidos: {$results['skipped']}");
        $this->line("  • Períodos vencidos: {$results['expired']}");

        return 0;
    }

    protected function updateForAllUsers()
    {
        $startTime = now();
        $this->info('Actualizando acumulación diaria para todos los usuarios...');
        $this->warn('Este proceso puede tardar varios minutos.');
        $this->newLine();

        $results = $this->accumulator->updateDailyAccumulationForAllUsers();

        $this->newLine();
        $this->info('📊 Resultados:');
        $this->line("  • Usuarios procesados: {$results['users_processed']}");
        $this->line("  • Períodos actualizados: {$results['periods_updated']}");
        $this->line("  • Períodos omitidos: {$results['periods_skipped']}");
        $this->line("  • Períodos vencidos: {$results['periods_expired']}");

        if (!empty($results['errors'])) {
            $this->newLine();
            $this->warn('⚠️  Errores encontrados: ' . count($results['errors']));
            foreach (array_slice($results['errors'], 0, 5) as $error) {
                $this->line("  • Usuario {$error['user_id']}: {$error['message']}");
            }
            if (count($results['errors']) > 5) {
                $this->line("  ... y " . (count($results['errors']) - 5) . " más");
            }
        }

        // ── Registrar resultado en system_logs ───────────────────────────
        $duration  = $startTime->diffInSeconds(now());
        $hasErrors = !empty($results['errors']);

        SystemLog::create([
            'user_id'    => null,
            'created_by' => null,
            'level'      => $hasErrors ? 'warning' : 'info',
            'type'       => 'cron_daily_accrual',
            'message'    => $hasErrors
                ? "vacation:update-daily completado con errores ({$results['users_processed']} usuarios, {$results['periods_updated']} períodos actualizados en {$duration}s)"
                : "vacation:update-daily completado exitosamente ({$results['users_processed']} usuarios, {$results['periods_updated']} períodos actualizados en {$duration}s)",
            'context'    => [
                'command'          => 'vacation:update-daily --all --check-expired',
                'duration_secs'    => $duration,
                'users_processed'  => $results['users_processed'] ?? 0,
                'periods_updated'  => $results['periods_updated']  ?? 0,
                'periods_skipped'  => $results['periods_skipped']  ?? 0,
                'periods_expired'  => $results['periods_expired']  ?? 0,
                'errors'           => array_slice($results['errors'] ?? [], 0, 20),
                'executed_at'      => $startTime->toDateTimeString(),
            ],
            'status' => $hasErrors ? 'pending' : 'resolved',
        ]);

        return 0;
    }

    protected function checkExpiredPeriods()
    {
        $this->info('Verificando y marcando períodos vencidos...');
        
        $results = $this->accumulator->checkExpiredPeriodsForAllUsers();

        $this->info('✅ Verificación completada:');
        $this->line("  • Períodos verificados: {$results['checked']}");
        $this->line("  • Períodos marcados como vencidos: {$results['expired']}");

        if (!empty($results['errors'])) {
            $this->warn('⚠️  Errores: ' . count($results['errors']));
        }

        return 0;
    }
}

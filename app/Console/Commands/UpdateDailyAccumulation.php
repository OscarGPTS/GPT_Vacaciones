<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

        if ($checkExpired) {
            return $this->checkExpiredPeriods();
        }

        if ($all) {
            return $this->updateForAllUsers();
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

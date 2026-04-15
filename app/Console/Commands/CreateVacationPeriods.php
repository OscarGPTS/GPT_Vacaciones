<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SystemLog;
use App\Services\VacationPeriodCreatorService;

class CreateVacationPeriods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:create-periods 
                            {user_id? : ID del usuario específico}
                            {--all : Crear períodos para todos los usuarios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear períodos de vacaciones faltantes (no modifica períodos existentes)';

    protected $periodCreator;

    public function __construct(VacationPeriodCreatorService $periodCreator)
    {
        parent::__construct();
        $this->periodCreator = $periodCreator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $all = $this->option('all');

        if ($all) {
            return $this->createForAllUsers();
        }

        if ($userId) {
            return $this->createForUser($userId);
        }

        $this->error('Debes especificar un user_id o usar --all');
        return 1;
    }

    protected function createForUser(int $userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("Usuario con ID {$userId} no encontrado.");
            return 1;
        }

        $this->info("Creando períodos faltantes para: {$user->first_name} {$user->last_name}");
        
        $result = $this->periodCreator->createMissingPeriodsForUser($user);

        if ($result['success']) {
            $totalCreated = count($result['data']['historical'] ?? []) + count($result['data']['current'] ?? []);
            $this->info("✅ {$result['message']}");
            
            if ($totalCreated > 0) {
                $this->line("  • Períodos históricos: " . count($result['data']['historical'] ?? []));
                $this->line("  • Períodos actuales: " . count($result['data']['current'] ?? []));
            } else {
                $this->warn("  No se crearon períodos nuevos (todos ya existen)");
            }
        } else {
            $this->error("❌ Error: {$result['message']}");
            return 1;
        }

        return 0;
    }

    protected function createForAllUsers()
    {
        $startTime = now();
        $this->info('Creando períodos faltantes para todos los usuarios...');
        $this->newLine();

        $bar = $this->output->createProgressBar(User::whereHas('job')->count());
        $bar->start();

        $results = $this->periodCreator->createMissingPeriodsForAllUsers();

        $bar->finish();
        $this->newLine(2);

        $this->info('📊 Resultados:');
        $this->line("  • Usuarios procesados correctamente: {$results['success']}");
        $this->line("  • Usuarios con errores: {$results['failed']}");
        $this->line("  • Total de períodos creados: {$results['total_created']}");

        if (!empty($results['errors'])) {
            $this->newLine();
            $this->warn('⚠️  Errores encontrados:');
            foreach ($results['errors'] as $error) {
                $this->line("  • Usuario {$error['user_id']}: {$error['message']}");
            }
        }

        // ── Registrar resultado en system_logs ───────────────────────────
        $duration = $startTime->diffInSeconds(now());
        $hasErrors = !empty($results['errors']);

        SystemLog::create([
            'user_id'    => null,
            'created_by' => null,
            'level'      => $hasErrors ? 'warning' : 'info',
            'type'       => 'cron_create_periods',
            'message'    => $hasErrors
                ? "vacation:create-periods completado con errores ({$results['failed']} usuarios fallidos, {$results['total_created']} períodos creados en {$duration}s)"
                : "vacation:create-periods completado exitosamente ({$results['success']} usuarios, {$results['total_created']} períodos creados en {$duration}s)",
            'context'    => [
                'command'        => 'vacation:create-periods --all',
                'duration_secs'  => $duration,
                'users_ok'       => $results['success']      ?? 0,
                'users_failed'   => $results['failed']       ?? 0,
                'periods_created'=> $results['total_created'] ?? 0,
                'errors'         => array_slice($results['errors'] ?? [], 0, 20),
                'executed_at'    => $startTime->toDateTimeString(),
            ],
            'status' => $hasErrors ? 'pending' : 'resolved',
        ]);

        return 0;
    }
}

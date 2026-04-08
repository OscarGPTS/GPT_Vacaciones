<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoApprovalService;

class ProcessAutoApprovals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacations:auto-approve 
                           {--stats : Solo mostrar estadísticas sin procesar}
                           {--dry-run : Ejecutar sin hacer cambios reales}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesar aprobaciones automáticas de solicitudes de vacaciones por timeout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $autoApprovalService = new AutoApprovalService();

        // Si solo queremos estadísticas
        if ($this->option('stats')) {
            $this->displayStats($autoApprovalService);
            return 0;
        }

        // Si es dry-run, solo mostrar qué se haría
        if ($this->option('dry-run')) {
            $this->dryRun($autoApprovalService);
            return 0;
        }

        // Procesar aprobaciones automáticas
        $this->info('🔄 Iniciando proceso de aprobaciones automáticas...');
        
        $results = $autoApprovalService->processAutoApprovals();

        // Mostrar resultados
        $this->newLine();
        $this->info('✅ Proceso completado:');
        $this->line("   📋 Supervisor - Solicitudes aprobadas: {$results['direct_manager_approvals']}");
        $this->line("   🏢 Dirección - Solicitudes aprobadas: {$results['direction_approvals']}");
        $this->line("   👔 RH - Solicitudes aprobadas: {$results['hr_approvals']} (deshabilitado)");

        if (!empty($results['errors'])) {
            $this->newLine();
            $this->error('❌ Errores encontrados:');
            foreach ($results['errors'] as $error) {
                $this->line("   • {$error}");
            }
        }

        $this->newLine();
        $this->info('📊 Estadísticas actuales:');
        $this->displayStats($autoApprovalService);

        return 0;
    }

    /**
     * Mostrar estadísticas de solicitudes pendientes
     */
    private function displayStats(AutoApprovalService $service)
    {
        $stats = $service->getPendingRequestsStats();

        $this->table(
            ['Categoría', 'Total Pendientes', 'Vencidas (>5 días)'],
            [
                ['Supervisor Directo', $stats['pending_supervisor_total'], $stats['pending_supervisor_expired']],
                ['Dirección', $stats['pending_direction_total'], $stats['pending_direction_expired']],
                ['Recursos Humanos', $stats['pending_hr_total'], $stats['pending_hr_expired']],
            ]
        );
    }

    /**
     * Ejecutar en modo dry-run (sin cambios reales)
     */
    private function dryRun(AutoApprovalService $service)
    {
        $this->info('🧪 Modo DRY-RUN - No se realizarán cambios reales');
        $this->newLine();

        $stats = $service->getPendingRequestsStats();

        $this->info('📋 Solicitudes que serían aprobadas automáticamente:');
        $this->line("   • Supervisor: {$stats['pending_supervisor_expired']} solicitudes");
        $this->line("   • Dirección: {$stats['pending_direction_expired']} solicitudes");
        $this->line("   • RH: {$stats['pending_hr_expired']} solicitudes (función deshabilitada)");

        $this->newLine();
        $this->displayStats($service);
    }
}
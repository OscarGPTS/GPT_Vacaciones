<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecreateVacationViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:recreate-views
                            {--force : Force recreation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recrear vistas cross-database entre rh y rh_vacations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('¿Deseas recrear las vistas cross-database?')) {
                $this->info('Operación cancelada.');
                return 0;
            }
        }

        $this->info('Recreando vistas cross-database...');
        $this->newLine();

        try {
            // PARTE 1: Vistas en BD principal (rh)
            $this->line('📁 Creando vistas en BD principal (rh)...');
            
            $viewsInRh = [
                'requests',
                'vacations_availables',
                'request_approved',
                'request_rejected',
                'vacation_per_years',
                'no_working_days',
                'direction_approvers',
                'manager_approvers',
                'system_logs'
            ];

            foreach ($viewsInRh as $table) {
                DB::connection('mysql')->statement("DROP VIEW IF EXISTS {$table}");
                DB::connection('mysql')->statement(
                    "CREATE VIEW {$table} AS SELECT * FROM rh_vacations.{$table}"
                );
                $this->line("  ✓ rh.{$table} → rh_vacations.{$table}");
            }

            $this->newLine();

            // PARTE 2: Vistas en BD vacaciones (rh_vacations)
            $this->line('📁 Creando vistas en BD vacaciones (rh_vacations)...');
            
            $viewsInVacations = [
                'users',
                'jobs',
                'departamentos'
            ];

            foreach ($viewsInVacations as $table) {
                DB::connection('mysql_vacations')->statement("DROP VIEW IF EXISTS {$table}");
                DB::connection('mysql_vacations')->statement(
                    "CREATE VIEW {$table} AS SELECT * FROM rh.{$table}"
                );
                $this->line("  ✓ rh_vacations.{$table} → rh.{$table}");
            }

            $this->newLine();

            // Verificación
            $this->line('🔍 Verificando vistas creadas...');
            
            $countRh = DB::connection('mysql')
                ->table('information_schema.TABLES')
                ->where('TABLE_SCHEMA', 'rh')
                ->whereIn('TABLE_NAME', $viewsInRh)
                ->where('TABLE_TYPE', 'VIEW')
                ->count();

            $countVacations = DB::connection('mysql_vacations')
                ->table('information_schema.TABLES')
                ->where('TABLE_SCHEMA', 'rh_vacations')
                ->whereIn('TABLE_NAME', $viewsInVacations)
                ->where('TABLE_TYPE', 'VIEW')
                ->count();

            $this->line("  ✓ Vistas en rh: {$countRh}/" . count($viewsInRh));
            $this->line("  ✓ Vistas en rh_vacations: {$countVacations}/" . count($viewsInVacations));

            $this->newLine();

            if ($countRh === count($viewsInRh) && $countVacations === count($viewsInVacations)) {
                $this->info('✅ Todas las vistas cross-database se crearon correctamente');
                return 0;
            } else {
                $this->error('❌ Algunas vistas no se crearon correctamente');
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Error al crear vistas: ' . $e->getMessage());
            return 1;
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VacationCalculatorService;

class CheckExpiredVacations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacations:check-expired 
                           {--stats : Solo mostrar estadísticas sin procesar}
                           {--dry-run : Ejecutar sin hacer cambios reales}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar y marcar periodos de vacaciones vencidos (15 meses después del fin del periodo)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vacationService = new VacationCalculatorService();

        $this->info('🔍 Iniciando verificación de periodos vencidos...');
        $this->newLine();

        if ($this->option('dry-run')) {
            $this->warn('🧪 Modo DRY-RUN - No se realizarán cambios reales');
            $this->newLine();
        }

        if ($this->option('stats') || $this->option('dry-run')) {
            $this->displayStats();
            return 0;
        }

        // Ejecutar verificación real
        $results = $vacationService->checkExpiredPeriodsForAllUsers();

        // Mostrar resultados
        $this->newLine();
        $this->info('✅ Verificación completada:');
        $this->line("   📋 Periodos verificados: {$results['checked']}");
        $this->line("   ⏰ Periodos marcados como vencidos: {$results['expired']}");

        if (!empty($results['errors'])) {
            $this->newLine();
            $this->error('❌ Errores encontrados:');
            foreach ($results['errors'] as $error) {
                $vacationId = $error['vacation_id'] ?? 'N/A';
                $message = $error['message'] ?? $error['general'] ?? 'Error desconocido';
                $this->line("   • Vacation ID {$vacationId}: {$message}");
            }
        }

        $this->newLine();
        $this->info('📊 Estado actual de periodos:');
        $this->displayStats();

        return 0;
    }

    /**
     * Mostrar estadísticas de periodos
     */
    private function displayStats()
    {
        $totalActive = \App\Models\VacationsAvailable::where('is_historical', false)
            ->where('status', 'actual')
            ->count();

        $totalExpired = \App\Models\VacationsAvailable::where('is_historical', false)
            ->where('status', 'vencido')
            ->count();

        $totalHistorical = \App\Models\VacationsAvailable::where('is_historical', true)
            ->count();

        // Periodos próximos a vencer (menos de 30 días)
        $today = \Carbon\Carbon::today();
        $nearExpiration = \App\Models\VacationsAvailable::where('is_historical', false)
            ->where('status', 'actual')
            ->get()
            ->filter(function($vacation) use ($today) {
                $expirationDate = $vacation->date_end->copy()->addMonths(15);
                $daysUntilExpiration = $today->diffInDays($expirationDate, false);
                return $daysUntilExpiration >= 0 && $daysUntilExpiration <= 30;
            })
            ->count();

        $this->table(
            ['Estado', 'Cantidad'],
            [
                ['✅ Periodos Activos', $totalActive],
                ['⏰ Periodos Vencidos', $totalExpired],
                ['📜 Periodos Históricos', $totalHistorical],
                ['⚠️ Próximos a vencer (30 días)', $nearExpiration],
            ]
        );

        if ($nearExpiration > 0) {
            $this->newLine();
            $this->warn("⚠️ Hay {$nearExpiration} periodo(s) que vencerán en los próximos 30 días");
        }
    }
}

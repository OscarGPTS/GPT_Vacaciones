<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       Commands\SendAnniversaryMail::class,
       Commands\ProcessAutoApprovals::class,
       Commands\CheckExpiredVacations::class,
       Commands\CreateVacationPeriods::class,
       Commands\UpdateDailyAccumulation::class,
       Commands\TestVacationCalculation::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('email:send_anniversary')
        ->everyMinute();

        $schedule->call(function (){
            logger('cron job executed'); 
        })->everyMinute();

        // ========== NUEVOS COMANDOS REFACTORIZADOS ==========
        
        // 1. Crear períodos faltantes (diariamente a las 00:00 AM)
        //    - Verifica si existen períodos para cada usuario
        //    - Si end_date se cumplió, crea el siguiente período
        //    - Preserva days_reserved y days_enjoyed
        $schedule->command('vacation:create-periods --all')
                 ->dailyAt('00:00')
                 ->timezone('America/Mexico_City')
                 ->withoutOverlapping()
                 ->runInBackground();

        // 2. Actualizar acumulación diaria de días (diariamente a las 00:05 AM)
        //    - Actualiza days_availables con acumulación proporcional
        //    - Marca períodos vencidos (15 meses)
        //    - Solo modifica days_availables, preserva days_reserved y days_enjoyed
        $schedule->command('vacation:update-daily --all --check-expired')
                 ->dailyAt('00:05')
                 ->timezone('America/Mexico_City')
                 ->withoutOverlapping()
                 ->runInBackground();

        // ========== COMANDOS ANTIGUOS (DEPRECATED) ==========
        
        // NOTA: Los siguientes comandos están obsoletos y serán removidos
        // Se mantienen temporalmente por compatibilidad
        
        // Actualizar acumulación diaria de vacaciones (OBSOLETO - usar vacation:update-daily)
        // $schedule->command('vacations:update-accrual --all')
        //          ->dailyAt('00:01')
        //          ->timezone('America/Mexico_City')
        //          ->withoutOverlapping()
        //          ->runInBackground();

        // Verificar y marcar periodos vencidos (OBSOLETO - incluido en vacation:update-daily)
        // $schedule->command('vacations:check-expired')
        //          ->dailyAt('00:30')
        //          ->timezone('America/Mexico_City')
        //          ->withoutOverlapping()
        //          ->runInBackground();

        // ========== COMANDOS ACTIVOS ==========

        // Procesar aprobaciones automáticas de vacaciones (diariamente a las 9:00 AM)
        $schedule->command('vacations:auto-approve')
                 ->dailyAt('09:00')
                 ->timezone('America/Mexico_City')
                 ->withoutOverlapping()
                 ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

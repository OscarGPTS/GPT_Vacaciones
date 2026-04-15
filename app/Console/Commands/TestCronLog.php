<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemLog;

class TestCronLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:test-log
                            {--message= : Mensaje personalizado para el log}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de prueba: escribe un registro en system_logs cada vez que se ejecuta (úsalo cada minuto para validar el scheduler)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $executedAt = now();
        $message    = $this->option('message') ?: 'Cron de prueba ejecutado correctamente';

        SystemLog::create([
            'user_id'    => null,
            'created_by' => null,
            'level'      => 'debug',
            'type'       => 'cron_test',
            'message'    => $message,
            'context'    => [
                'command'     => 'cron:test-log',
                'executed_at' => $executedAt->toDateTimeString(),
                'hostname'    => gethostname(),
                'php_version' => PHP_VERSION,
            ],
            'status' => 'resolved',
        ]);

        $this->info("✅ [{$executedAt->toDateTimeString()}] Log de prueba registrado en system_logs.");

        return 0;
    }
}

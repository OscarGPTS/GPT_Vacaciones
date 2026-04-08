<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VacationImportService;

class ImportVacations extends Command
{
    protected $signature = 'vacation:import {file : Ruta al archivo Excel}';
    protected $description = 'Importar vacaciones masivamente desde archivo Excel';

    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("El archivo {$filePath} no existe.");
            return 1;
        }

        $this->info('Iniciando importación de vacaciones...');
        $this->newLine();

        $service = new VacationImportService();
        $result = $service->importFromFile($filePath);

        if ($result['success']) {
            $this->info("✓ Importación completada exitosamente");
            $this->table(
                ['Métrica', 'Cantidad'],
                [
                    ['Registros procesados', $result['processed']],
                    ['Actualizados', $result['updated']],
                    ['Creados', $result['created'] ?? 0],
                    ['Errores', $result['errors']],
                ]
            );

            if (!empty($result['details'])) {
                $this->newLine();
                $this->warn('Detalles de errores:');
                foreach ($result['details'] as $detail) {
                    $this->line("  Fila {$detail['row']}: {$detail['message']}");
                }
            }
        } else {
            $this->error("✗ Error en la importación: {$result['message']}");
        }

        return 0;
    }
}

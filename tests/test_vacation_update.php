<?php

require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\VacationImportService;
use App\Models\VacationsAvailable;
use Rap2hpoutre\FastExcel\FastExcel;

echo "===== PRUEBA DE ACTUALIZACIÓN DE VACACIONES EXISTENTES =====\n\n";

// 1. Crear archivo Excel con datos para actualizar períodos existentes
echo "1. Creando archivo de actualización...\n";

$updateData = collect([
    [
        'user_id' => 52,
        'date_start' => '2024-08-08',
        'date_end' => '2025-08-08',
        'days_availables' => 12.00,
        'dv' => 0,
        'days_enjoyed' => 8.00,  // CAMBIADO: era 5.00
        'days_reserved' => 1.00,  // CAMBIADO: era 2.50
        'status' => 'actual'
    ],
    [
        'user_id' => 53,
        'date_start' => '2024-01-15',
        'date_end' => '2025-01-15',
        'days_availables' => 14.00,
        'dv' => 0,
        'days_enjoyed' => 10.00,  // CAMBIADO: era 8.00
        'days_reserved' => 0.00,  // CAMBIADO: era 3.00
        'status' => 'actual'
    ],
]);

$updateFile = 'update_vacations_test_' . date('YmdHis') . '.xlsx';
$updatePath = storage_path('app/public/' . $updateFile);
(new FastExcel($updateData))->export($updatePath);
echo "   ✓ Archivo creado: {$updateFile}\n\n";

// 2. Verificar estados antes de actualizar
echo "2. Estados ANTES de actualizar:\n";
$period52 = VacationsAvailable::where('users_id', 52)
    ->where('date_start', '2024-08-08')
    ->where('is_historical', false)
    ->first();

$period53 = VacationsAvailable::where('users_id', 53)
    ->where('date_start', '2024-01-15')
    ->where('is_historical', false)
    ->first();

if ($period52) {
    echo "   Usuario 52 (2024-08-08):\n";
    echo "     - Disfrutados: {$period52->days_enjoyed}\n";
    echo "     - Reservados: {$period52->days_reserved}\n";
}

if ($period53) {
    echo "   Usuario 53 (2024-01-15):\n";
    echo "     - Disfrutados: {$period53->days_enjoyed}\n";
    echo "     - Reservados: {$period53->days_reserved}\n";
}
echo "\n";

// 3. Ejecutar actualización
echo "3. Ejecutando actualización...\n";
$service = new VacationImportService();
$results = $service->importFromFile($updatePath);

echo "   Resultados:\n";
echo "   - Procesadas: {$results['processed']}\n";
echo "   - Actualizadas: {$results['updated']}\n";
echo "   - Creadas: {$results['created']}\n";
echo "   - Errores: {$results['errors']}\n";

if (!empty($results['details'])) {
    echo "\n   Detalles de errores:\n";
    foreach ($results['details'] as $detail) {
        echo "     Fila {$detail['row']}: {$detail['message']}\n";
    }
}
echo "\n";

// 4. Verificar estados después de actualizar
echo "4. Estados DESPUÉS de actualizar:\n";
$period52After = VacationsAvailable::where('users_id', 52)
    ->where('date_start', '2024-08-08')
    ->where('is_historical', false)
    ->first();

$period53After = VacationsAvailable::where('users_id', 53)
    ->where('date_start', '2024-01-15')
    ->where('is_historical', false)
    ->first();

if ($period52After) {
    echo "   Usuario 52 (2024-08-08):\n";
    echo "     - Disfrutados: {$period52After->days_enjoyed} (antes: {$period52->days_enjoyed})\n";
    echo "     - Reservados: {$period52After->days_reserved} (antes: {$period52->days_reserved})\n";
    
    if ($period52After->days_enjoyed == 8.00 && $period52After->days_reserved == 1.00) {
        echo "     ✓ ACTUALIZACIÓN EXITOSA\n";
    } else {
        echo "     ✗ ACTUALIZACIÓN FALLIDA\n";
    }
}

if ($period53After) {
    echo "   Usuario 53 (2024-01-15):\n";
    echo "     - Disfrutados: {$period53After->days_enjoyed} (antes: {$period53->days_enjoyed})\n";
    echo "     - Reservados: {$period53After->days_reserved} (antes: {$period53->days_reserved})\n";
    
    if ($period53After->days_enjoyed == 10.00 && $period53After->days_reserved == 0.00) {
        echo "     ✓ ACTUALIZACIÓN EXITOSA\n";
    } else {
        echo "     ✗ ACTUALIZACIÓN FALLIDA\n";
    }
}

echo "\n===== FIN DE PRUEBA =====\n";

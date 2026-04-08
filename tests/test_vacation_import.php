<?php

require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\VacationImportService;
use App\Models\VacationsAvailable;

echo "===== PRUEBA DE IMPORTACIÓN DE VACACIONES =====\n\n";

// 1. Generar plantilla
echo "1. Generando plantilla...\n";
$service = new VacationImportService();
$templateFile = $service->generateTemplate();
echo "   ✓ Plantilla generada: storage/app/public/{$templateFile}\n\n";

// 2. Verificar usuarios de prueba
echo "2. Verificando usuarios de prueba (ID 52, 53)...\n";
$user52 = \App\Models\User::find(52);
$user53 = \App\Models\User::find(53);

if (!$user52) {
    echo "   ✗ Usuario ID 52 no existe\n";
} else {
    echo "   ✓ Usuario 52: {$user52->name}\n";
}

if (!$user53) {
    echo "   ✗ Usuario ID 53 no existe\n";
} else {
    echo "   ✓ Usuario 53: {$user53->name}\n";
}
echo "\n";

// 3. Verificar períodos existentes
echo "3. Períodos existentes antes de la importación:\n";
if ($user52) {
    $periods52 = VacationsAvailable::where('users_id', 52)
        ->where('is_historical', false)
        ->orderBy('date_start')
        ->get();
    echo "   Usuario 52 tiene " . $periods52->count() . " períodos:\n";
    foreach ($periods52 as $period) {
        echo "     - Período {$period->period}: {$period->date_start} a {$period->date_end}\n";
        echo "       Días disponibles: {$period->days_availables}, DV: {$period->dv}, Disfrutados: {$period->days_enjoyed}\n";
    }
}

if ($user53) {
    $periods53 = VacationsAvailable::where('users_id', 53)
        ->where('is_historical', false)
        ->orderBy('date_start')
        ->get();
    echo "   Usuario 53 tiene " . $periods53->count() . " períodos:\n";
    foreach ($periods53 as $period) {
        echo "     - Período {$period->period}: {$period->date_start} a {$period->date_end}\n";
        echo "       Días disponibles: {$period->days_availables}, DV: {$period->dv}, Disfrutados: {$period->days_enjoyed}\n";
    }
}
echo "\n";

// 4. Probar importación desde la plantilla generada
echo "4. Probando importación desde plantilla...\n";
$importPath = storage_path('app/public/' . $templateFile);
if (file_exists($importPath)) {
    $results = $service->importFromFile($importPath);
    
    echo "   Resultados de importación:\n";
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
} else {
    echo "   ✗ Archivo de plantilla no encontrado\n";
}
echo "\n";

// 5. Verificar cambios después de importación
echo "5. Períodos después de la importación:\n";
if ($user52) {
    $periods52After = VacationsAvailable::where('users_id', 52)
        ->where('is_historical', false)
        ->orderBy('date_start')
        ->get();
    echo "   Usuario 52 ahora tiene " . $periods52After->count() . " períodos:\n";
    foreach ($periods52After as $period) {
        echo "     - Período {$period->period}: {$period->date_start} a {$period->date_end}\n";
        echo "       Días disponibles: {$period->days_availables}, DV: {$period->dv}, Disfrutados: {$period->days_enjoyed}\n";
    }
}

if ($user53) {
    $periods53After = VacationsAvailable::where('users_id', 53)
        ->where('is_historical', false)
        ->orderBy('date_start')
        ->get();
    echo "   Usuario 53 ahora tiene " . $periods53After->count() . " períodos:\n";
    foreach ($periods53After as $period) {
        echo "     - Período {$period->period}: {$period->date_start} a {$period->date_end}\n";
        echo "       Días disponibles: {$period->days_availables}, DV: {$period->dv}, Disfrutados: {$period->days_enjoyed}\n";
    }
}

echo "\n===== FIN DE PRUEBA =====\n";

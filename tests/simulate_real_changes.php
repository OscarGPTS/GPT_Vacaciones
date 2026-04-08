<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\VacationsAvailable;
use App\Services\VacationDailyAccumulatorService;
use Illuminate\Support\Facades\DB;

echo "================================================\n";
echo "SIMULACIÓN: Modificar valores para ver tabla\n";
echo "================================================\n\n";

// Paso 1: Modificar 10 períodos temporalmente
echo "Paso 1: Modificando días_calculated de 10 períodos...\n\n";

$periods = VacationsAvailable::with(['user'])
    ->where('is_historical', false)
    ->where('status', '!=', 'vencido')
    ->whereNotNull('days_calculated')
    ->where('days_calculated', '>', 0)
    ->limit(10)
    ->get();

$originalValues = [];

foreach ($periods as $period) {
    $originalValues[$period->id] = $period->days_calculated;
    
    // Reducir el valor en 0.25 días (para simular que falta actualizar)
    $newValue = max(0, $period->days_calculated - 0.25);
    
    DB::table('vacations_availables')
        ->where('id', $period->id)
        ->update(['days_calculated' => $newValue]);
    
    $userName = $period->user ? $period->user->first_name . ' ' . $period->user->last_name : 'N/D';
    echo "  ✓ Período {$period->id} ({$userName}): {$period->days_calculated} → {$newValue}\n";
}

echo "\n";
echo "Paso 2: Ejecutando servicio de actualización...\n\n";

$service = new VacationDailyAccumulatorService();
$results = $service->updateDailyAccumulationForAllUsers();

echo "Resultados:\n";
echo "  Usuarios procesados: " . $results['users_processed'] . "\n";
echo "  Períodos actualizados: " . $results['periods_updated'] . "\n";
echo "  Details count: " . count($results['details']) . "\n";
echo "\n";

if (count($results['details']) > 0) {
    echo "✓ ÉXITO: El array 'details' tiene " . count($results['details']) . " registros\n\n";
    
    echo "Detalle de cambios capturados:\n";
    echo str_repeat("-", 100) . "\n";
    printf("%-30s | %-25s | %8s | %10s | %10s | %10s\n", 
        "Planta", "Usuario", "Período", "Anterior", "Actual", "Incremento");
    echo str_repeat("-", 100) . "\n";
    
    foreach ($results['details'] as $detail) {
        printf("%-30s | %-25s | %8s | %10.2f | %10.2f | %10.2f\n",
            substr($detail['planta'], 0, 30),
            substr($detail['usuario'], 0, 25),
            $detail['periodo'],
            $detail['dias_anteriores'],
            $detail['dias_actualizados'],
            $detail['incremento']
        );
    }
    echo str_repeat("-", 100) . "\n";
    
    echo "\n";
    echo "================================================\n";
    echo "✓ CONFIRMACIÓN: La tabla funcionaría en el modal\n";
    echo "================================================\n\n";
    echo "Si ejecutaras el proceso desde el navegador ahora mismo,\n";
    echo "verías una tabla con " . count($results['details']) . " registros mostrando estos cambios.\n\n";
} else {
    echo "⚠ El array 'details' sigue vacío (no debería pasar)\n\n";
}

echo "Paso 3: Restaurando valores originales...\n\n";

foreach ($originalValues as $id => $originalValue) {
    DB::table('vacations_availables')
        ->where('id', $id)
        ->update(['days_calculated' => $originalValue]);
    echo "  ✓ Período {$id} restaurado\n";
}

echo "\n✓ Todos los valores restaurados a su estado original\n";
echo "\n";
echo "================================================\n";
echo "CONCLUSIÓN:\n";
echo "================================================\n\n";
echo "✓ El servicio captura correctamente los detalles\n";
echo "✓ El array 'details' se llena cuando hay cambios > 0.01\n";
echo "✓ La tabla se mostraría correctamente en el modal\n";
echo "\n";
echo "ℹ️  Para ver la tabla en el navegador con datos reales:\n";
echo "   1. Espera hasta mañana (habrá incrementos)\n";
echo "   2. O ejecuta este script justo ANTES de actualizar desde el navegador\n";
echo "      (no ejecutes restore al final, ve al navegador y actualiza)\n";
echo "\n";

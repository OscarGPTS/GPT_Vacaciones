<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\VacationDailyAccumulatorService;

echo "================================================\n";
echo "TEST: Verificar salida del servicio\n";
echo "================================================\n\n";

$service = new VacationDailyAccumulatorService();

echo "Ejecutando updateDailyAccumulationForAllUsers()...\n\n";

$startTime = microtime(true);
$results = $service->updateDailyAccumulationForAllUsers();
$duration = round(microtime(true) - $startTime, 2);

echo "Resultado:\n";
echo str_repeat("-", 50) . "\n";

// Mostrar todas las claves del array
echo "Claves en \$results:\n";
foreach (array_keys($results) as $key) {
    echo "  - {$key}\n";
}
echo "\n";

// Verificar si 'details' existe
if (array_key_exists('details', $results)) {
    echo "✓ Array 'details' EXISTE\n";
    echo "  Tipo: " . gettype($results['details']) . "\n";
    echo "  Count: " . count($results['details']) . "\n\n";
    
    if (count($results['details']) > 0) {
        echo "✓ Hay " . count($results['details']) . " registros en 'details'\n\n";
        
        echo "Primeros 5 registros:\n";
        echo str_repeat("-", 50) . "\n";
        foreach (array_slice($results['details'], 0, 5) as $i => $detail) {
            echo ($i + 1) . ". " . $detail['usuario'] . " | " . $detail['planta'] . "\n";
            echo "   Período: " . $detail['periodo'] . "\n";
            echo "   Anterior: " . number_format($detail['dias_anteriores'], 2) . "\n";
            echo "   Actual: " . number_format($detail['dias_actualizados'], 2) . "\n";
            echo "   Incremento: " . number_format($detail['incremento'], 2) . "\n\n";
        }
    } else {
        echo "⚠ El array 'details' está VACÍO\n";
        echo "  Esto significa que NO hubo cambios > 0.01 días\n";
        echo "  Los períodos ya fueron actualizados hoy.\n\n";
    }
} else {
    echo "✗ Array 'details' NO EXISTE en los resultados\n";
    echo "  Esto es un ERROR - el servicio debería devolver 'details'\n\n";
}

echo str_repeat("-", 50) . "\n";
echo "Resumen:\n";
echo "  Usuarios procesados: " . $results['users_processed'] . "\n";
echo "  Períodos actualizados: " . $results['periods_updated'] . "\n";
echo "  Períodos omitidos: " . $results['periods_skipped'] . "\n";
echo "  Períodos vencidos: " . $results['periods_expired'] . "\n";
echo "  Duración: {$duration} segundos\n";
echo "  Errores: " . count($results['errors']) . "\n";

if (isset($results['details'])) {
    echo "  Details count: " . count($results['details']) . "\n";
}

echo "\n";
echo "================================================\n";
echo "CONCLUSIÓN:\n";
echo "================================================\n\n";

if (!array_key_exists('details', $results)) {
    echo "❌ PROBLEMA: El servicio NO devuelve el array 'details'\n";
    echo "   Verifica VacationDailyAccumulatorService.php\n";
} elseif (count($results['details']) === 0) {
    echo "✓ El servicio funciona correctamente\n";
    echo "✓ El array 'details' existe pero está vacío\n";
    echo "ℹ️  No hay cambios porque los períodos fueron actualizados hoy\n";
    echo "\n";
    echo "SOLUCIONES:\n";
    echo "  1. Espera hasta mañana para ver cambios reales\n";
    echo "  2. O modifica temporalmente el campo 'days_calculated' de algunos períodos\n";
    echo "  3. O cambia el filtro de > 0.01 a > 0 en el servicio\n";
} else {
    echo "✓ TODO FUNCIONA CORRECTAMENTE\n";
    echo "✓ El servicio devuelve " . count($results['details']) . " registros\n";
    echo "✓ La tabla debería mostrarse en el modal\n";
}

echo "\n";

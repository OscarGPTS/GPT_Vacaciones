<?php

/**
 * Test de conversión de serial de Excel a fecha
 */

require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

echo "=== TEST: Conversión de Serial de Excel a Fecha ===\n\n";

// Casos de prueba con seriales de Excel conocidos
$testCases = [
    ['serial' => 45261, 'esperado' => '2023-11-13', 'descripcion' => '13 de Noviembre 2023'],
    ['serial' => 44927, 'esperado' => '2023-01-01', 'descripcion' => '1 de Enero 2023'],
    ['serial' => 25569, 'esperado' => '1970-01-01', 'descripcion' => 'Unix Epoch (1970-01-01)'],
    ['serial' => 45627, 'esperado' => '2024-11-13', 'descripcion' => '13 de Noviembre 2024'],
    ['serial' => 1, 'esperado' => '1899-12-31', 'descripcion' => 'Serial 1 (base Excel)'],
];

echo "Probando conversión de seriales de Excel:\n";
echo str_repeat('-', 80) . "\n\n";

$passed = 0;
$failed = 0;

foreach ($testCases as $test) {
    $serial = $test['serial'];
    
    // Fórmula: (serial - 25569) * 86400 = timestamp Unix
    // 25569 = cantidad de días desde 1900-01-01 hasta 1970-01-01
    $unixTimestamp = ($serial - 25569) * 86400;
    $resultado = Carbon::createFromTimestamp($unixTimestamp)->format('Y-m-d');
    
    echo "Serial: {$serial}\n";
    echo "Descripción: {$test['descripcion']}\n";
    echo "Esperado: {$test['esperado']}\n";
    echo "Resultado: {$resultado}\n";
    
    if ($resultado === $test['esperado']) {
        echo "✅ PASADO\n";
        $passed++;
    } else {
        echo "❌ FALLIDO\n";
        $failed++;
    }
    echo "\n";
}

echo str_repeat('=', 80) . "\n";
echo "RESUMEN: {$passed} pasados, {$failed} fallidos de " . count($testCases) . " tests\n";
echo str_repeat('=', 80) . "\n\n";

// Test adicional: Verificar que el código en VacationImport.php usa esta fórmula
echo "Verificando implementación en VacationImport.php:\n";
echo str_repeat('-', 80) . "\n";

$importFile = __DIR__ . '/../app/Livewire/VacationImport.php';
$content = file_get_contents($importFile);

if (strpos($content, '($value - 25569) * 86400') !== false) {
    echo "✅ Fórmula de conversión correcta encontrada\n";
} else {
    echo "❌ Fórmula NO encontrada o incorrecta\n";
}

if (strpos($content, 'Carbon::createFromTimestamp') !== false) {
    echo "✅ Uso de Carbon::createFromTimestamp encontrado\n";
} else {
    echo "❌ Carbon::createFromTimestamp NO encontrado\n";
}

if (strpos($content, 'PhpOffice\\PhpSpreadsheet\\Shared\\Date') !== false) {
    echo "⚠️  Advertencia: Aún se usa PhpSpreadsheet (debería eliminarse)\n";
} else {
    echo "✅ No se usa PhpSpreadsheet (correcto para FastExcel)\n";
}

echo "\n";

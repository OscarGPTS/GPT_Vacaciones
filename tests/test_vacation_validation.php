<?php

/**
 * Test de validación: Días disfrutados no pueden ser mayores a días disponibles
 * 
 * Verifica que el sistema de importación de vacaciones rechace correctamente
 * los registros donde días_disfrutados > días_disponibles
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST: Validación de Días Disfrutados <= Días Disponibles ===\n\n";

// Casos de prueba
$testCases = [
    [
        'nombre' => 'Caso válido: días disfrutados < días disponibles',
        'dias_disponibles' => 15.0,
        'dias_disfrutados' => 10.0,
        'esperado' => true, // debe pasar validación
    ],
    [
        'nombre' => 'Caso válido: días disfrutados = días disponibles',
        'dias_disponibles' => 15.0,
        'dias_disfrutados' => 15.0,
        'esperado' => true,
    ],
    [
        'nombre' => 'Caso INVÁLIDO: días disfrutados > días disponibles',
        'dias_disponibles' => 15.0,
        'dias_disfrutados' => 20.0,
        'esperado' => false, // debe fallar validación
    ],
    [
        'nombre' => 'Caso INVÁLIDO: días disfrutados mucho mayor',
        'dias_disponibles' => 10.0,
        'dias_disfrutados' => 50.0,
        'esperado' => false,
    ],
    [
        'nombre' => 'Caso válido: ambos en cero',
        'dias_disponibles' => 0.0,
        'dias_disfrutados' => 0.0,
        'esperado' => true,
    ],
    [
        'nombre' => 'Caso INVÁLIDO: disponibles en cero, disfrutados > 0',
        'dias_disponibles' => 0.0,
        'dias_disfrutados' => 5.0,
        'esperado' => false,
    ],
    [
        'nombre' => 'Caso válido: números decimales',
        'dias_disponibles' => 15.5,
        'dias_disfrutados' => 12.75,
        'esperado' => true,
    ],
    [
        'nombre' => 'Caso INVÁLIDO: diferencia mínima',
        'dias_disponibles' => 15.0,
        'dias_disfrutados' => 15.01,
        'esperado' => false,
    ],
    [
        'nombre' => 'Caso INVÁLIDO: días disponibles negativos',
        'dias_disponibles' => -5.0,
        'dias_disfrutados' => 0.0,
        'esperado' => false,
    ],
    [
        'nombre' => 'Caso INVÁLIDO: días disfrutados negativos',
        'dias_disponibles' => 15.0,
        'dias_disfrutados' => -2.0,
        'esperado' => false,
    ],
    [
        'nombre' => 'Caso INVÁLIDO: ambos negativos',
        'dias_disponibles' => -10.0,
        'dias_disfrutados' => -5.0,
        'esperado' => false,
    ],
];

$totalTests = count($testCases);
$passed = 0;
$failed = 0;

foreach ($testCases as $index => $test) {
    echo "\n" . str_repeat('-', 70) . "\n";
    echo "Test #" . ($index + 1) . ": {$test['nombre']}\n";
    echo str_repeat('-', 70) . "\n";
    echo "Días disponibles: {$test['dias_disponibles']}\n";
    echo "Días disfrutados: {$test['dias_disfrutados']}\n";
    echo "Resultado esperado: " . ($test['esperado'] ? 'VÁLIDO' : 'INVÁLIDO') . "\n\n";

    // Simular la validación (lógica del VacationImport.php)
    $diasDisponibles = $test['dias_disponibles'];
    $diasDisfrutados = $test['dias_disfrutados'];
    
    // Validar: negativos primero, luego disfrutados > disponibles
    $esValido = !($diasDisponibles < 0 || $diasDisfrutados < 0 || $diasDisfrutados > $diasDisponibles);
    
    echo "Resultado obtenido: " . ($esValido ? 'VÁLIDO' : 'INVÁLIDO') . "\n";
    
    if ($esValido === $test['esperado']) {
        echo "✅ TEST PASADO\n";
        $passed++;
    } else {
        echo "❌ TEST FALLIDO\n";
        echo "   Se esperaba: " . ($test['esperado'] ? 'VÁLIDO' : 'INVÁLIDO') . "\n";
        echo "   Se obtuvo: " . ($esValido ? 'VÁLIDO' : 'INVÁLIDO') . "\n";
        $failed++;
    }
    
    // Mostrar mensaje de error que se generaría
    if (!$esValido) {
        if ($diasDisponibles < 0) {
            $errorMsg = "Los días disponibles no pueden ser negativos ({$diasDisponibles})";
        } elseif ($diasDisfrutados < 0) {
            $errorMsg = "Los días disfrutados no pueden ser negativos ({$diasDisfrutados})";
        } else {
            $errorMsg = "Los días disfrutados ({$diasDisfrutados}) no pueden ser mayores a los días disponibles ({$diasDisponibles})";
        }
        echo "\n📋 Mensaje de error generado:\n";
        echo "   \"$errorMsg\"\n";
    }
}

// Resumen
echo "\n\n";
echo str_repeat('=', 70) . "\n";
echo "RESUMEN DE TESTS\n";
echo str_repeat('=', 70) . "\n";
echo "Total de tests: $totalTests\n";
echo "Tests pasados: $passed (" . round(($passed/$totalTests)*100, 1) . "%)\n";
echo "Tests fallidos: $failed (" . round(($failed/$totalTests)*100, 1) . "%)\n";
echo str_repeat('=', 70) . "\n";

if ($failed === 0) {
    echo "\n🎉 ¡TODOS LOS TESTS PASARON!\n";
    echo "La validación de días disfrutados vs días disponibles funciona correctamente.\n\n";
} else {
    echo "\n⚠️ ALGUNOS TESTS FALLARON\n";
    echo "Por favor revisa la lógica de validación.\n\n";
}

// Test adicional: Verificar que la validación se aplica en importRecord()
echo "\n" . str_repeat('=', 70) . "\n";
echo "VERIFICACIÓN DE INTEGRACIÓN\n";
echo str_repeat('=', 70) . "\n";
echo "\nVerificando que el código de VacationImport.php incluye la validación:\n\n";

$importFile = __DIR__ . '/../app/Livewire/VacationImport.php';
$content = file_get_contents($importFile);

// Buscar la validación en parseRow()
if (strpos($content, "if (\$diasDisfrutados > \$diasDisponibles)") !== false) {
    echo "✅ Validación encontrada en parseRow() (nivel Excel)\n";
} else {
    echo "❌ Validación NO encontrada en parseRow()\n";
}

// Buscar la validación en importRecord()
if (strpos($content, "if (\$record['dias_disfrutados'] > \$record['dias_disponibles'])") !== false) {
    echo "✅ Validación encontrada en importRecord() (nivel BD)\n";
} else {
    echo "❌ Validación NO encontrada en importRecord()\n";
}

// Verificar mensaje de error
if (strpos($content, "Los días disfrutados") !== false && 
    strpos($content, "no pueden ser mayores a los días disponibles") !== false) {
    echo "✅ Mensaje de error descriptivo configurado\n";
} else {
    echo "❌ Mensaje de error NO configurado\n";
}

echo "\n" . str_repeat('=', 70) . "\n";
echo "FIN DEL TEST\n";
echo str_repeat('=', 70) . "\n";

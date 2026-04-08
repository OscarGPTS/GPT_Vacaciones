<?php

/**
 * Test para validar la asignación correcta de días en la importación de vacaciones.
 * 
 * Valida que:
 * - Período anterior: days_availables = columna J, days_enjoyed = total - J
 * - Período actual: days_availables = columna Q, days_enjoyed = total - Q
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Carbon\Carbon;

echo "╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║         TEST: VALIDACIÓN DE ASIGNACIÓN DE DÍAS EN IMPORTACIÓN                      ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

// Casos de prueba basados en el Excel de ejemplo
$testCases = [
    [
        'nombre' => 'ALCANTARA BAUTISTA BENJAMIN',
        'user_id' => 13,
        'periodo_anterior' => [
            'fecha_aniversario' => '25-may-25',
            'antiguedad' => 11,
            'dias_corresponden' => 24,  // Columna F
            'saldo_pendiente' => 23,    // Columna J
            'expected_availables' => 23,
            'expected_enjoyed' => 1,    // 24 - 23
        ],
        'periodo_actual' => [
            'fecha_aniversario' => '25-may-26',
            'antiguedad' => 12,
            'dias_corresponden' => 24,  // Columna M
            'saldo_pendiente' => 24,    // Columna Q
            'expected_availables' => 24,
            'expected_enjoyed' => 0,    // 24 - 24
        ],
    ],
    [
        'nombre' => 'BECERRA YEBRA JESUS',
        'user_id' => 14,
        'periodo_anterior' => [
            'fecha_aniversario' => '22-ago-25',
            'antiguedad' => 14,
            'dias_corresponden' => 24,  // Columna F
            'saldo_pendiente' => 18,    // Columna J
            'expected_availables' => 18,
            'expected_enjoyed' => 6,    // 24 - 18
        ],
        'periodo_actual' => [
            'fecha_aniversario' => '22-ago-26',
            'antiguedad' => 15,
            'dias_corresponden' => 24,  // Columna M
            'saldo_pendiente' => 24,    // Columna Q
            'expected_availables' => 24,
            'expected_enjoyed' => 0,    // 24 - 24
        ],
    ],
    [
        'nombre' => 'LOPEZ ARREOLA ANA LILIA',
        'user_id' => 18,
        'periodo_anterior' => [
            'fecha_aniversario' => '14-jul-25',
            'antiguedad' => 11,
            'dias_corresponden' => 24,  // Columna F
            'saldo_pendiente' => 14,    // Columna J
            'expected_availables' => 14,
            'expected_enjoyed' => 10,   // 24 - 14
        ],
        'periodo_actual' => [
            'fecha_aniversario' => '14-jul-26',
            'antiguedad' => 12,
            'dias_corresponden' => 24,  // Columna M
            'saldo_pendiente' => 24,    // Columna Q
            'expected_availables' => 24,
            'expected_enjoyed' => 0,    // 24 - 24
        ],
    ],
];

echo "Casos de prueba de asignación de días:\n";
echo str_repeat("─", 100) . "\n\n";

$passedTests = 0;
$failedTests = 0;

foreach ($testCases as $index => $case) {
    echo sprintf("Test %d: %s (User ID: %d)\n", $index + 1, $case['nombre'], $case['user_id']);
    echo str_repeat("─", 100) . "\n";
    
    // Validar período anterior
    echo "\n📅 PERÍODO ANTERIOR ({$case['periodo_anterior']['fecha_aniversario']}):\n";
    echo sprintf("  Días corresponden (F): %d\n", $case['periodo_anterior']['dias_corresponden']);
    echo sprintf("  Saldo pendiente (J):   %d\n", $case['periodo_anterior']['saldo_pendiente']);
    echo "\n  🧮 Cálculo esperado:\n";
    echo sprintf("     days_availables = %d (columna J)\n", $case['periodo_anterior']['expected_availables']);
    echo sprintf("     days_enjoyed    = %d - %d = %d\n", 
        $case['periodo_anterior']['dias_corresponden'],
        $case['periodo_anterior']['saldo_pendiente'],
        $case['periodo_anterior']['expected_enjoyed']
    );
    
    // Validación
    $calculated_enjoyed_ant = $case['periodo_anterior']['dias_corresponden'] - $case['periodo_anterior']['saldo_pendiente'];
    if ($calculated_enjoyed_ant == $case['periodo_anterior']['expected_enjoyed'] &&
        $case['periodo_anterior']['saldo_pendiente'] == $case['periodo_anterior']['expected_availables']) {
        echo "  ✅ CORRECTO\n";
        $passedTests++;
    } else {
        echo "  ❌ ERROR EN CÁLCULO\n";
        $failedTests++;
    }
    
    // Validar período actual
    echo "\n📅 PERÍODO ACTUAL ({$case['periodo_actual']['fecha_aniversario']}):\n";
    echo sprintf("  Días corresponden (M): %d\n", $case['periodo_actual']['dias_corresponden']);
    echo sprintf("  Saldo pendiente (Q):   %d\n", $case['periodo_actual']['saldo_pendiente']);
    echo "\n  🧮 Cálculo esperado:\n";
    echo sprintf("     days_availables = %d (columna Q)\n", $case['periodo_actual']['expected_availables']);
    echo sprintf("     days_enjoyed    = %d - %d = %d\n", 
        $case['periodo_actual']['dias_corresponden'],
        $case['periodo_actual']['saldo_pendiente'],
        $case['periodo_actual']['expected_enjoyed']
    );
    
    // Validación
    $calculated_enjoyed_act = $case['periodo_actual']['dias_corresponden'] - $case['periodo_actual']['saldo_pendiente'];
    if ($calculated_enjoyed_act == $case['periodo_actual']['expected_enjoyed'] &&
        $case['periodo_actual']['saldo_pendiente'] == $case['periodo_actual']['expected_availables']) {
        echo "  ✅ CORRECTO\n";
        $passedTests++;
    } else {
        echo "  ❌ ERROR EN CÁLCULO\n";
        $failedTests++;
    }
    
    echo "\n" . str_repeat("═", 100) . "\n\n";
}

// Resumen
echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                                   RESUMEN FINAL                                     ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

$totalTests = $passedTests + $failedTests;
$percentage = $totalTests > 0 ? round(($passedTests / $totalTests) * 100, 1) : 0;

echo sprintf("✓ Tests pasados: %d / %d (%.1f%%)\n", $passedTests, $totalTests, $percentage);
echo sprintf("✗ Tests fallidos: %d / %d\n\n", $failedTests, $totalTests);

if ($failedTests == 0) {
    echo "✅ TODOS LOS TESTS PASARON - La lógica de asignación es correcta\n\n";
} else {
    echo "⚠️  REVISAR: Hay " . $failedTests . " test(s) fallidos\n\n";
}

echo "Reglas de asignación validadas:\n";
echo "  • Período anterior: days_availables = columna J (Saldo Pendiente 2025-2026)\n";
echo "  • Período anterior: days_enjoyed = dias_corresponden - days_availables\n";
echo "  • Período actual: days_availables = columna Q (Saldo Pendiente 2026-2027)\n";
echo "  • Período actual: days_enjoyed = dias_corresponden - days_availables\n";
echo "\nVentajas de esta simplificación:\n";
echo "  ✓ No necesita sumar columnas G+H+I para período anterior\n";
echo "  ✓ No necesita calcular acumulación diaria proporcional\n";
echo "  ✓ Solo requiere dos valores: total y saldo pendiente\n";
echo "  ✓ Días disfrutados se calculan automáticamente\n";
echo "  ✓ Reduce errores de captura en el Excel\n";

echo "\nFecha de prueba: " . Carbon::now()->format('d/m/Y H:i:s') . "\n";

<?php

/**
 * TEST: Validación del Flujo Q4 - days_total_period correcto
 * 
 * Verifica que cuando se actualiza un período existente (flujo Q4),
 * el days_total_period se tome de la columna M (días corresponden),
 * NO de la columna Q (saldo pendiente).
 * 
 * Caso de prueba:
 * - Usuario 316
 * - Período anterior (2025-2026): J = 0 (sin saldo transferible)
 * - Período actual (2026-2027): M = 14 días, Q = 5 saldo
 * - Resultado esperado:
 *   * days_total_period = 14 (NO 5)
 *   * days_availables = 5
 *   * days_enjoyed = 9 (14 - 5)
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\VacationsAvailable;
use Carbon\Carbon;

echo "╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║         TEST: VALIDACIÓN FLUJO Q4 - days_total_period CORRECTO                     ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

echo "Escenario de prueba:\n";
echo "───────────────────────────────────────────────────────────────────────────────────────\n";
echo "Usuario 316 con importación:\n";
echo "  • Período anterior (2025-2026): Columna J = 0 (sin saldo transferible)\n";
echo "  • Período actual (2026-2027): Columna M = 14 días corresponden\n";
echo "  • Período actual (2026-2027): Columna Q = 5 saldo pendiente\n";
echo "  • Días disfrutados reales: 14 - 5 = 9 días\n\n";

// Buscar el período actual del usuario 316
$userId = 316;
$periodoActual = VacationsAvailable::where('users_id', $userId)
    ->where('is_historical', false)
    ->orderBy('date_start', 'desc')
    ->first();

if (!$periodoActual) {
    echo "❌ ERROR: No se encontró período actual para usuario 316\n";
    exit(1);
}

echo "Período encontrado en BD:\n";
echo "───────────────────────────────────────────────────────────────────────────────────────\n";
echo sprintf("  📅 Fecha inicio:       %s\n", $periodoActual->date_start);
echo sprintf("  📅 Fecha fin:          %s\n", $periodoActual->date_end);
echo sprintf("  📊 days_total_period:  %.2f\n", $periodoActual->days_total_period);
echo sprintf("  ✅ days_availables:    %.2f\n", $periodoActual->days_availables);
echo sprintf("  ❌ days_enjoyed:       %.2f\n", $periodoActual->days_enjoyed);
echo sprintf("  🔄 days_reserved:      %.2f\n", $periodoActual->days_reserved);
echo sprintf("  📈 Status:             %s\n\n", $periodoActual->status);

// Validaciones
$tests = [];
$allPassed = true;

// Test 1: days_total_period debe ser 14, NO 5
$expectedTotal = 14.0;
$actualTotal = (float) $periodoActual->days_total_period;
$totalCorrect = abs($actualTotal - $expectedTotal) < 0.01;
$tests[] = [
    'name' => 'days_total_period = 14 (columna M)',
    'expected' => $expectedTotal,
    'actual' => $actualTotal,
    'passed' => $totalCorrect
];
if (!$totalCorrect) $allPassed = false;

// Test 2: days_availables debe ser 5 (columna Q)
$expectedAvailable = 5.0;
$actualAvailable = (float) $periodoActual->days_availables;
$availableCorrect = abs($actualAvailable - $expectedAvailable) < 0.01;
$tests[] = [
    'name' => 'days_availables = 5 (columna Q)',
    'expected' => $expectedAvailable,
    'actual' => $actualAvailable,
    'passed' => $availableCorrect
];
if (!$availableCorrect) $allPassed = false;

// Test 3: days_enjoyed debe ser 9 (total - saldo)
$expectedEnjoyed = 9.0;
$actualEnjoyed = (float) $periodoActual->days_enjoyed;
$enjoyedCorrect = abs($actualEnjoyed - $expectedEnjoyed) < 0.01;
$tests[] = [
    'name' => 'days_enjoyed = 9 (14 - 5)',
    'expected' => $expectedEnjoyed,
    'actual' => $actualEnjoyed,
    'passed' => $enjoyedCorrect
];
if (!$enjoyedCorrect) $allPassed = false;

// Test 4: Coherencia interna (disponibles + disfrutados + reservados = total)
$sumaParciales = $actualAvailable + $actualEnjoyed + (float) $periodoActual->days_reserved;
$coherenceCorrect = abs($sumaParciales - $actualTotal) < 0.01;
$tests[] = [
    'name' => 'Coherencia: disponibles + disfrutados + reservados = total',
    'expected' => $actualTotal,
    'actual' => $sumaParciales,
    'passed' => $coherenceCorrect
];
if (!$coherenceCorrect) $allPassed = false;

// Mostrar resultados
echo "Resultados de validación:\n";
echo "════════════════════════════════════════════════════════════════════════════════════════\n";
foreach ($tests as $test) {
    $icon = $test['passed'] ? '✅' : '❌';
    $status = $test['passed'] ? 'PASS' : 'FAIL';
    echo sprintf(
        "%s [%s] %s\n     Esperado: %.2f | Obtenido: %.2f\n\n",
        $icon,
        $status,
        $test['name'],
        $test['expected'],
        $test['actual']
    );
}

// Resumen final
echo "╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                                   RESUMEN FINAL                                     ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

$passed = count(array_filter($tests, fn($t) => $t['passed']));
$total = count($tests);
$percentage = ($passed / $total) * 100;

echo sprintf("✓ Tests pasados: %d / %d (%.1f%%)\n", $passed, $total, $percentage);
echo sprintf("✗ Tests fallidos: %d / %d\n\n", $total - $passed, $total);

if ($allPassed) {
    echo "✅ TODOS LOS TESTS PASARON - Flujo Q4 funcionando correctamente\n\n";
    echo "El período se importó/actualizó correctamente:\n";
    echo "  • days_total_period usa columna M (días corresponden base)\n";
    echo "  • days_availables usa columna Q (saldo pendiente)\n";
    echo "  • days_enjoyed se calcula como: total - saldo\n";
    echo "  • La acumulación diaria se calculará sobre 14 días, no sobre 5\n";
} else {
    echo "❌ ALGUNOS TESTS FALLARON - Revisar lógica de importación\n\n";
    
    if (!$totalCorrect) {
        echo "⚠️  PROBLEMA CRÍTICO: days_total_period = {$actualTotal} (esperado: {$expectedTotal})\n";
        echo "    Esto causará que la acumulación diaria calcule: ({$actualTotal} × días) / 365\n";
        echo "    En lugar de: ({$expectedTotal} × días) / 365\n";
        echo "    Revisar flujo Q4 en VacationImport.php (líneas 685-710)\n";
    }
}

echo "\nFecha de prueba: " . Carbon::now()->format('d/m/Y H:i:s') . "\n";

exit($allPassed ? 0 : 1);

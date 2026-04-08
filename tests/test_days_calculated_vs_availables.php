<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\VacationsAvailable;

echo "=== COMPARACIÓN days_availables vs days_calculated ===\n\n";

$periodos = VacationsAvailable::where('is_historical', 0)
    ->orderBy('users_id')
    ->orderBy('period')
    ->limit(15)
    ->get();

echo sprintf('%-8s %-8s %-15s %-15s %-10s %-10s', 'User', 'Period', 'days_avail', 'days_calc', 'enjoyed', 'reserved') . "\n";
echo str_repeat('-', 80) . "\n";

foreach ($periodos as $p) {
    echo sprintf(
        '%-8s %-8s %-15s %-15s %-10s %-10s',
        $p->users_id,
        $p->period,
        $p->days_availables ?? 'NULL',
        $p->days_calculated ?? 'NULL',
        $p->days_enjoyed,
        $p->days_reserved
    ) . "\n";
}

echo "\n=== ANÁLISIS ===\n";
$conCalc = VacationsAvailable::whereNotNull('days_calculated')->count();
$sinCalc = VacationsAvailable::whereNull('days_calculated')->count();
$total = VacationsAvailable::count();

echo "Total períodos: {$total}\n";
echo "Con days_calculated: {$conCalc}\n";
echo "Sin days_calculated (NULL): {$sinCalc}\n\n";

echo "=== FÓRMULA ACTUAL EN EL CÓDIGO ===\n";
echo "LÍNEA 46 de VacacionesController.php:\n";
echo "  \$availableDays = \$period->days_availables - \$period->days_enjoyed - \$period->days_reserved;\n\n";

echo "❌ PROBLEMA: Solo usa days_availables, ignora days_calculated\n\n";

echo "=== PREGUNTA PARA EL USUARIO ===\n";
echo "¿Cuál debe ser la fórmula correcta?\n\n";
echo "OPCIÓN 1: Usar days_calculated (cálculo automático del sistema)\n";
echo "  \$saldo = \$period->days_calculated - \$period->days_enjoyed - \$period->days_reserved;\n\n";

echo "OPCIÓN 2: Usar days_availables (dato importado de Excel)\n";
echo "  \$saldo = \$period->days_availables - \$period->days_enjoyed - \$period->days_reserved;\n\n";

echo "OPCIÓN 3: Usar el mayor de ambos (más favorable al empleado)\n";
echo "  \$base = max(\$period->days_calculated ?? 0, \$period->days_availables ?? 0);\n";
echo "  \$saldo = \$base - \$period->days_enjoyed - \$period->days_reserved;\n\n";

echo "OPCIÓN 4: Priorizar days_calculated, si es NULL usar days_availables\n";
echo "  \$base = \$period->days_calculated ?? \$period->days_availables;\n";
echo "  \$saldo = \$base - \$period->days_enjoyed - \$period->days_reserved;\n\n";

echo "=== ESCENARIO ACTUAL ===\n";
$ejemplo = VacationsAvailable::where('is_historical', 0)
    ->whereNotNull('days_calculated')
    ->whereNotNull('days_availables')
    ->first();

if ($ejemplo) {
    echo "Ejemplo del período {$ejemplo->period} del usuario {$ejemplo->users_id}:\n";
    echo "  days_calculated: {$ejemplo->days_calculated}\n";
    echo "  days_availables: {$ejemplo->days_availables}\n";
    echo "  days_enjoyed: {$ejemplo->days_enjoyed}\n";
    echo "  days_reserved: {$ejemplo->days_reserved}\n\n";
    
    $saldo1 = $ejemplo->days_calculated - $ejemplo->days_enjoyed - $ejemplo->days_reserved;
    $saldo2 = $ejemplo->days_availables - $ejemplo->days_enjoyed - $ejemplo->days_reserved;
    $saldo3 = max($ejemplo->days_calculated ?? 0, $ejemplo->days_availables ?? 0) - $ejemplo->days_enjoyed - $ejemplo->days_reserved;
    $saldo4 = ($ejemplo->days_calculated ?? $ejemplo->days_availables) - $ejemplo->days_enjoyed - $ejemplo->days_reserved;
    
    echo "Saldos resultantes:\n";
    echo "  OPCIÓN 1 (days_calculated): {$saldo1} días\n";
    echo "  OPCIÓN 2 (days_availables): {$saldo2} días\n";
    echo "  OPCIÓN 3 (max de ambos): {$saldo3} días\n";
    echo "  OPCIÓN 4 (calculated ?? availables): {$saldo4} días\n";
} else {
    echo "No hay períodos con ambos campos llenos para comparar\n";
}

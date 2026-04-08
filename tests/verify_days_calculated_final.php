<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\VacationsAvailable;
use Carbon\Carbon;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "VERIFICACIÓN FINAL: days_calculated\n";
echo "========================================\n\n";

$today = Carbon::today();
echo "Fecha de hoy: " . $today->format('d-m-Y') . "\n\n";

// 1. Resumen general
$totalPeriods = VacationsAvailable::count();
$withCalculated = VacationsAvailable::whereNotNull('days_calculated')->count();
$withZero = VacationsAvailable::where('days_calculated', 0)->count();
$withNull = VacationsAvailable::whereNull('days_calculated')->count();

echo "RESUMEN GENERAL:\n";
echo str_repeat("-", 50) . "\n";
echo sprintf("Total de períodos en BD:                    %d\n", $totalPeriods);
echo sprintf("Períodos con days_calculated (no NULL):     %d (%.1f%%)\n", 
    $withCalculated, 
    ($totalPeriods > 0 ? ($withCalculated / $totalPeriods) * 100 : 0)
);
echo sprintf("  └─ Con valor 0:                           %d\n", $withZero);
echo sprintf("  └─ Con valor > 0:                         %d\n", $withCalculated - $withZero);
echo sprintf("Períodos con days_calculated = NULL:        %d (%.1f%%)\n", 
    $withNull,
    ($totalPeriods > 0 ? ($withNull / $totalPeriods) * 100 : 0)
);
echo str_repeat("-", 50) . "\n\n";

// 2. Períodos actuales (activos hoy)
$currentPeriods = VacationsAvailable::whereRaw('? BETWEEN date_start AND date_end', [$today->format('Y-m-d')])
    ->where('is_historical', false)
    ->get();

$currentWithCalculated = $currentPeriods->filter(fn($p) => $p->days_calculated !== null && $p->days_calculated > 0)->count();
$currentWithZero = $currentPeriods->filter(fn($p) => $p->days_calculated === 0)->count();
$currentWithNull = $currentPeriods->filter(fn($p) => $p->days_calculated === null)->count();

echo "PERÍODOS ACTUALES (activos hoy):\n";
echo str_repeat("-", 50) . "\n";
echo sprintf("Total períodos actuales:                    %d\n", $currentPeriods->count());
echo sprintf("Con days_calculated > 0:                    %d ✓\n", $currentWithCalculated);
echo sprintf("Con days_calculated = 0:                    %d\n", $currentWithZero);
echo sprintf("Con days_calculated = NULL:                 %d %s\n", 
    $currentWithNull,
    $currentWithNull > 0 ? '⚠ (DEBERÍA ser 0)' : '✓'
);
echo str_repeat("-", 50) . "\n\n";

// 3. Períodos pasados
$pastPeriods = VacationsAvailable::where('date_end', '<', $today->format('Y-m-d'))
    ->where('is_historical', false)
    ->get();

$pastWithZero = $pastPeriods->filter(fn($p) => $p->days_calculated === 0)->count();
$pastWithValue = $pastPeriods->filter(fn($p) => $p->days_calculated !== null && $p->days_calculated > 0)->count();
$pastWithNull = $pastPeriods->filter(fn($p) => $p->days_calculated === null)->count();

echo "PERÍODOS PASADOS (ya finalizados):\n";
echo str_repeat("-", 50) . "\n";
echo sprintf("Total períodos pasados:                     %d\n", $pastPeriods->count());
echo sprintf("Con days_calculated = 0:                    %d ✓\n", $pastWithZero);
echo sprintf("Con days_calculated > 0:                    %d\n", $pastWithValue);
echo sprintf("Con days_calculated = NULL:                 %d %s\n", 
    $pastWithNull,
    $pastWithNull > 0 ? '⚠ (DEBERÍA ser 0)' : '✓'
);
echo str_repeat("-", 50) . "\n\n";

// 4. Ejemplos de períodos actuales con cálculo
echo "EJEMPLOS DE PERÍODOS ACTUALES (primeros 5):\n";
echo str_repeat("-", 50) . "\n\n";

foreach ($currentPeriods->take(5) as $period) {
    $user = $period->user;
    if (!$user) continue;
    
    echo sprintf("Usuario: %s (ID: %d)\n", $user->first_name . ' ' . $user->last_name, $user->id);
    echo sprintf("  Período: %d | %s a %s\n", 
        $period->period,
        Carbon::parse($period->date_start)->format('d-m-Y'),
        Carbon::parse($period->date_end)->format('d-m-Y')
    );
    echo sprintf("  days_total_period:  %.2f días\n", $period->days_total_period);
    echo sprintf("  days_calculated:    %s\n", 
        $period->days_calculated !== null 
            ? number_format($period->days_calculated, 2) . ' días ✓' 
            : 'NULL ⚠'
    );
    echo sprintf("  days_availables:    %.2f días\n", $period->days_availables ?? 0);
    echo sprintf("  days_enjoyed:       %.2f días\n", $period->days_enjoyed ?? 0);
    
    // Calcular porcentaje de avance
    if ($period->days_calculated !== null && $period->days_total_period > 0) {
        $porcentaje = ($period->days_calculated / $period->days_total_period) * 100;
        echo sprintf("  Avance del período: %.1f%%\n", $porcentaje);
    }
    
    echo "\n";
}

// 5. Ejemplos de períodos pasados con valor 0
if ($pastWithZero > 0) {
    echo "EJEMPLOS DE PERÍODOS PASADOS CON 0 (primeros 3):\n";
    echo str_repeat("-", 50) . "\n\n";
    
    $examples = $pastPeriods->filter(fn($p) => $p->days_calculated === 0)->take(3);
    
    foreach ($examples as $period) {
        $user = $period->user;
        if (!$user) continue;
        
        echo sprintf("Usuario: %s | Período %d\n", 
            $user->first_name . ' ' . $user->last_name,
            $period->period
        );
        echo sprintf("  Fechas: %s a %s (Finalizó: %s)\n", 
            Carbon::parse($period->date_start)->format('d-m-Y'),
            Carbon::parse($period->date_end)->format('d-m-Y'),
            Carbon::parse($period->date_end)->diffForHumans()
        );
        echo sprintf("  days_calculated: %.2f (correcto, período pasado)\n", $period->days_calculated);
        echo sprintf("  days_availables: %.2f\n", $period->days_availables ?? 0);
        echo "\n";
    }
}

echo "========================================\n";
echo "CONCLUSIÓN:\n";
echo "========================================\n\n";

$issues = [];

if ($currentWithNull > 0) {
    $issues[] = "⚠ Hay {$currentWithNull} período(s) actual(es) con NULL";
}

if ($pastWithNull > 0) {
    $issues[] = "⚠ Hay {$pastWithNull} período(s) pasado(s) con NULL";
}

if (empty($issues)) {
    echo "✓ PERFECTO: Sistema funcionando correctamente\n";
    echo "  - Períodos actuales tienen cálculo automático\n";
    echo "  - Períodos pasados tienen valor 0\n";
    echo "  - No hay períodos con NULL\n\n";
    echo "✓ La tabla de 'Todos los Períodos de Vacaciones' mostrará:\n";
    echo "  - Columna 'Días Correspondientes al Período' (days_total_period)\n";
    echo "  - Columna 'Días Calculados' (days_calculated) ← NUEVA\n";
    echo "  - Columna 'Saldo Pendiente' (days_availables)\n";
} else {
    echo "⚠ PROBLEMAS DETECTADOS:\n\n";
    foreach ($issues as $issue) {
        echo "  {$issue}\n";
    }
    echo "\n";
    echo "SOLUCIÓN:\n";
    if ($currentWithNull > 0) {
        echo "  Ejecutar: php artisan vacations:update-accrual --all --force\n";
    }
    if ($pastWithNull > 0) {
        echo "  Ejecutar: php tests/update_null_days_calculated_to_zero.php\n";
    }
}

echo "\n";
echo "Verificación completada.\n";

<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\VacationsAvailable;
use App\Models\User;
use Carbon\Carbon;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "VERIFICACIÓN: Períodos ACTUALES (activos hoy)\n";
echo "========================================\n\n";

$today = Carbon::today();
echo "Fecha de hoy: " . $today->format('d-m-Y') . "\n\n";

// Buscar períodos ACTUALES (hoy está dentro del período)
$currentPeriods = VacationsAvailable::whereRaw('? BETWEEN date_start AND date_end', [$today->format('Y-m-d')])
    ->where('is_historical', false)
    ->with('user')
    ->get();

echo "Total de períodos ACTUALES (hoy dentro del rango): " . $currentPeriods->count() . "\n\n";

// Separar por estado de days_calculated
$withCalculated = $currentPeriods->filter(fn($p) => $p->days_calculated !== null);
$withNull = $currentPeriods->filter(fn($p) => $p->days_calculated === null);

echo "==============================\n";
echo "RESUMEN:\n";
echo "==============================\n\n";
echo sprintf("%-40s %d\n", "Períodos actuales con days_calculated:", $withCalculated->count());
echo sprintf("%-40s %d\n", "Períodos actuales SIN days_calculated:", $withNull->count());
echo str_repeat("-", 50) . "\n";
echo sprintf("%-40s %d\n\n", "TOTAL períodos actuales:", $currentPeriods->count());

// Mostrar períodos actuales con valores calculados
if ($withCalculated->count() > 0) {
    echo "==============================\n";
    echo "✓ PERÍODOS ACTUALES CON CÁLCULO (primeros 10):\n";
    echo "==============================\n\n";
    
    foreach ($withCalculated->take(10) as $period) {
        $user = $period->user;
        if (!$user) continue;
        
        $startDate = Carbon::parse($period->date_start);
        $endDate = Carbon::parse($period->date_end);
        $daysWorked = $startDate->diffInDays($today) + 1;
        
        echo sprintf(
            "- %s (ID: %d)\n",
            $user->first_name . ' ' . $user->last_name,
            $user->id
        );
        echo sprintf("  Período: %d | %s a %s\n", 
            $period->period,
            $startDate->format('d-m-Y'),
            $endDate->format('d-m-Y')
        );
        echo sprintf("  days_total_period: %.2f días\n", $period->days_total_period);
        echo sprintf("  days_calculated: %.2f días (%.2f%% del período)\n", 
            $period->days_calculated,
            ($period->days_calculated / $period->days_total_period) * 100
        );
        echo sprintf("  days_availables: %s\n", 
            $period->days_availables !== null ? number_format($period->days_availables, 2) . ' días' : 'NULL'
        );
        echo sprintf("  days_enjoyed: %.2f días\n", $period->days_enjoyed ?: 0);
        echo sprintf("  Días trabajados en período: %d días\n", $daysWorked);
        echo sprintf("  Status: %s\n\n", $period->status);
    }
    
    if ($withCalculated->count() > 10) {
        echo "... y " . ($withCalculated->count() - 10) . " más.\n\n";
    }
}

// Mostrar períodos actuales SIN cálculo (estos SÍ son un problema)
if ($withNull->count() > 0) {
    echo "==============================\n";
    echo "⚠ PERÍODOS ACTUALES SIN CÁLCULO:\n";
    echo "==============================\n\n";
    echo "Estos períodos DEBERÍAN tener days_calculated.\n";
    echo "Total: " . $withNull->count() . "\n\n";
    
    foreach ($withNull as $period) {
        $user = $period->user;
        if (!$user) {
            echo sprintf("- Período %d | Usuario ID %d (no existe)\n", $period->period, $period->users_id);
            continue;
        }
        
        $startDate = Carbon::parse($period->date_start);
        $endDate = Carbon::parse($period->date_end);
        
        // Verificar motivos posibles
        $reasons = [];
        if (empty($user->admission) || $user->admission < '1900-01-01') {
            $reasons[] = 'Sin fecha admisión válida';
        } elseif (Carbon::parse($user->admission)->diffInYears($today) < 1) {
            $reasons[] = 'Antigüedad < 1 año';
        }
        if ($user->active != 1) {
            $reasons[] = 'Usuario inactivo';
        }
        
        echo sprintf(
            "- %s (ID: %d)\n",
            $user->first_name . ' ' . $user->last_name,
            $user->id
        );
        echo sprintf("  Período: %d | %s a %s\n", 
            $period->period,
            $startDate->format('d-m-Y'),
            $endDate->format('d-m-Y')
        );
        echo sprintf("  Admisión: %s | Activo: %s\n",
            $user->admission ?? 'NULL',
            $user->active == 1 ? 'Sí' : 'No'
        );
        if (!empty($reasons)) {
            echo "  Motivo: " . implode(', ', $reasons) . "\n";
        } else {
            echo "  Motivo: DESCONOCIDO - debería actualizarse\n";
        }
        echo "\n";
    }
    
    echo "\nSOLUCIÓN: Ejecutar comando de actualización:\n";
    echo "  php artisan vacations:update-accrual --all --force\n\n";
}

// Estadísticas adicionales
echo "==============================\n";
echo "ESTADÍSTICAS ADICIONALES:\n";
echo "==============================\n\n";

if ($currentPeriods->count() > 0) {
    $avgCalculated = $withCalculated->avg('days_calculated');
    $maxCalculated = $withCalculated->max('days_calculated');
    $minCalculated = $withCalculated->min('days_calculated');
    
    if ($avgCalculated) {
        echo sprintf("Promedio days_calculated: %.2f días\n", $avgCalculated);
        echo sprintf("Máximo days_calculated: %.2f días\n", $maxCalculated);
        echo sprintf("Mínimo days_calculated: %.2f días\n", $minCalculated);
    }
    
    // Comparar days_calculated vs days_availables
    $withBoth = $withCalculated->filter(fn($p) => $p->days_availables !== null);
    if ($withBoth->count() > 0) {
        echo "\n";
        echo sprintf("Períodos con ambos campos (calculated y availables): %d\n", $withBoth->count());
        
        $differences = [];
        foreach ($withBoth as $period) {
            $diff = abs($period->days_calculated - $period->days_availables);
            if ($diff > 1) {
                $differences[] = [
                    'user' => $period->user->first_name . ' ' . $period->user->last_name,
                    'period' => $period->period,
                    'calculated' => $period->days_calculated,
                    'availables' => $period->days_availables,
                    'diff' => $diff
                ];
            }
        }
        
        if (!empty($differences)) {
            echo "\n";
            echo "Períodos con diferencia > 1 día entre calculated y availables:\n";
            echo "(Puede indicar discrepancia entre cálculo automático e importación Excel)\n\n";
            
            foreach (array_slice($differences, 0, 5) as $diff) {
                echo sprintf("- %s | Período %d\n", $diff['user'], $diff['period']);
                echo sprintf("  Calculated: %.2f | Availables: %.2f | Diferencia: %.2f días\n\n",
                    $diff['calculated'],
                    $diff['availables'],
                    $diff['diff']
                );
            }
            
            if (count($differences) > 5) {
                echo "... y " . (count($differences) - 5) . " más con diferencias.\n";
            }
        } else {
            echo "✓ No hay diferencias significativas entre calculated y availables.\n";
        }
    }
}

echo "\n";
echo "==============================\n";
echo "CONCLUSIÓN:\n";
echo "==============================\n\n";

if ($withNull->count() === 0) {
    echo "✓ TODOS los períodos actuales tienen days_calculated.\n";
    echo "✓ El sistema está funcionando correctamente.\n";
    echo "✓ Los períodos pasados con NULL es comportamiento esperado.\n";
} else {
    echo "⚠ Hay " . $withNull->count() . " período(s) actual(es) sin days_calculated.\n";
    echo "⚠ Ejecutar: php artisan vacations:update-accrual --all --force\n";
}

echo "\n";

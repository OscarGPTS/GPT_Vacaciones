<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\VacationsAvailable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "DIAGNÓSTICO: days_calculated en NULL\n";
echo "========================================\n\n";

echo "Fecha de hoy: " . Carbon::today()->format('d-m-Y') . "\n\n";

// 1. Buscar todos los períodos con days_calculated en NULL
$periodsWithNull = VacationsAvailable::whereNull('days_calculated')
    ->with('user')
    ->get();

echo "Total de períodos con days_calculated = NULL: " . $periodsWithNull->count() . "\n\n";

if ($periodsWithNull->isEmpty()) {
    echo "✓ No hay períodos con days_calculated en NULL. Todo está correcto.\n";
    exit(0);
}

// Agrupar por motivo
$reasons = [
    'is_historical' => 0,
    'periodo_no_actual' => 0,
    'sin_usuario' => 0,
    'sin_admission' => 0,
    'antiguedad_menor_1_anio' => 0,
    'fecha_fuera_periodo' => 0,
    'actualizado_hoy' => 0,
    'otros' => 0,
];

$examples = [];
$today = Carbon::today();

echo "Analizando períodos con NULL...\n\n";

foreach ($periodsWithNull as $period) {
    $reason = null;
    $detail = '';
    
    // Motivo 1: Período histórico
    if ($period->is_historical) {
        $reasons['is_historical']++;
        $reason = 'Período histórico (is_historical = true)';
        if (count($examples) < 5) {
            $examples[] = [
                'user' => $period->user ? $period->user->first_name . ' ' . $period->user->last_name : 'N/D',
                'period' => $period->period,
                'date_start' => $period->date_start,
                'date_end' => $period->date_end,
                'reason' => $reason
            ];
        }
        continue;
    }
    
    // Motivo 2: Sin usuario
    if (!$period->user) {
        $reasons['sin_usuario']++;
        $reason = 'Usuario no existe o fue eliminado';
        if (count($examples) < 5) {
            $examples[] = [
                'user' => 'ID: ' . $period->users_id,
                'period' => $period->period,
                'date_start' => $period->date_start,
                'date_end' => $period->date_end,
                'reason' => $reason
            ];
        }
        continue;
    }
    
    $user = $period->user;
    
    // Motivo 3: Sin fecha de admisión
    if (empty($user->admission) || $user->admission < '1900-01-01') {
        $reasons['sin_admission']++;
        $reason = 'Usuario sin fecha de admisión válida';
        if (count($examples) < 5) {
            $examples[] = [
                'user' => $user->first_name . ' ' . $user->last_name,
                'period' => $period->period,
                'admission' => $user->admission ?? 'NULL',
                'date_start' => $period->date_start,
                'date_end' => $period->date_end,
                'reason' => $reason
            ];
        }
        continue;
    }
    
    // Motivo 4: Antigüedad menor a 1 año
    try {
        $admissionDate = Carbon::parse($user->admission);
        if ($admissionDate->diffInYears($today) < 1) {
            $reasons['antiguedad_menor_1_anio']++;
            $reason = 'Antigüedad menor a 1 año';
            if (count($examples) < 5) {
                $examples[] = [
                    'user' => $user->first_name . ' ' . $user->last_name,
                    'period' => $period->period,
                    'admission' => $user->admission,
                    'antiguedad_meses' => $admissionDate->diffInMonths($today),
                    'date_start' => $period->date_start,
                    'date_end' => $period->date_end,
                    'reason' => $reason
                ];
            }
            continue;
        }
    } catch (\Exception $e) {
        $reasons['sin_admission']++;
        continue;
    }
    
    // Motivo 5: Fecha de hoy fuera del período
    $startDate = Carbon::parse($period->date_start);
    $endDate = Carbon::parse($period->date_end);
    
    if (!$today->between($startDate, $endDate)) {
        $reasons['fecha_fuera_periodo']++;
        
        if ($today->lessThan($startDate)) {
            $detail = 'Período futuro (inicia ' . $startDate->format('d-m-Y') . ')';
        } else {
            $detail = 'Período pasado (finalizó ' . $endDate->format('d-m-Y') . ')';
        }
        
        $reason = 'Hoy no está dentro del período: ' . $detail;
        
        if (count($examples) < 5) {
            $examples[] = [
                'user' => $user->first_name . ' ' . $user->last_name,
                'period' => $period->period,
                'date_start' => $period->date_start,
                'date_end' => $period->date_end,
                'hoy' => $today->format('Y-m-d'),
                'reason' => $reason
            ];
        }
        continue;
    }
    
    // Motivo 6: Ya se actualizó hoy (pero sin --force, no se procesó)
    $lastUpdate = Carbon::parse($period->updated_at);
    if ($lastUpdate->isToday()) {
        $reasons['actualizado_hoy']++;
        $reason = 'Actualizado hoy pero days_calculated sigue NULL (posible error)';
        if (count($examples) < 5) {
            $examples[] = [
                'user' => $user->first_name . ' ' . $user->last_name,
                'period' => $period->period,
                'date_start' => $period->date_start,
                'date_end' => $period->date_end,
                'updated_at' => $period->updated_at,
                'reason' => $reason
            ];
        }
        continue;
    }
    
    // Si llegamos aquí, no hay motivo obvio
    $reasons['otros']++;
    if (count($examples) < 5) {
        $examples[] = [
            'user' => $user->first_name . ' ' . $user->last_name,
            'period' => $period->period,
            'date_start' => $period->date_start,
            'date_end' => $period->date_end,
            'updated_at' => $period->updated_at,
            'reason' => 'Sin motivo obvio - DEBERÍA haberse actualizado'
        ];
    }
}

echo "==============================\n";
echo "RESUMEN POR MOTIVOS:\n";
echo "==============================\n\n";

echo sprintf("%-35s %s\n", "Motivo", "Cantidad");
echo str_repeat("-", 50) . "\n";
echo sprintf("%-35s %d\n", "Períodos históricos", $reasons['is_historical']);
echo sprintf("%-35s %d\n", "Hoy fuera del período", $reasons['fecha_fuera_periodo']);
echo sprintf("%-35s %d\n", "Antigüedad < 1 año", $reasons['antiguedad_menor_1_anio']);
echo sprintf("%-35s %d\n", "Sin fecha de admisión", $reasons['sin_admission']);
echo sprintf("%-35s %d\n", "Usuario no existe", $reasons['sin_usuario']);
echo sprintf("%-35s %d\n", "Actualizado hoy (error)", $reasons['actualizado_hoy']);
echo sprintf("%-35s %d\n", "Otros (revisar)", $reasons['otros']);
echo str_repeat("-", 50) . "\n";
echo sprintf("%-35s %d\n\n", "TOTAL", $periodsWithNull->count());

// Mostrar ejemplos
if (!empty($examples)) {
    echo "==============================\n";
    echo "EJEMPLOS (primeros 5):\n";
    echo "==============================\n\n";
    
    foreach ($examples as $i => $example) {
        echo "Ejemplo " . ($i + 1) . ":\n";
        foreach ($example as $key => $value) {
            echo sprintf("  %-20s %s\n", ucfirst($key) . ':', $value);
        }
        echo "\n";
    }
}

// Recomendaciones
echo "==============================\n";
echo "RECOMENDACIONES:\n";
echo "==============================\n\n";

if ($reasons['is_historical'] > 0) {
    echo "✓ " . $reasons['is_historical'] . " períodos históricos: NORMAL, no se actualizan.\n";
}

if ($reasons['fecha_fuera_periodo'] > 0) {
    echo "✓ " . $reasons['fecha_fuera_periodo'] . " períodos fuera de fecha: NORMAL, solo se actualizan períodos activos.\n";
}

if ($reasons['antiguedad_menor_1_anio'] > 0) {
    echo "⚠ " . $reasons['antiguedad_menor_1_anio'] . " empleados con antigüedad < 1 año: NORMAL, esperando cumplir primer año.\n";
}

if ($reasons['sin_admission'] > 0) {
    echo "⚠ " . $reasons['sin_admission'] . " usuarios sin fecha de admisión válida: CORREGIR en tabla users.\n";
}

if ($reasons['sin_usuario'] > 0) {
    echo "⚠ " . $reasons['sin_usuario'] . " períodos huérfanos (usuario no existe): LIMPIAR base de datos.\n";
}

if ($reasons['actualizado_hoy'] > 0) {
    echo "⚠ " . $reasons['actualizado_hoy'] . " períodos actualizados hoy pero con NULL: INVESTIGAR posible error en comando.\n";
}

if ($reasons['otros'] > 0) {
    echo "🔴 " . $reasons['otros'] . " períodos SIN MOTIVO OBVIO: DEBERÍAN haberse actualizado. REVISAR.\n";
}

echo "\n";

// Períodos que DEBERÍAN actualizarse
$shouldBeUpdated = VacationsAvailable::whereNull('days_calculated')
    ->where('is_historical', false)
    ->whereHas('user', function($q) use ($today) {
        $q->where('active', 1)
          ->whereNotNull('admission')
          ->where('admission', '>=', '1900-01-01')
          ->whereRaw('TIMESTAMPDIFF(YEAR, admission, ?) >= 1', [$today->format('Y-m-d')]);
    })
    ->whereRaw('? BETWEEN date_start AND date_end', [$today->format('Y-m-d')])
    ->with('user')
    ->get();

if ($shouldBeUpdated->count() > 0) {
    echo "==============================\n";
    echo "⚠ PERÍODOS QUE DEBERÍAN ACTUALIZARSE:\n";
    echo "==============================\n\n";
    echo "Total: " . $shouldBeUpdated->count() . " períodos\n\n";
    
    foreach ($shouldBeUpdated->take(10) as $period) {
        $user = $period->user;
        echo sprintf(
            "- %s (ID: %d) | Período %d | %s a %s | Admisión: %s\n",
            $user->first_name . ' ' . $user->last_name,
            $user->id,
            $period->period,
            Carbon::parse($period->date_start)->format('d-m-Y'),
            Carbon::parse($period->date_end)->format('d-m-Y'),
            Carbon::parse($user->admission)->format('d-m-Y')
        );
    }
    
    if ($shouldBeUpdated->count() > 10) {
        echo "\n... y " . ($shouldBeUpdated->count() - 10) . " más.\n";
    }
    
    echo "\n";
    echo "SOLUCIÓN: Ejecutar el comando con --force:\n";
    echo "  php artisan vacations:update-accrual --all --force\n\n";
}

echo "Diagnóstico completado.\n";

<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;
use Carbon\Carbon;

echo "=== Test de Coincidencia de Períodos con Fechas Diferentes ===\n\n";

// Obtener un usuario de prueba
$user = User::where('active', 1)->first();

if (!$user) {
    echo "❌ No se encontraron usuarios activos en la base de datos.\n";
    exit(1);
}

echo "Usuario de prueba:\n";
echo "  - Nombre: {$user->first_name} {$user->last_name}\n";
echo "  - ID: {$user->id}\n\n";

// Obtener período existente
$existingPeriod = VacationsAvailable::where('users_id', $user->id)
    ->where('is_historical', false)
    ->orderBy('date_start', 'desc')
    ->first();

if (!$existingPeriod) {
    echo "❌ El usuario no tiene períodos de vacaciones. Creando uno de prueba...\n";
    
    $existingPeriod = VacationsAvailable::create([
        'users_id' => $user->id,
        'period' => 1,
        'date_start' => '2024-01-15',
        'date_end' => '2025-01-15',
        'days_availables' => 12,
        'dv' => 0,
        'days_enjoyed' => 5,
        'days_reserved' => 0,
        'status' => 'actual',
        'is_historical' => false,
    ]);
    
    echo "✅ Período de prueba creado.\n\n";
}

echo "Período existente en DB:\n";
echo "  - Período #: {$existingPeriod->period}\n";
echo "  - Fecha Inicio: {$existingPeriod->date_start}\n";
echo "  - Fecha Fin: {$existingPeriod->date_end}\n";
echo "  - Días Disponibles: {$existingPeriod->days_availables}\n";
echo "  - Días Disfrutados: {$existingPeriod->days_enjoyed}\n\n";

// Simular el método de búsqueda mejorado
function findPeriod($userId, $dateStart)
{
    $dateStartFormatted = Carbon::parse($dateStart)->format('Y-m-d');
    
    // 1. Buscar por fecha exacta
    $period = VacationsAvailable::where('users_id', $userId)
        ->where('date_start', $dateStartFormatted)
        ->where('is_historical', false)
        ->first();
    
    if ($period) {
        return ['period' => $period, 'method' => 'Fecha exacta'];
    }
    
    // 2. Buscar por número de período
    // Calcular número de período basado en períodos anteriores
    $existingPeriodsCount = VacationsAvailable::where('users_id', $userId)
        ->where('is_historical', false)
        ->where('date_start', '<', $dateStartFormatted)
        ->count();
    
    $periodNumber = $existingPeriodsCount + 1;
    
    $period = VacationsAvailable::where('users_id', $userId)
        ->where('period', $periodNumber)
        ->where('is_historical', false)
        ->first();
    
    if ($period) {
        return ['period' => $period, 'method' => 'Número de período'];
    }
    
    // 3. Buscar por rango de fechas (±30 días)
    $dateStartObj = Carbon::parse($dateStart);
    $dateStartMinus = $dateStartObj->copy()->subDays(30)->format('Y-m-d');
    $dateStartPlus = $dateStartObj->copy()->addDays(30)->format('Y-m-d');
    
    $period = VacationsAvailable::where('users_id', $userId)
        ->whereBetween('date_start', [$dateStartMinus, $dateStartPlus])
        ->where('is_historical', false)
        ->orderByRaw('ABS(DATEDIFF(date_start, ?))', [$dateStartFormatted])
        ->first();
    
    if ($period) {
        $diffDays = abs(Carbon::parse($period->date_start)->diffInDays($dateStartObj));
        return ['period' => $period, 'method' => "Rango cercano (±{$diffDays} días)"];
    }
    
    return null;
}

// Casos de prueba
$testCases = [
    [
        'descripcion' => 'Fecha EXACTA (debe encontrar)',
        'fecha' => $existingPeriod->date_start,
        'esperado' => 'Encontrar',
    ],
    [
        'descripcion' => 'Fecha +5 días (debe encontrar por rango)',
        'fecha' => Carbon::parse($existingPeriod->date_start)->addDays(5)->format('Y-m-d'),
        'esperado' => 'Encontrar',
    ],
    [
        'descripcion' => 'Fecha -5 días (debe encontrar por rango)',
        'fecha' => Carbon::parse($existingPeriod->date_start)->subDays(5)->format('Y-m-d'),
        'esperado' => 'Encontrar',
    ],
    [
        'descripcion' => 'Fecha +15 días (debe encontrar por rango)',
        'fecha' => Carbon::parse($existingPeriod->date_start)->addDays(15)->format('Y-m-d'),
        'esperado' => 'Encontrar',
    ],
    [
        'descripcion' => 'Fecha +29 días (límite del rango)',
        'fecha' => Carbon::parse($existingPeriod->date_start)->addDays(29)->format('Y-m-d'),
        'esperado' => 'Encontrar',
    ],
    [
        'descripcion' => 'Fecha +45 días (fuera de rango)',
        'fecha' => Carbon::parse($existingPeriod->date_start)->addDays(45)->format('Y-m-d'),
        'esperado' => 'No Encontrar',
    ],
    [
        'descripcion' => 'Fecha completamente diferente (1 año después)',
        'fecha' => Carbon::parse($existingPeriod->date_start)->addYear()->format('Y-m-d'),
        'esperado' => 'No Encontrar',
    ],
];

echo "=== Probando estrategia de búsqueda ===\n\n";

$passed = 0;
$failed = 0;

foreach ($testCases as $test) {
    $result = findPeriod($user->id, $test['fecha']);
    
    $encontrado = $result !== null;
    $esperabaEncontrar = $test['esperado'] === 'Encontrar';
    
    if ($encontrado === $esperabaEncontrar) {
        $status = '✅';
        $passed++;
    } else {
        $status = '❌';
        $failed++;
    }
    
    echo sprintf(
        "%s %s\n",
        $status,
        $test['descripcion']
    );
    echo sprintf(
        "   Fecha buscada: %s\n",
        $test['fecha']
    );
    
    if ($encontrado) {
        echo sprintf(
            "   ✓ Encontrado: Período #%d (Fecha DB: %s)\n",
            $result['period']->period,
            $result['period']->date_start
        );
        echo sprintf(
            "   ✓ Método: %s\n",
            $result['method']
        );
    } else {
        echo "   ✗ No encontrado (se crearía nuevo período)\n";
    }
    echo "\n";
}

echo "=== Resumen ===\n";
echo "Total: " . ($passed + $failed) . "\n";
echo "✅ Correctos: $passed\n";
echo "❌ Fallidos: $failed\n";

if ($failed === 0) {
    echo "\n🎉 La estrategia de búsqueda funciona correctamente!\n";
} else {
    echo "\n⚠️  Algunos casos fallaron, revisar lógica.\n";
}

echo "\n=== Escenarios de Uso ===\n";
echo "1. Usuario exporta datos → Modifica fecha en Excel por error de 2-3 días → Reimporta\n";
echo "   → Sistema encuentra el período por RANGO y actualiza ✅\n\n";

echo "2. Usuario exporta datos → Modifica fecha significativamente (>30 días) → Reimporta\n";
echo "   → Sistema NO encuentra período → Crea NUEVO período ⚠️\n\n";

echo "3. Usuario importa con fecha exacta de DB\n";
echo "   → Sistema encuentra por FECHA EXACTA → Actualiza ✅\n\n";

echo "4. Usuario importa nuevo empleado con fecha nueva\n";
echo "   → Sistema NO encuentra nada → Crea período ✅\n";

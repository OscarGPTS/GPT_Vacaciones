<?php

/**
 * Script de prueba para el nuevo sistema de importación de vacaciones
 * 
 * Prueba:
 * - Identificación automática por nombre
 * - Cálculo automático de status
 * - Creación de plantilla con formato legible
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

echo "\n===== PRUEBA DE NUEVO SISTEMA DE IMPORTACIÓN =====\n\n";

// 1. Prueba de identificación de usuarios
echo "1. Prueba de identificación de usuarios por nombre:\n";

$testNames = [
    'GARCÍA LÓPEZ JUAN',
    'MARTÍNEZ PÉREZ MARÍA',
    'LÓPEZ GARCÍA CARLOS',
    'NOMBRE INEXISTENTE',
];

foreach ($testNames as $nombre) {
    // Coincidencia exacta: APELLIDO NOMBRE
    $user = User::whereRaw("CONCAT(TRIM(last_name), ' ', TRIM(first_name)) = ?", [$nombre])
        ->where('active', 1)
        ->first();
    
    if (!$user) {
        // Coincidencia invertida: NOMBRE APELLIDO
        $parts = explode(' ', $nombre, 2);
        if (count($parts) === 2) {
            $user = User::whereRaw("CONCAT(TRIM(first_name), ' ', TRIM(last_name)) = ?", [$nombre])
                ->where('active', 1)
                ->first();
        }
    }
    
    if ($user) {
        echo "   ✓ '{$nombre}' → Usuario ID: {$user->id} ({$user->last_name} {$user->first_name})\n";
    } else {
        echo "   ✗ '{$nombre}' → No identificado\n";
    }
}
echo "\n";

// 2. Prueba de cálculo automático de status
echo "2. Prueba de cálculo automático de status:\n";

$testDates = [
    '2024-11-01' => 'actual (< 15 meses)',
    '2023-08-01' => 'vencido (15 meses exactos)',
    '2023-01-01' => 'vencido (> 15 meses)',
    '2024-01-01' => 'actual (11 meses)',
];

foreach ($testDates as $fechaIngreso => $expectedResult) {
    $fechaLimite = Carbon::parse($fechaIngreso)->addMonths(15);
    $status = Carbon::now()->greaterThan($fechaLimite) ? 'vencido' : 'actual';
    
    $mesesTranscurridos = Carbon::parse($fechaIngreso)->diffInMonths(Carbon::now());
    
    echo "   Fecha Ingreso: {$fechaIngreso} ({$mesesTranscurridos} meses) → Status: '{$status}' - {$expectedResult}\n";
}
echo "\n";

// 3. Prueba de cálculo de número de período
echo "3. Prueba de cálculo de número de período:\n";

// Buscar un usuario con múltiples períodos
$userWithPeriods = User::whereHas('vacationsAvailable', function($query) {
    $query->where('is_historical', false);
}, '>=', 2)
->with(['vacationsAvailable' => function($query) {
    $query->where('is_historical', false)->orderBy('date_start');
}])
->first();

if ($userWithPeriods) {
    echo "   Usuario: {$userWithPeriods->last_name} {$userWithPeriods->first_name} (ID: {$userWithPeriods->id})\n";
    echo "   Períodos existentes:\n";
    
    foreach ($userWithPeriods->vacationsAvailable as $period) {
        echo "     - Período {$period->period}: {$period->date_start} a {$period->date_end}\n";
    }
    
    // Simular cálculo para un nuevo período (año real de antigüedad)
    $newDateStart = Carbon::parse($userWithPeriods->vacationsAvailable->last()->date_end)->copy();
    $newPeriodNumber = null;

    if (!empty($userWithPeriods->admission) && $userWithPeriods->admission !== '0000-00-00' && $userWithPeriods->admission !== '0000-00-00 00:00:00') {
        $admissionDate = Carbon::parse($userWithPeriods->admission);
        $newPeriodNumber = max(1, $newDateStart->diffInYears($admissionDate) + 1);
    }
    
    echo "   Si se agregara un período con fecha {$newDateStart->format('Y-m-d')}:\n";
    echo "     → Año de período calculado: " . ($newPeriodNumber ?? 'N/D') . "\n";
} else {
    echo "   ⚠ No se encontraron usuarios con múltiples períodos para prueba\n";
}
echo "\n";

// 4. Prueba de formato de plantilla
echo "4. Generación de plantilla con formato legible:\n";

$sampleData = [
    [
        'Nombre Completo' => 'GARCÍA LÓPEZ JUAN',
        'Fecha Ingreso' => '2024-08-08',
        'Fecha Aniversario' => '2025-08-08',
        'Dias Disponibles' => 12.00,
        'Dias Disfrutados' => 5.00,
    ],
    [
        'Nombre Completo' => 'MARTÍNEZ PÉREZ MARÍA',
        'Fecha Ingreso' => '2023-01-15',
        'Fecha Aniversario' => '2024-01-15',
        'Dias Disponibles' => 14.00,
        'Dias Disfrutados' => 8.00,
    ],
];

echo "   Ejemplo de datos para plantilla:\n";
foreach ($sampleData as $index => $row) {
    echo "   Fila " . ($index + 2) . ":\n";
    foreach ($row as $key => $value) {
        echo "     - {$key}: {$value}\n";
    }
}
echo "\n";

// 5. Prueba de parseo de fechas
echo "5. Prueba de parseo de diferentes formatos de fecha:\n";

$dateFormats = [
    '2024-08-08' => 'ISO 8601',
    '08/08/2024' => 'DD/MM/YYYY',
    '08-08-2024' => 'DD-MM-YYYY',
];

foreach ($dateFormats as $dateString => $format) {
    try {
        $parsed = Carbon::parse($dateString)->format('Y-m-d');
        echo "   ✓ '{$dateString}' ({$format}) → {$parsed}\n";
    } catch (\Exception $e) {
        echo "   ✗ '{$dateString}' ({$format}) → Error: {$e->getMessage()}\n";
    }
}
echo "\n";

// 6. Estadísticas del sistema actual
echo "6. Estadísticas del sistema actual:\n";

$totalUsers = User::where('active', 1)->count();
$usersWithPeriods = User::whereHas('vacationsAvailable', function($query) {
    $query->where('is_historical', false);
})->count();
$usersWithoutPeriods = $totalUsers - $usersWithPeriods;

$totalPeriods = VacationsAvailable::where('is_historical', false)->count();
$actualPeriods = VacationsAvailable::where('is_historical', false)
    ->where('status', 'actual')
    ->count();
$vencidoPeriods = VacationsAvailable::where('is_historical', false)
    ->where('status', 'vencido')
    ->count();

echo "   Total empleados activos: {$totalUsers}\n";
echo "   Empleados con períodos: {$usersWithPeriods}\n";
echo "   Empleados sin períodos: {$usersWithoutPeriods}\n";
echo "   Total períodos no históricos: {$totalPeriods}\n";
echo "   Períodos actuales: {$actualPeriods}\n";
echo "   Períodos vencidos: {$vencidoPeriods}\n";
echo "\n";

echo "===== FIN DE PRUEBA =====\n";

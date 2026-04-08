<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;
use App\Models\RequestVacations;
use App\Models\RequestApproved;
use Carbon\Carbon;

echo "========================================\n";
echo "PRUEBA: DESCUENTO DE days_calculated Y days_availables\n";
echo "========================================\n\n";

// Buscar un período con ambos valores
$periodo = VacationsAvailable::where('is_historical', 0)
    ->whereNotNull('days_calculated')
    ->whereNotNull('days_availables')
    ->whereRaw('COALESCE(days_calculated, days_availables) - days_enjoyed - days_reserved >= 5')
    ->where('date_end', '>=', now()->addMonths(1))
    ->first();

if (!$periodo) {
    echo "❌ No se encontró un período con saldo suficiente y ambos campos\n";
    exit;
}

$user = User::find($periodo->users_id);

echo "=== USUARIO Y PERÍODO SELECCIONADO ===\n";
echo "Usuario: {$user->first_name} {$user->last_name} (ID: {$user->id})\n";
echo "Período: {$periodo->period}\n";
echo "Fechas: {$periodo->date_start} → {$periodo->date_end}\n\n";

echo "=== ESTADO INICIAL ===\n";
echo "days_availables: {$periodo->days_availables}\n";
echo "days_calculated: {$periodo->days_calculated}\n";
echo "days_enjoyed: {$periodo->days_enjoyed}\n";
echo "days_reserved: {$periodo->days_reserved}\n";

// Guardar valores iniciales RAW (no calculados como saldo)
$inicialAvail = $periodo->days_availables;
$inicialCalc = $periodo->days_calculated;
$inicialEnjoyed = $periodo->days_enjoyed;

$saldoInicialCalc = $periodo->days_calculated - $periodo->days_enjoyed - $periodo->days_reserved;
$saldoInicialAvail = $periodo->days_availables - $periodo->days_enjoyed - $periodo->days_reserved;
echo "SALDO (calculated): {$saldoInicialCalc} días\n";
echo "SALDO (availables): {$saldoInicialAvail} días\n\n";

// Crear solicitud de prueba
$aniversario = Carbon::parse($periodo->date_end);
$diasAntes = [
    $aniversario->copy()->subDays(10)->format('Y-m-d'),
    $aniversario->copy()->subDays(9)->format('Y-m-d'),
];
$diasDespues = [
    $aniversario->copy()->addDays(1)->format('Y-m-d'),
];

echo "=== CREANDO SOLICITUD DE PRUEBA ===\n";
echo "Días a solicitar: 3\n";
echo "  - 2 días ANTES del aniversario: " . implode(', ', $diasAntes) . "\n";
echo "  - 1 día DESPUÉS del aniversario: " . implode(', ', $diasDespues) . "\n\n";

$request = RequestVacations::create([
    'user_id' => $user->id,
    'type_request' => 'Vacaciones',
    'payment' => 'A cuenta de vacaciones',
    'reason' => 'TEST: Validación descuento days_calculated y days_availables',
    'opcion' => "{$periodo->period}|{$periodo->date_start}",
    'direct_manager_id' => $user->boss_id ?? 1,
    'direct_manager_status' => 'Aprobada',
    'direction_approbation_id' => 1,
    'direction_approbation_status' => 'Aprobada',
    'human_resources_status' => 'Pendiente',
]);

foreach ($diasAntes as $fecha) {
    RequestApproved::create([
        'requests_id' => $request->id,
        'users_id' => $user->id,
        'start' => $fecha,
        'end' => $fecha,
        'title' => 'Vacaciones',
    ]);
}

foreach ($diasDespues as $fecha) {
    RequestApproved::create([
        'requests_id' => $request->id,
        'users_id' => $user->id,
        'start' => $fecha,
        'end' => $fecha,
        'title' => 'Vacaciones',
    ]);
}

echo "✅ Solicitud creada: ID {$request->id}\n";
echo "✅ 3 días individuales creados\n\n";

// Reservar días
$periodo->update(['days_reserved' => $periodo->days_reserved + 3]);
echo "✅ Días reservados\n\n";

echo "=== ESTADO ANTES DE APROBACIÓN RH ===\n";
$periodo = $periodo->fresh();
echo "days_availables: {$periodo->days_availables}\n";
echo "days_calculated: {$periodo->days_calculated}\n";
echo "days_enjoyed: {$periodo->days_enjoyed}\n";
echo "days_reserved: {$periodo->days_reserved}\n\n";

// SIMULAR APROBACIÓN RH con la lógica actualizada
echo "=== SIMULANDO APROBACIÓN RH (LÓGICA ACTUALIZADA) ===\n";

$request = RequestVacations::with('requestDays')->find($request->id);
$diasSolicitados = $request->requestDays->count();

// Clasificar días
$fechasIndividuales = $request->requestDays->pluck('start');
$diasAntesAniversario = 0;
$diasDespuesAniversario = 0;
$fechaAniversarioCalculo = Carbon::parse($periodo->date_end);

foreach ($fechasIndividuales as $fecha) {
    $fechaDia = Carbon::parse($fecha);
    if ($fechaDia->lte($fechaAniversarioCalculo)) {
        $diasAntesAniversario++;
    } else {
        $diasDespuesAniversario++;
    }
}

echo "Clasificación: {$diasAntesAniversario} antes, {$diasDespuesAniversario} después\n";
echo "Total días a aprobar: {$diasSolicitados}\n\n";

// APLICAR LÓGICA ACTUALIZADA: Descontar de AMBOS campos
$periodo->update([
    'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados),
    'days_enjoyed' => $periodo->days_enjoyed + $diasSolicitados,
    'days_enjoyed_before_anniversary' => $periodo->days_enjoyed_before_anniversary + $diasAntesAniversario,
    'days_enjoyed_after_anniversary' => $periodo->days_enjoyed_after_anniversary + $diasDespuesAniversario,
    // NUEVO: Descontar de days_calculated
    'days_calculated' => max(0, ($periodo->days_calculated ?? 0) - $diasSolicitados),
    // NUEVO: Descontar de days_availables
    'days_availables' => max(0, $periodo->days_availables - $diasSolicitados),
]);

$request->update([
    'human_resources_status' => 'Aprobada',
    'human_resources_date' => now(),
]);

echo "✅ Período actualizado\n";
echo "✅ Solicitud aprobada\n\n";

// VERIFICAR RESULTADO
echo "=== ESTADO DESPUÉS DE APROBACIÓN RH ===\n";
$periodo = $periodo->fresh();
echo "days_availables: {$periodo->days_availables}\n";
echo "days_calculated: {$periodo->days_calculated}\n";
echo "days_enjoyed: {$periodo->days_enjoyed}\n";
echo "days_reserved: {$periodo->days_reserved}\n";
echo "days_enjoyed_before_anniversary: {$periodo->days_enjoyed_before_anniversary}\n";
echo "days_enjoyed_after_anniversary: {$periodo->days_enjoyed_after_anniversary}\n\n";

$saldoFinalCalc = $periodo->days_calculated - $periodo->days_enjoyed - $periodo->days_reserved;
$saldoFinalAvail = $periodo->days_availables - $periodo->days_enjoyed - $periodo->days_reserved;
echo "SALDO (calculated): {$saldoFinalCalc} días\n";
echo "SALDO (availables): {$saldoFinalAvail} días\n\n";

// VALIDACIONES
echo "=== VALIDACIONES ===\n";

// Verificar descuento en campos RAW
$expectedCalc = $inicialCalc - $diasSolicitados;
$expectedAvail = $inicialAvail - $diasSolicitados;$expectedEnjoyed = $inicialEnjoyed + $diasSolicitados;

echo "✓ days_calculated descontado: esperado {$expectedCalc}, actual {$periodo->days_calculated} - " . 
    (abs($periodo->days_calculated - $expectedCalc) < 0.01 ? "✅ PASS" : "❌ FAIL") . "\n";
    
echo "✓ days_availables descontado: esperado {$expectedAvail}, actual {$periodo->days_availables} - " . 
    (abs($periodo->days_availables - $expectedAvail) < 0.01 ? "✅ PASS" : "❌ FAIL") . "\n";
    
echo "✓ days_enjoyed aumentado: esperado {$expectedEnjoyed}, actual {$periodo->days_enjoyed} - " . 
    ($periodo->days_enjoyed == $expectedEnjoyed ? "✅ PASS" : "❌ FAIL") . "\n";
    
echo "✓ days_reserved liberado (= 0): " . ($periodo->days_reserved == 0 ? "✅ PASS" : "❌ FAIL") . "\n";
echo "✓ Suma before+after correcta: " . (($periodo->days_enjoyed_before_anniversary + $periodo->days_enjoyed_after_anniversary) == $periodo->days_enjoyed ? "✅ PASS" : "❌ FAIL") . "\n\n";

// FÓRMULA DE SALDO
echo "=== FÓRMULA DE SALDO (NUEVA) ===\n";
$baseDisponible = $periodo->days_calculated ?? $periodo->days_availables;
$saldoNuevo = $baseDisponible - $periodo->days_enjoyed - $periodo->days_reserved;
echo "Base disponible (days_calculated ?? days_availables): {$baseDisponible}\n";
echo "Saldo = {$baseDisponible} - {$periodo->days_enjoyed} - {$periodo->days_reserved} = {$saldoNuevo} días\n\n";

echo "========================================\n";
echo "RESUMEN\n";
echo "========================================\n";
echo "Solicitud: ID {$request->id}\n";
echo "Días aprobados: {$diasSolicitados}\n";
echo "Cambio en days_calculated: {$inicialCalc} → {$periodo->days_calculated} (diferencia: " . ($inicialCalc - $periodo->days_calculated) . ")\n";
echo "Cambio en days_availables: {$inicialAvail} → {$periodo->days_availables} (diferencia: " . ($inicialAvail - $periodo->days_availables) . ")\n";
echo "Saldo final: {$saldoNuevo} días\n\n";

$pasaCalc = abs($periodo->days_calculated - $expectedCalc) < 0.01;
$pasaAvail = abs($periodo->days_availables - $expectedAvail) < 0.01;
$pasaEnjoyed = $periodo->days_enjoyed == $expectedEnjoyed;

if ($pasaCalc && $pasaAvail && $pasaEnjoyed) {
    echo "🎉 TODAS LAS VALIDACIONES PASARON ✅\n";
    echo "Los días se descuentan correctamente de AMBOS campos\n";
} else {
    echo "⚠️  ALGUNAS VALIDACIONES FALLARON ❌\n";
}

echo "========================================\n";

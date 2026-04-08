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
echo "PRUEBA DE APROBACIÓN DE VACACIONES\n";
echo "Validación de campos before/after anniversary\n";
echo "========================================\n\n";

// 1. Buscar un usuario con períodos activos
$user = User::where('active', 1)
    ->whereHas('vacationsAvailable', function($q) {
        $q->where('is_historical', 0);
    })
    ->with(['job', 'vacationsAvailable' => function($q) {
        $q->where('is_historical', 0)->orderBy('period');
    }])
    ->first();

if (!$user) {
    echo "❌ No se encontró usuario con períodos activos\n";
    exit;
}

echo "=== USUARIO SELECCIONADO ===\n";
echo "ID: {$user->id}\n";
echo "Nombre: {$user->first_name} {$user->last_name}\n";
echo "Depto: " . ($user->job->depto_id ?? 'N/A') . "\n\n";

echo "=== PERÍODOS DISPONIBLES ===\n";
$selectedPeriod = null;
foreach ($user->vacationsAvailable as $p) {
    $saldo = $p->days_availables - $p->days_enjoyed - $p->days_reserved;
    echo "Período {$p->period}: {$p->date_start} → {$p->date_end}\n";
    echo "  Disponibles: {$p->days_availables}\n";
    echo "  Disfrutados: {$p->days_enjoyed}\n";
    echo "    Before anniversary: {$p->days_enjoyed_before_anniversary}\n";
    echo "    After anniversary: {$p->days_enjoyed_after_anniversary}\n";
    echo "  Reservados: {$p->days_reserved}\n";
    echo "  SALDO VISUAL: {$saldo} días\n\n";
    
    // Buscar período con saldo > 0 para prueba
    if ($saldo >= 5 && !$selectedPeriod) {
        $selectedPeriod = $p;
    }
}

if (!$selectedPeriod) {
    echo "❌ No hay períodos con saldo suficiente para pruebas\n";
    exit;
}

echo "\n=== PERÍODO SELECCIONADO PARA PRUEBA ===\n";
echo "Período {$selectedPeriod->period}\n";
echo "Aniversario (date_end): {$selectedPeriod->date_end}\n";
$saldoInicial = $selectedPeriod->days_availables - $selectedPeriod->days_enjoyed - $selectedPeriod->days_reserved;
echo "Saldo inicial: {$saldoInicial} días\n\n";

// 2. Crear solicitud de prueba con días antes y después del aniversario
echo "=== CREANDO SOLICITUD DE PRUEBA ===\n";

$fechaAniversario = Carbon::parse($selectedPeriod->date_end);
$hoy = Carbon::now();

// Determinar fechas para la prueba
// Si hoy < aniversario - 30 días, usar días cercanos al aniversario
// Si no, usar fechas futuras simuladas
if ($hoy->lessThan($fechaAniversario->copy()->subDays(30))) {
    // Caso ideal: estamos lejos del aniversario
    $diasAntes = [
        $fechaAniversario->copy()->subDays(10)->format('Y-m-d'),
        $fechaAniversario->copy()->subDays(9)->format('Y-m-d'),
        $fechaAniversario->copy()->subDays(8)->format('Y-m-d'),
    ];
    $diasDespues = [
        $fechaAniversario->copy()->addDays(1)->format('Y-m-d'),
        $fechaAniversario->copy()->addDays(2)->format('Y-m-d'),
    ];
} else {
    // Usar fechas del próximo período (simulado)
    echo "ℹ️  Usando fechas simuladas (período actual muy avanzado)\n";
    $fechaSimulada = Carbon::parse($selectedPeriod->date_end)->addYear();
    $diasAntes = [
        $fechaSimulada->copy()->subDays(10)->format('Y-m-d'),
        $fechaSimulada->copy()->subDays(9)->format('Y-m-d'),
        $fechaSimulada->copy()->subDays(8)->format('Y-m-d'),
    ];
    $diasDespues = [
        $fechaSimulada->copy()->addDays(1)->format('Y-m-d'),
        $fechaSimulada->copy()->addDays(2)->format('Y-m-d'),
    ];
}

echo "Días ANTES del aniversario ({$selectedPeriod->date_end}):\n";
foreach ($diasAntes as $d) {
    echo "  - {$d}\n";
}
echo "Días DESPUÉS del aniversario:\n";
foreach ($diasDespues as $d) {
    echo "  - {$d}\n";
}
echo "\n";

// Crear la solicitud
$request = RequestVacations::create([
    'user_id' => $user->id,
    'type_request' => 'Vacaciones',
    'payment' => 'A cuenta de vacaciones',
    'reason' => 'Prueba de validación before/after anniversary',
    'opcion' => "{$selectedPeriod->period}|{$selectedPeriod->date_start}",
    'direct_manager_id' => $user->boss_id ?? 1,
    'direct_manager_status' => 'Aprobada',
    'direction_approbation_id' => 1, // Usuario admin
    'direction_approbation_status' => 'Aprobada',
    'human_resources_status' => 'Pendiente',
]);

echo "✅ Solicitud creada: ID {$request->id}\n";

// Crear días individuales
$totalDias = 0;
foreach (array_merge($diasAntes, $diasDespues) as $fecha) {
    RequestApproved::create([
        'requests_id' => $request->id,
        'users_id' => $user->id,
        'start' => $fecha,
        'end' => $fecha,
        'title' => 'Vacaciones - TEST',
    ]);
    $totalDias++;
}

echo "✅ Días individuales creados: {$totalDias}\n\n";

// Reservar días
$selectedPeriod->update([
    'days_reserved' => $selectedPeriod->days_reserved + $totalDias
]);

$saldoDespuesReserva = $selectedPeriod->days_availables - $selectedPeriod->days_enjoyed - $selectedPeriod->fresh()->days_reserved;
echo "✅ Días reservados en período {$selectedPeriod->period}\n";
echo "   Saldo después de reserva: {$saldoDespuesReserva} días\n\n";

echo "=== ESTADO ANTES DE APROBACIÓN RH ===\n";
$periodoPreAprobacion = VacationsAvailable::find($selectedPeriod->id);
echo "days_enjoyed: {$periodoPreAprobacion->days_enjoyed}\n";
echo "days_enjoyed_before_anniversary: {$periodoPreAprobacion->days_enjoyed_before_anniversary}\n";
echo "days_enjoyed_after_anniversary: {$periodoPreAprobacion->days_enjoyed_after_anniversary}\n";
echo "days_reserved: {$periodoPreAprobacion->days_reserved}\n";
$saldoPreAprobar = $periodoPreAprobacion->days_availables - $periodoPreAprobacion->days_enjoyed - $periodoPreAprobacion->days_reserved;
echo "SALDO VISUAL: {$saldoPreAprobar} días\n\n";

// 3. Simular aprobación RH (lógica del componente VacacionesRh)
echo "=== SIMULANDO APROBACIÓN RH ===\n";

$requestToApprove = RequestVacations::with('requestDays')->find($request->id);
$diasSolicitados = $requestToApprove->requestDays->count();

echo "Días a aprobar: {$diasSolicitados}\n";

// LÓGICA DE SEPARACIÓN (igual a VacacionesRh.php)
$fechasIndividuales = $requestToApprove->requestDays->pluck('start');
$diasAntesAniversario = 0;
$diasDespuesAniversario = 0;
$fechaAniversarioCalculo = Carbon::parse($periodoPreAprobacion->date_end);

foreach ($fechasIndividuales as $fecha) {
    $fechaDia = Carbon::parse($fecha);
    
    if ($fechaDia->lte($fechaAniversarioCalculo)) {
        $diasAntesAniversario++;
    } else {
        $diasDespuesAniversario++;
    }
}

echo "Clasificación:\n";
echo "  Antes del aniversario: {$diasAntesAniversario} días\n";
echo "  Después del aniversario: {$diasDespuesAniversario} días\n";
echo "  Total: " . ($diasAntesAniversario + $diasDespuesAniversario) . " días\n\n";

// Actualizar período
$periodoPreAprobacion->update([
    'days_reserved' => max(0, $periodoPreAprobacion->days_reserved - $diasSolicitados),
    'days_enjoyed' => $periodoPreAprobacion->days_enjoyed + $diasSolicitados,
    'days_enjoyed_before_anniversary' => $periodoPreAprobacion->days_enjoyed_before_anniversary + $diasAntesAniversario,
    'days_enjoyed_after_anniversary' => $periodoPreAprobacion->days_enjoyed_after_anniversary + $diasDespuesAniversario
]);

// Actualizar solicitud
$requestToApprove->update([
    'human_resources_status' => 'Aprobada',
    'human_resources_date' => now(),
]);

echo "✅ Período actualizado\n";
echo "✅ Solicitud aprobada\n\n";

// 4. VERIFICAR RESULTADO
echo "=== ESTADO DESPUÉS DE APROBACIÓN RH ===\n";
$periodoPostAprobacion = VacationsAvailable::find($selectedPeriod->id);
echo "days_enjoyed: {$periodoPostAprobacion->days_enjoyed}\n";
echo "days_enjoyed_before_anniversary: {$periodoPostAprobacion->days_enjoyed_before_anniversary}\n";
echo "days_enjoyed_after_anniversary: {$periodoPostAprobacion->days_enjoyed_after_anniversary}\n";
echo "days_reserved: {$periodoPostAprobacion->days_reserved}\n";
$saldoPostAprobar = $periodoPostAprobacion->days_availables - $periodoPostAprobacion->days_enjoyed - $periodoPostAprobacion->days_reserved;
echo "SALDO VISUAL: {$saldoPostAprobar} días\n\n";

// 5. VALIDACIONES
echo "=== VALIDACIONES ===\n";

$validacion1 = ($periodoPostAprobacion->days_enjoyed == 
                $periodoPostAprobacion->days_enjoyed_before_anniversary + 
                $periodoPostAprobacion->days_enjoyed_after_anniversary);
echo "✓ Suma correcta (enjoyed = before + after): " . ($validacion1 ? "✅ PASS" : "❌ FAIL") . "\n";

$validacion2 = ($periodoPostAprobacion->days_reserved == 0);
echo "✓ Reserva liberada (days_reserved = 0): " . ($validacion2 ? "✅ PASS" : "❌ FAIL") . "\n";

$cambioSaldo = $saldoPreAprobar - $saldoPostAprobar;
$validacion3 = ($cambioSaldo == $diasSolicitados);
echo "✓ Saldo visual correcto (cambio = {$cambioSaldo}, esperado = {$diasSolicitados}): " . ($validacion3 ? "✅ PASS" : "❌ FAIL") . "\n";

$validacion4 = ($diasAntesAniversario == count($diasAntes));
echo "✓ Días antes clasificados correctamente: " . ($validacion4 ? "✅ PASS" : "❌ FAIL") . "\n";

$validacion5 = ($diasDespuesAniversario == count($diasDespues));
echo "✓ Días después clasificados correctamente: " . ($validacion5 ? "✅ PASS" : "❌ FAIL") . "\n\n";

// 6. LIMPIEZA
echo "=== LIMPIEZA ===\n";
echo "¿Deseas eliminar los datos de prueba? (La solicitud ID {$request->id} quedará en la BD)\n";
echo "Ejecuta manualmente:\n";
echo "  RequestApproved::where('requests_id', {$request->id})->delete();\n";
echo "  RequestVacations::find({$request->id})->delete();\n";
echo "  // Y restaurar manualmente el período si es necesario\n\n";

echo "========================================\n";
echo "RESUMEN FINAL\n";
echo "========================================\n";
echo "Usuario: {$user->first_name} {$user->last_name}\n";
echo "Período: {$selectedPeriod->period}\n";
echo "Solicitud: {$request->id}\n";
echo "Días aprobados: {$diasSolicitados}\n";
echo "  - Antes aniversario: {$diasAntesAniversario}\n";
echo "  - Después aniversario: {$diasDespuesAniversario}\n";
echo "Saldo inicial: {$saldoInicial} días\n";
echo "Saldo final: {$saldoPostAprobar} días\n";
echo "\n";

if ($validacion1 && $validacion2 && $validacion3 && $validacion4 && $validacion5) {
    echo "🎉 TODAS LAS VALIDACIONES PASARON ✅\n";
} else {
    echo "⚠️  ALGUNAS VALIDACIONES FALLARON ❌\n";
}

echo "========================================\n";

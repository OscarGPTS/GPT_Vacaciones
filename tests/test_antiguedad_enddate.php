<?php
/**
 * TEST: VALIDAR CÁLCULO DE ANTIGÜEDAD CON END_DATE
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST: CÁLCULO DE ANTIGÜEDAD CON END_DATE                                ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

$currentYear = date('Y');

// Obtener primeros 10 usuarios
$employees = User::with(['job.departamento', 'jefe'])
    ->whereHas('job')
    ->where('active', 1)
    ->orderBy('id')
    ->limit(10)
    ->get();

echo "📊 COMPARACIÓN DE ANTIGÜEDADES:\n";
echo "════════════════════════════════════════════════════════════════════════════════════════\n\n";
echo str_pad("ID", 6);
echo str_pad("NOMBRE", 35);
echo str_pad("Admisión", 14);
echo str_pad("End Date", 14);
echo str_pad("Años (hoy)", 12);
echo str_pad("Años (period)", 14);
echo "\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";

foreach ($employees as $employee) {
    if (!$employee->admission) continue;
    
    $periods = VacationsAvailable::where('users_id', $employee->id)
        ->orderBy('date_end', 'desc')
        ->get();

    $periodoActual = $periods->filter(function($period) use ($currentYear) {
        $endYear = \Carbon\Carbon::parse($period->date_end)->year;
        return $endYear == $currentYear;
    })->first();
    
    // Si no hay período actual, usar el más reciente
    if (!$periodoActual && $periods->isNotEmpty()) {
        $periodoActual = $periods->first();
    }
    
    if (!$periodoActual) continue;
    
    $nombreCompleto = mb_strtoupper(trim($employee->last_name . ' ' . $employee->first_name), 'UTF-8');
    $admision = \Carbon\Carbon::parse($employee->admission);
    $endDate = \Carbon\Carbon::parse($periodoActual->date_end);
    $hoy = \Carbon\Carbon::now();
    
    // Antigüedad al día de hoy
    $antiguedadHoy = $admision->diffInYears($hoy);
    
    // Antigüedad al end_date del período
    $antiguedadPeriod = $admision->diffInYears($endDate);
    
    echo str_pad($employee->id, 6);
    echo str_pad(substr($nombreCompleto, 0, 33), 35);
    echo str_pad($admision->format('d-M-y'), 14);
    echo str_pad($endDate->format('d-M-y'), 14);
    echo str_pad($antiguedadHoy . ' años', 12);
    echo str_pad($antiguedadPeriod . ' años', 14);
    
    if ($antiguedadHoy != $antiguedadPeriod) {
        echo " ← DIFERENCIA";
    }
    
    echo "\n";
}

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                            ✅ VALIDACIÓN COMPLETA                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

echo "💡 EXPLICACIÓN:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "La antigüedad se calcula desde la fecha de admisión hasta el END_DATE del período.\n";
echo "Esto muestra los años que el empleado cumplirá en su aniversario (fecha del período).\n\n";

echo "Ejemplo:\n";
echo "  - Admisión: 25-May-2025\n";
echo "  - End Date Período: 25-May-2026\n";
echo "  - Hoy (31-Mar-2026): 0 años (aún no cumple el aniversario)\n";
echo "  - En Excel: 1 año (lo que cumplirá en 25-May-2026)\n\n";

echo "Fecha de validación: " . date('d/m/Y H:i:s') . "\n";

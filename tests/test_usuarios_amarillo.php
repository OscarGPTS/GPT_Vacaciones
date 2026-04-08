<?php
/**
 * TEST: MOSTRAR USUARIOS CON PERÍODO ALTERNATIVO (AMARILLO)
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           USUARIOS CON PERÍODO ALTERNATIVO (AMARILLO)                             ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

$currentYear = date('Y');

$employees = User::with(['job.departamento', 'jefe'])
    ->whereHas('job')
    ->where('active', 1)
    ->orderBy('id')
    ->get();

echo "Buscando usuarios sin período para el año {$currentYear}...\n\n";

$usuariosConAlternativo = [];

foreach ($employees as $employee) {
    $periods = VacationsAvailable::where('users_id', $employee->id)
        ->orderBy('date_end', 'desc')
        ->get();

    $periodoActual = $periods->filter(function($period) use ($currentYear) {
        $endYear = \Carbon\Carbon::parse($period->date_end)->year;
        return $endYear == $currentYear;
    })->first();
    
    // Si no hay período actual, usar el más reciente
    if (!$periodoActual && $periods->isNotEmpty()) {
        $periodoMasReciente = $periods->first();
        $nombreCompleto = mb_strtoupper(trim($employee->last_name . ' ' . $employee->first_name), 'UTF-8');
        
        $usuariosConAlternativo[] = [
            'id' => $employee->id,
            'nombre' => $nombreCompleto,
            'fecha_alternativa' => \Carbon\Carbon::parse($periodoMasReciente->date_end)->format('d-M-y'),
            'año_alternativo' => \Carbon\Carbon::parse($periodoMasReciente->date_end)->year,
            'dias_disponibles' => $periodoMasReciente->days_availables,
        ];
    }
}

if (count($usuariosConAlternativo) > 0) {
    echo "📋 USUARIOS QUE TENDRÁN FECHA EN AMARILLO:\n";
    echo "════════════════════════════════════════════════════════════════════════════════════════\n\n";
    echo str_pad("ID", 6) . str_pad("NOMBRE", 42) . str_pad("Fecha Usada", 15) . str_pad("Año", 8) . str_pad("Saldo", 10) . "\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    
    foreach ($usuariosConAlternativo as $usuario) {
        echo str_pad($usuario['id'], 6);
        echo str_pad(substr($usuario['nombre'], 0, 40), 42);
        echo str_pad($usuario['fecha_alternativa'], 15);
        echo str_pad($usuario['año_alternativo'], 8);
        echo str_pad(number_format($usuario['dias_disponibles'], 0), 10);
        echo "\n";
    }
    
    echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
    echo "║  Total: " . count($usuariosConAlternativo) . " usuarios con período alternativo (marcados en AMARILLO)         ║\n";
    echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";
    
    echo "💡 NOTA:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "Estos usuarios NO tienen un período que termine en {$currentYear}.\n";
    echo "Se usará su período más reciente disponible y se marcará en AMARILLO.\n";
    echo "Esto indica que necesitan actualización de períodos.\n\n";
} else {
    echo "✅ Todos los usuarios tienen período para {$currentYear}. No hay usuarios en amarillo.\n\n";
}

echo "Fecha de validación: " . date('d/m/Y H:i:s') . "\n";

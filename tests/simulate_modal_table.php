<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\VacationsAvailable;
use Carbon\Carbon;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "SIMULACIÓN: Vista del Modal con Datos\n";
echo "========================================\n\n";

// Obtener algunos períodos reales para simular
$today = Carbon::today();
$periods = VacationsAvailable::with(['user.job.departamento'])
    ->whereRaw('? BETWEEN date_start AND date_end', [$today->format('Y-m-d')])
    ->where('is_historical', false)
    ->limit(15)
    ->get();

echo "Simulando actualización de " . $periods->count() . " períodos...\n\n";

// Crear datos simulados de detalle
$simulatedDetails = [];
foreach ($periods as $period) {
    $user = $period->user;
    if (!$user) continue;
    
    $planta = 'N/D';
    if ($user->job && $user->job->departamento) {
        $planta =  $user->job->departamento->name ?? 'N/D';
    }
    
    // Simular valor anterior (un poco menos que el actual)
    $valorActual = $period->days_calculated ?? 0;
    $incrementoSimulado = rand(5, 50) / 100; // 0.05 a 0.50 días
    $valorAnterior = max(0, $valorActual - $incrementoSimulado);
    
    $simulatedDetails[] = [
        'planta' => $planta,
        'usuario' => trim($user->first_name . ' ' . $user->last_name),
        'periodo' => $period->period,
        'dias_anteriores' => $valorAnterior,
        'dias_actualizados' => $valorActual,
        'incremento' => $incrementoSimulado
    ];
}

if (empty($simulatedDetails)) {
    echo "No se encontraron períodos activos para simular.\n";
    exit(0);
}

echo "========================================\n";
echo "VISTA PREVIA DEL MODAL:\n";
echo "========================================\n\n";

echo "1. TARJETAS DE RESUMEN:\n\n";
echo "   ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐\n";
echo "   │   USUARIOS   │  │ ACTUALIZADOS │  │   OMITIDOS   │  │   VENCIDOS   │\n";
echo "   │  [azul 👥]   │  │ [verde ✓]    │  │ [amarillo ⏱]│  │  [rojo ✗]    │\n";
echo "   │      87      │  │      " . str_pad(count($simulatedDetails), 2, ' ', STR_PAD_LEFT) . "      │  │      0       │  │      0       │\n";
echo "   └──────────────┘  └──────────────┘  └──────────────┘  └──────────────┘\n\n";

echo "2. TABLA DETALLADA (con scroll):\n\n";

// Header de la tabla
$tableWidth = 110;
echo "   " . str_repeat("─", $tableWidth) . "\n";
echo sprintf("   │ %-3s │ %-20s │ %-25s │ %-7s │ %-12s │ %-12s │ %-10s │\n",
    "#",
    "Planta",
    "Usuario",
    "Período",
    "Anterior",
    "Actualizado",
    "Incremento"
);
echo "   " . str_repeat("─", $tableWidth) . "\n";

// Mostrar filas
foreach ($simulatedDetails as $index => $detail) {
    $planta = mb_substr($detail['planta'], 0, 20);
    $usuario = mb_substr($detail['usuario'], 0, 25);
    
    echo sprintf("   │ %-3d │ %-20s │ %-25s │ %-7d │ %12.2f │ %12.2f │ %10.2f │\n",
        $index + 1,
        $planta,
        $usuario,
        $detail['periodo'],
        $detail['dias_anteriores'],
        $detail['dias_actualizados'],
        $detail['incremento']
    );
}

echo "   " . str_repeat("─", $tableWidth) . "\n\n";

// Estadísticas
$totalIncremento = array_sum(array_column($simulatedDetails, 'incremento'));
$promedioIncremento = $totalIncremento / count($simulatedDetails);

echo "3. ESTADÍSTICAS:\n\n";
echo sprintf("   • Total días incrementados:   %.2f días\n", $totalIncremento);
echo sprintf("   • Promedio por período:       %.2f días\n", $promedioIncremento);
echo sprintf("   • Total registros:            %d\n", count($simulatedDetails));

// Agrupar por planta
$porPlanta = [];
foreach ($simulatedDetails as $detail) {
    $planta = $detail['planta'];
    if (!isset($porPlanta[$planta])) {
        $porPlanta[$planta] = [
            'count' => 0,
            'total_incremento' => 0
        ];
    }
    $porPlanta[$planta]['count']++;
    $porPlanta[$planta]['total_incremento'] += $detail['incremento'];
}

echo "\n4. DESGLOSE POR PLANTA:\n\n";
foreach ($porPlanta as $planta => $stats) {
    echo sprintf("   • %-30s %3d períodos  (+%.2f días)\n", 
        mb_substr($planta, 0, 30),
        $stats['count'], 
        $stats['total_incremento']
    );
}

echo "\n";
echo "========================================\n";
echo "CARACTERÍSTICAS DEL MODAL:\n";
echo "========================================\n\n";

echo "✓ Tabla responsiva con scroll vertical (máximo 400px)\n";
echo "✓ Headers sticky (se mantienen visibles al hacer scroll)\n";
echo "✓ Badges con colores:\n";
echo "  - Anterior: Badge amarillo (bg-warning)\n";
echo "  - Actualizado: Badge verde (bg-success)\n";
echo "  - Incremento: Badge azul (bg-primary) con ícono ↑\n";
echo "✓ Contador de registros en el título\n";
echo "✓ Solo muestra períodos con cambios > 0.01 días\n";
echo "✓ Datos en memoria (no se almacenan en BD)\n";
echo "✓ Se genera al ejecutar 'Actualizar Días Acumulados'\n\n";

echo "========================================\n";
echo "EJEMPLO DE ROW HTML:\n";
echo "========================================\n\n";

if (!empty($simulatedDetails)) {
    $d = $simulatedDetails[0];
    echo "<tr>\n";
    echo "  <td class=\"text-center\">1</td>\n";
    echo "  <td><small>{$d['planta']}</small></td>\n";
    echo "  <td><small>{$d['usuario']}</small></td>\n";
    echo "  <td class=\"text-center\"><span class=\"badge bg-secondary\">{$d['periodo']}</span></td>\n";
    echo "  <td class=\"text-end\"><span class=\"badge bg-warning text-dark\">" . number_format($d['dias_anteriores'], 2) . "</span></td>\n";
    echo "  <td class=\"text-end\"><span class=\"badge bg-success\">" . number_format($d['dias_actualizados'], 2) . "</span></td>\n";
    echo "  <td class=\"text-end\">\n";
    echo "    <span class=\"badge bg-primary\">\n";
    echo "      <i class=\"fas fa-arrow-up\"></i> " . number_format($d['incremento'], 2) . "\n";
    echo "    </span>\n";
    echo "  </td>\n";
    echo "</tr>\n";
}

echo "\n";
echo "Simulación completada.\n";
echo "\nPara ver el resultado REAL, ejecuta desde el navegador:\n";
echo "  Reporte de Vacaciones > Actualizar Días Acumulados > Ejecutar\n";

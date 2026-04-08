<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Services\VacationDailyAccumulatorService;
use Carbon\Carbon;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "PRUEBA: Actualización de Días con Detalle\n";
echo "========================================\n\n";

echo "Fecha de hoy: " . Carbon::today()->format('d-m-Y') . "\n\n";

echo "Ejecutando actualización diaria de vacaciones...\n\n";

$service = new VacationDailyAccumulatorService();
$startTime = microtime(true);

$results = $service->updateDailyAccumulationForAllUsers();

$endTime = microtime(true);
$duration = round($endTime - $startTime, 2);

echo "========================================\n";
echo "RESUMEN DE ACTUALIZACIÓN:\n";
echo "========================================\n\n";

echo sprintf("✓ Usuarios procesados:        %d\n", $results['users_processed']);
echo sprintf("✓ Períodos actualizados:      %d\n", $results['periods_updated']);
echo sprintf("⏭ Períodos omitidos:          %d\n", $results['periods_skipped']);
echo sprintf("⚠ Períodos vencidos:          %d\n", $results['periods_expired']);
echo sprintf("⏱ Duración:                   %.2f segundos\n", $duration);

if (!empty($results['errors'])) {
    echo sprintf("✗ Errores:                    %d\n", count($results['errors']));
}

echo "\n";

// Mostrar tabla de detalles
if (!empty($results['details'])) {
    echo "========================================\n";
    echo "TABLA DE DETALLES (primeros 20):\n";
    echo "========================================\n\n";
    
    $header = sprintf(
        "%-4s %-25s %-30s %-8s %12s %12s %12s",
        "#",
        "Planta",
        "Usuario",
        "Período",
        "Anterior",
        "Actualizado",
        "Incremento"
    );
    
    echo $header . "\n";
    echo str_repeat("-", 120) . "\n";
    
    $limit = min(20, count($results['details']));
    
    for ($i = 0; $i < $limit; $i++) {
        $detail = $results['details'][$i];
        
        // Truncar nombres largos
        $planta = mb_substr($detail['planta'], 0, 24);
        $usuario = mb_substr($detail['usuario'], 0, 29);
        
        $row = sprintf(
            "%-4d %-25s %-30s %-8d %12.2f %12.2f %12.2f",
            $i + 1,
            $planta,
            $usuario,
            $detail['periodo'],
            $detail['dias_anteriores'],
            $detail['dias_actualizados'],
            $detail['incremento']
        );
        
        echo $row . "\n";
    }
    
    if (count($results['details']) > 20) {
        echo "\n... y " . (count($results['details']) - 20) . " registros más.\n";
    }
    
    echo "\n";
    echo "Total de registros en detalle: " . count($results['details']) . "\n";
    
    // Estadísticas
    $totalIncremento = array_sum(array_column($results['details'], 'incremento'));
    $promedioIncremento = count($results['details']) > 0 
        ? $totalIncremento / count($results['details']) 
        : 0;
    
    echo "\n";
    echo "Estadísticas:\n";
    echo sprintf("  Total días incrementados:   %.2f días\n", $totalIncremento);
    echo sprintf("  Promedio por período:       %.2f días\n", $promedioIncremento);
    
    // Agrupar por planta
    $porPlanta = [];
    foreach ($results['details'] as $detail) {
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
    
    echo "\n";
    echo "Desglose por Planta:\n";
    foreach ($porPlanta as $planta => $stats) {
        echo sprintf("  %-30s %3d períodos  (+%.2f días)\n", 
            $planta, 
            $stats['count'], 
            $stats['total_incremento']
        );
    }
} else {
    echo "ℹ️  No se encontraron períodos con cambios significativos.\n";
    echo "   (Solo se muestran actualizaciones con incremento > 0.01)\n";
}

echo "\n";
echo "========================================\n";
echo "VISTA PREVIA DEL MODAL:\n";
echo "========================================\n\n";

echo "El modal mostrará:\n\n";
echo "1. RESUMEN (4 tarjetas):\n";
echo "   [Usuarios: {$results['users_processed']}] [Actualizados: {$results['periods_updated']}] [Omitidos: {$results['periods_skipped']}] [Vencidos: {$results['periods_expired']}]\n\n";

echo "2. TABLA DETALLADA:\n";
echo "   ┌─────────────────────────────────────────────────────────────────────┐\n";
echo "   │ #  │ Planta    │ Usuario          │ Período │ Anterior │ Actual  │\n";
echo "   ├─────────────────────────────────────────────────────────────────────┤\n";

if (!empty($results['details'])) {
    for ($i = 0; $i < min(5, count($results['details'])); $i++) {
        $d = $results['details'][$i];
        echo sprintf("   │ %-2d │ %-9s │ %-16s │    %-4d │   %6.2f │  %6.2f │\n",
            $i + 1,
            mb_substr($d['planta'], 0, 9),
            mb_substr($d['usuario'], 0, 16),
            $d['periodo'],
            $d['dias_anteriores'],
            $d['dias_actualizados']
        );
    }
    
    if (count($results['details']) > 5) {
        echo "   │ ...                                                            │\n";
    }
}

echo "   └─────────────────────────────────────────────────────────────────────┘\n\n";

echo "3. CARACTERÍSTICAS:\n";
echo "   ✓ Tabla con scroll (máximo 400px altura)\n";
echo "   ✓ Headers sticky (se mantienen visibles al hacer scroll)\n";
echo "   ✓ Badges con colores: Warning (anterior), Success (actual), Primary (incremento)\n";
echo "   ✓ Solo se muestran períodos con cambios significativos (>0.01)\n";
echo "   ✓ Datos en memoria (no se almacenan en BD)\n\n";

echo "Prueba completada.\n";

<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\VacationsAvailable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "========================================\n";
echo "ACTUALIZACIÓN: days_calculated NULL → 0\n";
echo "========================================\n\n";

$today = Carbon::today();
echo "Fecha de hoy: " . $today->format('d-m-Y') . "\n\n";

// Buscar todos los períodos con days_calculated = NULL que YA NO están activos
$periodsToUpdate = VacationsAvailable::whereNull('days_calculated')
    ->where(function($q) use ($today) {
        // Períodos pasados (date_end < hoy)
        $q->where('date_end', '<', $today->format('Y-m-d'))
          // O períodos futuros (date_start > hoy)
          ->orWhere('date_start', '>', $today->format('Y-m-d'))
          // O períodos históricos
          ->orWhere('is_historical', true);
    })
    ->with('user')
    ->get();

echo "Total de períodos encontrados con days_calculated = NULL (no activos): " . $periodsToUpdate->count() . "\n\n";

if ($periodsToUpdate->isEmpty()) {
    echo "✓ No hay períodos para actualizar.\n";
    exit(0);
}

// Separar por categoría
$pasados = $periodsToUpdate->filter(function($p) use ($today) {
    return Carbon::parse($p->date_end)->lessThan($today);
})->count();

$futuros = $periodsToUpdate->filter(function($p) use ($today) {
    return Carbon::parse($p->date_start)->greaterThan($today);
})->count();

$historicos = $periodsToUpdate->filter(function($p) {
    return $p->is_historical;
})->count();

echo "Clasificación:\n";
echo sprintf("  - Períodos PASADOS (ya finalizaron):  %d\n", $pasados);
echo sprintf("  - Períodos FUTUROS (aún no inician):  %d\n", $futuros);
echo sprintf("  - Períodos HISTÓRICOS:                %d\n", $historicos);
echo str_repeat("-", 50) . "\n\n";

// Mostrar algunos ejemplos antes de actualizar
echo "Ejemplos de períodos a actualizar (primeros 5):\n\n";

foreach ($periodsToUpdate->take(5) as $period) {
    $user = $period->user;
    $userName = $user ? $user->first_name . ' ' . $user->last_name : 'Usuario ID ' . $period->users_id;
    
    $tipo = 'Desconocido';
    if ($period->is_historical) {
        $tipo = 'Histórico';
    } elseif (Carbon::parse($period->date_end)->lessThan($today)) {
        $tipo = 'Pasado';
    } elseif (Carbon::parse($period->date_start)->greaterThan($today)) {
        $tipo = 'Futuro';
    }
    
    echo sprintf(
        "- %s | Período %d | %s a %s | Tipo: %s\n",
        $userName,
        $period->period,
        Carbon::parse($period->date_start)->format('d-m-Y'),
        Carbon::parse($period->date_end)->format('d-m-Y'),
        $tipo
    );
}

if ($periodsToUpdate->count() > 5) {
    echo "\n... y " . ($periodsToUpdate->count() - 5) . " más.\n";
}

echo "\n";
echo "========================================\n";
echo "¿Deseas continuar con la actualización?\n";
echo "========================================\n";
echo "Se actualizará days_calculated de NULL a 0 para estos períodos.\n";
echo "Los períodos ACTUALES (activos hoy) NO se modificarán.\n\n";

echo "Presiona ENTER para continuar o Ctrl+C para cancelar: ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
fclose($handle);

echo "\n";
echo "Iniciando actualización...\n\n";

DB::beginTransaction();

try {
    $updated = 0;
    $errors = 0;
    
    foreach ($periodsToUpdate as $period) {
        try {
            $period->days_calculated = 0;
            $period->save();
            $updated++;
            
            if ($updated % 10 === 0) {
                echo ".";
            }
        } catch (\Exception $e) {
            $errors++;
            echo "\nError actualizando período ID {$period->id}: " . $e->getMessage() . "\n";
        }
    }
    
    DB::commit();
    
    echo "\n\n";
    echo "========================================\n";
    echo "RESULTADO:\n";
    echo "========================================\n\n";
    echo sprintf("✓ Períodos actualizados: %d\n", $updated);
    
    if ($errors > 0) {
        echo sprintf("✗ Errores: %d\n", $errors);
    }
    
    echo "\n";
    echo "Actualización completada exitosamente.\n\n";
    
    // Verificación final
    $remaining = VacationsAvailable::whereNull('days_calculated')
        ->where(function($q) use ($today) {
            $q->where('date_end', '<', $today->format('Y-m-d'))
              ->orWhere('date_start', '>', $today->format('Y-m-d'))
              ->orWhere('is_historical', true);
        })
        ->count();
    
    echo "Períodos no activos con NULL restantes: " . $remaining . "\n";
    
    if ($remaining === 0) {
        echo "✓ PERFECTO: Todos los períodos no activos tienen days_calculated = 0\n";
    } else {
        echo "⚠ AÚN HAY {$remaining} períodos con NULL\n";
    }
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n\n";
    echo "✗ ERROR CRÍTICO: " . $e->getMessage() . "\n";
    echo "Se revirtieron todos los cambios.\n";
    exit(1);
}

echo "\n";
echo "========================================\n";
echo "NOTAS IMPORTANTES:\n";
echo "========================================\n\n";
echo "1. Períodos PASADOS → days_calculated = 0 (ya no se calculan)\n";
echo "2. Períodos FUTUROS → days_calculated = 0 (aún no inician)\n";
echo "3. Períodos ACTUALES → Mantienen su valor calculado (no se tocan)\n";
echo "4. Los períodos actuales se siguen calculando automáticamente\n";
echo "   con el comando: php artisan vacations:update-accrual\n\n";

echo "Proceso finalizado.\n";

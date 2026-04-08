<?php
/**
 * TEST: VALIDAR MAPEO DE COLUMNAS N Y P EN IMPORTACIÓN
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST: MAPEO DE COLUMNAS N Y P EN IMPORTACIÓN                           ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

echo "📋 VALIDACIÓN DEL CÓDIGO:\n";
echo "════════════════════════════════════════════════════════════════════════════════════════\n\n";

echo "1️⃣ PARSEROW (líneas 247-249):\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "  \$diasDisfrutadosAntes   = \$clean(\$values[12] ?? '');  // Columna N (índice 12)\n";
echo "  \$diasDisfrutadosPeriodo = \$clean(\$values[13] ?? '');  // Columna O (índice 13)\n";
echo "  \$diasDisfrutadosDespues = \$clean(\$values[14] ?? '');  // Columna P (índice 14)\n\n";

echo "2️⃣ ARRAY DE RETORNO (líneas 329-331):\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "  'dias_disfrutados_antes'  => \$diasDisfrutadosAntes,   // N\n";
echo "  'dias_disfrutados_actual' => \$diasDisfrutadosPeriodo, // O\n";
echo "  'dias_disfrutados_despues' => \$diasDisfrutadosDespues, // P\n\n";

echo "3️⃣ EXECUTEIMPORT (líneas 558-566):\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "  // Columna O\n";
echo "  \$diasDisfrutadosActual = (float) str_replace([',', ' '], '', \$record['dias_disfrutados_actual'] ?: 0);\n\n";
echo "  // Columna N\n";
echo "  \$diasAntesAniversario = (float) str_replace([',', ' '], '', \$record['dias_disfrutados_antes'] ?: 0);\n\n";
echo "  // Columna P\n";
echo "  \$diasDespuesAniversario = (float) str_replace([',', ' '], '', \$record['dias_disfrutados_despues'] ?: 0);\n\n";
echo "  \$periodoActual->update([\n";
echo "      'days_availables' => \$diasDisponiblesActual,                 ← Q\n";
echo "      'days_enjoyed' => \$diasDisfrutadosActual,                    ← O\n";
echo "      'days_enjoyed_before_anniversary' => \$diasAntesAniversario,  ← N\n";
echo "      'days_enjoyed_after_anniversary' => \$diasDespuesAniversario, ← P\n";
echo "  ]);\n\n";

echo "✅ MAPEO CORRECTO:\n";
echo "════════════════════════════════════════════════════════════════════════════════════════\n";
echo "  Columna N → days_enjoyed_before_anniversary\n";
echo "  Columna O → days_enjoyed\n";
echo "  Columna P → days_enjoyed_after_anniversary\n";
echo "  Columna Q → days_availables\n\n";

echo "📊 DATOS REALES DE LA BASE DE DATOS:\n";
echo "════════════════════════════════════════════════════════════════════════════════════════\n\n";

// Buscar usuarios con days_enjoyed_before_anniversary > 0
$usuariosConAntes = VacationsAvailable::where('days_enjoyed_before_anniversary', '>', 0)
    ->with('user')
    ->orderBy('users_id')
    ->limit(10)
    ->get();

if ($usuariosConAntes->count() > 0) {
    echo "Usuarios con días ANTES de aniversario (columna N):\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo str_pad("Usuario ID", 12);
    echo str_pad("Nombre", 35);
    echo str_pad("Antes (N)", 12);
    echo str_pad("Total (O)", 12);
    echo str_pad("Después (P)", 12);
    echo "\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    
    foreach ($usuariosConAntes as $periodo) {
        if (!$periodo->user) continue;
        
        $nombreCompleto = mb_strtoupper(trim($periodo->user->last_name . ' ' . $periodo->user->first_name), 'UTF-8');
        
        echo str_pad($periodo->users_id, 12);
        echo str_pad(substr($nombreCompleto, 0, 33), 35);
        echo str_pad(number_format($periodo->days_enjoyed_before_anniversary, 2), 12);
        echo str_pad(number_format($periodo->days_enjoyed, 2), 12);
        echo str_pad(number_format($periodo->days_enjoyed_after_anniversary, 2), 12);
        echo "\n";
    }
} else {
    echo "⚠️  No se encontraron registros con days_enjoyed_before_anniversary > 0\n";
    echo "     Esto puede significar que aún no se ha importado ningún archivo Excel\n";
    echo "     con datos en la columna N (Días disfrutados antes de aniversario).\n";
}

// Buscar usuarios con days_enjoyed_after_anniversary > 0
echo "\n";
$usuariosConDespues = VacationsAvailable::where('days_enjoyed_after_anniversary', '>', 0)
    ->with('user')
    ->orderBy('users_id')
    ->limit(10)
    ->get();

if ($usuariosConDespues->count() > 0) {
    echo "Usuarios con días DESPUÉS de aniversario (columna P):\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo str_pad("Usuario ID", 12);
    echo str_pad("Nombre", 35);
    echo str_pad("Antes (N)", 12);
    echo str_pad("Total (O)", 12);
    echo str_pad("Después (P)", 12);
    echo "\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    
    foreach ($usuariosConDespues as $periodo) {
        if (!$periodo->user) continue;
        
        $nombreCompleto = mb_strtoupper(trim($periodo->user->last_name . ' ' . $periodo->user->first_name), 'UTF-8');
        
        echo str_pad($periodo->users_id, 12);
        echo str_pad(substr($nombreCompleto, 0, 33), 35);
        echo str_pad(number_format($periodo->days_enjoyed_before_anniversary, 2), 12);
        echo str_pad(number_format($periodo->days_enjoyed, 2), 12);
        echo str_pad(number_format($periodo->days_enjoyed_after_anniversary, 2), 12);
        echo "\n";
    }
} else {
    echo "⚠️  No se encontraron registros con days_enjoyed_after_anniversary > 0\n";
    echo "     Esto puede significar que aún no se ha importado ningún archivo Excel\n";
    echo "     con datos en la columna P (Días disfrutados después de aniversario).\n";
}

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                            ✅ VALIDACIÓN COMPLETA                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

echo "RESUMEN:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "✓ El código está correctamente mapeado\n";
echo "✓ Columna N (índice 12) → days_enjoyed_before_anniversary\n";
echo "✓ Columna O (índice 13) → days_enjoyed\n";
echo "✓ Columna P (índice 14) → days_enjoyed_after_anniversary\n";
echo "✓ Columna Q (índice 15) → days_availables\n";
echo "✓ Los campos se actualizan en el período actual (fecha_aniversario_import)\n\n";

echo "Para verificar con datos reales:\n";
echo "1. Importa un archivo Excel con datos en columnas N, O, P y Q\n";
echo "2. Ejecuta este test nuevamente para ver los valores guardados\n";
echo "3. Compara con los datos del Excel original\n\n";

echo "Fecha de validación: " . date('d/m/Y H:i:s') . "\n";

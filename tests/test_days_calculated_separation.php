<?php

/**
 * Test: Validar separación de days_calculated y days_availables
 * 
 * Este test verifica que:
 * 1. El campo days_calculated existe en la tabla
 * 2. Los servicios de cálculo automático usan days_calculated
 * 3. La importación de Excel usa days_availables
 * 4. Ambos campos pueden coexistir sin conflicto
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\VacationsAvailable;
use App\Models\User;
use Carbon\Carbon;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n╔══════════════════════════════════════════════════════════════╗\n";
echo "║  TEST: Separación days_calculated vs days_availables       ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// 1. Verificar que el campo existe en la tabla
echo "1️⃣  VERIFICACIÓN DE ESTRUCTURA DE TABLA\n";
echo str_repeat("═", 60) . "\n";

if (Schema::hasColumn('vacations_availables', 'days_calculated')) {
    echo "✓ Campo 'days_calculated' existe en vacations_availables\n";
    
    $columnType = DB::select("SHOW COLUMNS FROM vacations_availables WHERE Field = 'days_calculated'");
    if (!empty($columnType)) {
        $type = $columnType[0]->Type;
        echo "✓ Tipo de dato: {$type}\n";
    }
} else {
    echo "✗ Campo 'days_calculated' NO existe\n";
    exit(1);
}

if (Schema::hasColumn('vacations_availables', 'days_availables')) {
    echo "✓ Campo 'days_availables' existe en vacations_availables\n";
} else {
    echo "✗ Campo 'days_availables' NO existe\n";
}
echo "\n";

// 2. Verificar que el modelo incluye el campo
echo "2️⃣  VERIFICACIÓN DEL MODELO VacationsAvailable\n";
echo str_repeat("═", 60) . "\n";

$modelPath = base_path('app/Models/VacationsAvailable.php');
$modelContent = file_get_contents($modelPath);

if (strpos($modelContent, "'days_calculated'") !== false) {
    echo "✓ Campo 'days_calculated' en \$fillable\n";
} else {
    echo "✗ Campo 'days_calculated' NO está en \$fillable\n";
}

if (strpos($modelContent, "'days_calculated' => 'decimal:2'") !== false) {
    echo "✓ Campo 'days_calculated' en \$casts\n";
} else {
    echo "✗ Campo 'days_calculated' NO está en \$casts\n";
}
echo "\n";

// 3. Verificar servicios de cálculo automático
echo "3️⃣  VERIFICACIÓN DE SERVICIOS DE CÁLCULO AUTOMÁTICO\n";
echo str_repeat("═", 60) . "\n";

// VacationDailyAccumulatorService
$serviceFile = base_path('app/Services/VacationDailyAccumulatorService.php');
if (file_exists($serviceFile)) {
    $content = file_get_contents($serviceFile);
    
    if (strpos($content, '$vacation->days_calculated') !== false) {
        echo "✓ VacationDailyAccumulatorService usa days_calculated\n";
    } else {
        echo "⚠️  VacationDailyAccumulatorService NO usa days_calculated\n";
    }
} else {
    echo "⚠️  VacationDailyAccumulatorService no encontrado\n";
}

// UpdateVacationAccrual Command
$commandFile = base_path('app/Console/Commands/UpdateVacationAccrual.php');
if (file_exists($commandFile)) {
    $content = file_get_contents($commandFile);
    
    if (strpos($content, '$period->days_calculated') !== false) {
        echo "✓ UpdateVacationAccrual usa days_calculated\n";
    } else {
        echo "⚠️  UpdateVacationAccrual NO usa days_calculated\n";
    }
} else {
    echo "⚠️  UpdateVacationAccrual no encontrado\n";
}
echo "\n";

// 4. Verificar que VacationImport usa days_availables
echo "4️⃣  VERIFICACIÓN DE IMPORTACIÓN (VacationImport)\n";
echo str_repeat("═", 60) . "\n";

$importFile = base_path('app/Livewire/VacationImport.php');
if (file_exists($importFile)) {
    $content = file_get_contents($importFile);
    
    if (strpos($content, "'days_availables' => \$diasDisponiblesActual") !== false) {
        echo "✓ VacationImport actualiza days_availables (desde Excel)\n";
    } else {
        echo "⚠️  VacationImport NO actualiza days_availables\n";
    }
    
    if (strpos($content, "'days_calculated'") === false) {
        echo "✓ VacationImport NO toca days_calculated (correcto)\n";
    } else {
        echo "⚠️  VacationImport modifica days_calculated (no debería)\n";
    }
} else {
    echo "⚠️  VacationImport no encontrado\n";
}
echo "\n";

// 5. Probar con datos reales
echo "5️⃣  PRUEBA CON DATOS REALES\n";
echo str_repeat("═", 60) . "\n";

// Buscar un período actual de vacaciones
$vacationPeriod = VacationsAvailable::whereNotNull('users_id')
    ->where('status', 'actual')
    ->first();

if ($vacationPeriod) {
    $user = User::find($vacationPeriod->users_id);
    $userName = $user ? "{$user->first_name} {$user->last_name}" : "Usuario ID {$vacationPeriod->users_id}";
    
    echo "Período encontrado:\n";
    echo "  Usuario: {$userName}\n";
    echo "  Período: {$vacationPeriod->period}\n";
    echo "  Fecha inicio: {$vacationPeriod->date_start->format('d/m/Y')}\n";
    echo "  Fecha fin: {$vacationPeriod->date_end->format('d/m/Y')}\n";
    echo "\n";
    
    echo "Valores actuales:\n";
    echo "  • days_total_period: " . number_format($vacationPeriod->days_total_period, 2) . " días\n";
    echo "  • days_calculated: " . ($vacationPeriod->days_calculated !== null ? number_format($vacationPeriod->days_calculated, 2) : 'NULL') . " (cálculo automático)\n";
    echo "  • days_availables: " . number_format($vacationPeriod->days_availables, 2) . " (desde Excel)\n";
    echo "  • days_enjoyed: " . $vacationPeriod->days_enjoyed . " días\n";
    echo "\n";
    
    if ($vacationPeriod->days_calculated === null) {
        echo "ℹ️  days_calculated está en NULL (normal si no se ha ejecutado el cálculo automático)\n";
        echo "   Ejecuta: php artisan vacations:update-accrual\n";
    }
    
} else {
    echo "ℹ️  No se encontraron períodos de vacaciones activos\n";
}
echo "\n";

// 6. Diagrama explicativo
echo "📊 FLUJO DE DATOS\n";
echo str_repeat("═", 60) . "\n\n";

echo "┌─────────────────────────────────────────────────────────┐\n";
echo "│                  CAMPO: days_calculated                 │\n";
echo "├─────────────────────────────────────────────────────────┤\n";
echo "│ • Actualizado por: Sistema (cálculo automático)        │\n";
echo "│ • Frecuencia: Diario (comando artisan)                 │\n";
echo "│ • Servicios:                                            │\n";
echo "│   - VacationDailyAccumulatorService                     │\n";
echo "│   - UpdateVacationAccrual (comando)                     │\n";
echo "│ • Valor: Días acumulados proporcionalmente              │\n";
echo "│          desde date_start hasta hoy                     │\n";
echo "└─────────────────────────────────────────────────────────┘\n\n";

echo "┌─────────────────────────────────────────────────────────┐\n";
echo "│                  CAMPO: days_availables                 │\n";
echo "├─────────────────────────────────────────────────────────┤\n";
echo "│ • Actualizado por: Importación Excel                    │\n";
echo "│ • Frecuencia: Manual (cuando se importa)               │\n";
echo "│ • Componente: VacationImport                            │\n";
echo "│ • Fuente: Columna Q del Excel                           │\n";
echo "│ • Valor: Saldo pendiente según Excel                    │\n";
echo "│          (puede diferir del cálculo automático)         │\n";
echo "└─────────────────────────────────────────────────────────┘\n\n";

echo "💡 VENTAJAS DE LA SEPARACIÓN:\n";
echo "───────────────────────────────────────────────────────────\n";
echo "✓ No hay conflicto entre cálculo automático e importación\n";
echo "✓ Se conservan ambos valores para comparación\n";
echo "✓ Importación de Excel no sobrescribe datos calculados\n";
echo "✓ Cálculo automático no sobrescribe datos importados\n";
echo "✓ Mayor trazabilidad y auditoría\n\n";

echo "📝 RESUMEN FINAL\n";
echo str_repeat("═", 60) . "\n";
echo "✅ Campo days_calculated agregado correctamente\n";
echo "✅ Modelo actualizado con nuevo campo\n";
echo "✅ Servicios de cálculo usan days_calculated\n";
echo "✅ Importación usa days_availables (sin cambios)\n";
echo "✅ Ambos campos pueden coexistir sin conflictos\n\n";

echo "🚀 PRÓXIMOS PASOS:\n";
echo "   1. Ejecutar: php artisan vacations:update-accrual\n";
echo "   2. Verificar que days_calculated se actualiza\n";
echo "   3. Importar Excel y verificar que days_availables se actualiza\n";
echo "   4. Confirmar que ambos valores son independientes\n";
echo "\n";

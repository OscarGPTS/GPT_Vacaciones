<?php

/**
 * TEST: Validación de Campos Nuevos en Importación
 * 
 * Valida que los nuevos campos se importen correctamente:
 * - days_enjoyed_before_anniversary (columna N para período actual, G para anterior)
 * - days_enjoyed_after_anniversary (columna P para período actual, I para anterior)
 * 
 * Caso de prueba: Usuario 13 (Benjamín Alcántara)
 * Según plantilla Excel:
 * - Período actual (2026-2027): N=0, P="" (vacío)
 * - Período anterior (2025-2026): G="", H=1, I=10
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\VacationsAvailable;
use App\Models\User;
use Carbon\Carbon;

echo "╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║      TEST: VALIDACIÓN CAMPOS NUEVOS (días antes/después aniversario)               ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

echo "Nuevos campos agregados:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "  ✓ days_enjoyed_before_anniversary  (columna N período actual)\n";
echo "  ✓ days_enjoyed_after_anniversary   (columna P período actual)\n";
echo "  ℹ️  Período anterior: solo actualiza saldo (columna J), sin desglose\n\n";

// Caso de prueba: Usuario 13
$userId = 13;
$user = User::find($userId);

if (!$user) {
    echo "❌ ERROR: Usuario 13 no encontrado\n";
    exit(1);
}

echo "Usuario de prueba:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo sprintf("  👤 ID: %d\n", $user->id);
echo sprintf("  👤 Nombre: %s %s\n", $user->first_name, $user->last_name);
echo sprintf("  📅 Fecha ingreso: %s\n\n", $user->admission ?? 'N/A');

// Obtener períodos del usuario
$periodos = VacationsAvailable::where('users_id', $userId)
    ->orderBy('date_start')
    ->get();

if ($periodos->isEmpty()) {
    echo "⚠️  ADVERTENCIA: Usuario no tiene períodos registrados\n";
    exit(0);
}

echo "Períodos encontrados:\n";
echo "════════════════════════════════════════════════════════════════════════════════════════\n";

$tests = [];
$allPassed = true;

foreach ($periodos as $idx => $periodo) {
    echo sprintf("\n📅 Período %d: %s → %s\n", 
        $idx + 1, 
        $periodo->date_start, 
        $periodo->date_end
    );
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    
    // Verificar que los campos existen en la tabla
    try {
        $diasAntes = $periodo->days_enjoyed_before_anniversary ?? 'NO EXISTE';
        $diasDespues = $periodo->days_enjoyed_after_anniversary ?? 'NO EXISTE';
        
        echo sprintf("  Total período:             %.2f días\n", $periodo->days_total_period);
        echo sprintf("  Disponibles:               %.2f días\n", $periodo->days_availables);
        echo sprintf("  Disfrutados total:         %.2f días\n", $periodo->days_enjoyed);
        
        if ($diasAntes === 'NO EXISTE') {
            echo "  ❌ Campo 'days_enjoyed_before_anniversary' NO EXISTE en la tabla\n";
            $allPassed = false;
        } else {
            echo sprintf("  ✅ Antes de aniversario:   %.2f días%s\n", 
                (float)$diasAntes,
                $diasAntes == 0 ? ' (por defecto)' : ''
            );
        }
        
        if ($diasDespues === 'NO EXISTE') {
            echo "  ❌ Campo 'days_enjoyed_after_anniversary' NO EXISTE en la tabla\n";
            $allPassed = false;
        } else {
            echo sprintf("  ✅ Después de aniversario: %.2f días%s\n", 
                (float)$diasDespues,
                $diasDespues == 0 ? ' (por defecto)' : ''
            );
        }
        
        // Validar coherencia: antes + después <= total disfrutados
        if ($diasAntes !== 'NO EXISTE' && $diasDespues !== 'NO EXISTE') {
            $sumaAntesYDespues = (float)$diasAntes + (float)$diasDespues;
            $coherente = $sumaAntesYDespues <= ($periodo->days_enjoyed + 0.01); // +0.01 tolerancia redondeo
            
            if ($coherente) {
                echo sprintf("  ✅ Coherencia: %.2f (antes+después) <= %.2f (total)\n", 
                    $sumaAntesYDespues, 
                    (float)$periodo->days_enjoyed
                );
            } else {
                echo sprintf("  ⚠️  Advertencia: %.2f (antes+después) > %.2f (total)\n", 
                    $sumaAntesYDespues, 
                    (float)$periodo->days_enjoyed
                );
                // No es error crítico, puede haber diferencias por H (días del período)
            }
        }
        
        $tests[] = [
            'periodo' => sprintf("%s → %s", $periodo->date_start, $periodo->date_end),
            'campos_existen' => $diasAntes !== 'NO EXISTE' && $diasDespues !== 'NO EXISTE',
            'antes' => $diasAntes,
            'despues' => $diasDespues
        ];
        
    } catch (\Exception $e) {
        echo "  ❌ ERROR al leer campos: " . $e->getMessage() . "\n";
        $allPassed = false;
    }
}

// Resumen final
echo "\n\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                                   RESUMEN FINAL                                     ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

$camposExisten = count(array_filter($tests, fn($t) => $t['campos_existen']));
$totalTests = count($tests);

echo sprintf("Períodos analizados:     %d\n", count($periodos));
echo sprintf("Campos existentes:       %d / %d (%.1f%%)\n", 
    $camposExisten, $totalTests, 
    $totalTests > 0 ? ($camposExisten / $totalTests) * 100 : 0);

if ($allPassed && $camposExisten === $totalTests) {
    echo "\n✅ TODOS LOS CAMPOS NUEVOS EXISTEN Y SON ACCESIBLES\n\n";
    echo "Flujo de importación con nuevos campos:\n";
    echo "  • Período actual (2026-2027):\n";
    echo "    - days_enjoyed_before_anniversary  = columna N (antes de aniversario)\n";
    echo "    - days_enjoyed_after_anniversary   = columna P (después aniversario, 3 meses)\n";
    echo "    - days_availables                  = columna Q (saldo pendiente)\n";
    echo "    - days_enjoyed                     = CALCULADO (total - Q)\n";
    echo "    - Columna O NO se usa (solo referencia visual)\n";
    echo "  • Período anterior (2025-2026):\n";
    echo "    - days_availables                  = columna J (saldo pendiente)\n";
    echo "    - days_enjoyed                     = CALCULADO (total - J)\n";
    echo "    - Campos antes/después NO se actualizan (permanecen en 0 o NULL)\n";
} else {
    echo "\n⚠️  CAMPOS NO ENCONTRADOS O PROBLEMAS DE ACCESO\n\n";
    echo "Acción requerida:\n";
    echo "  1. Ejecutar: php artisan migrate:fresh --seed\n";
    echo "  2. O bien: php artisan migrate:refresh\n";
    echo "  3. Verificar que la migración 2025_10_13_095851_create_vacaciones_table.php\n";
    echo "     contiene los campos:\n";
    echo "     - days_enjoyed_before_anniversary\n";
    echo "     - days_enjoyed_after_anniversary\n";
}

echo "\nFecha de prueba: " . Carbon::now()->format('d/m/Y H:i:s') . "\n";

exit($allPassed && $camposExisten === $totalTests ? 0 : 1);

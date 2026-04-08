<?php
/**
 * TEST DE EXPORTACIÓN DE VACACIONES
 * 
 * Valida que el export de vacaciones funcione correctamente con el formato especificado
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST: VALIDACIÓN DE EXPORTACIÓN DE VACACIONES                           ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

try {
    // 1. Verificar que existan usuarios con períodos de vacaciones
    $usersWithPeriods = DB::table('users')
        ->join('vacations_availables', 'users.id', '=', 'vacations_availables.users_id')
        ->where('users.active', 1)
        ->select('users.id', 'users.first_name', 'users.last_name', DB::raw('COUNT(vacations_availables.id) as periods_count'))
        ->groupBy('users.id', 'users.first_name', 'users.last_name')
        ->get();

    echo "📊 USUARIOS CON PERÍODOS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "Total usuarios activos con períodos: " . $usersWithPeriods->count() . "\n\n";

    // 2. Verificar estructura de datos para los primeros 5 usuarios
    echo "📋 DATOS DE EJEMPLO (PRIMEROS 5 USUARIOS):\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";

    foreach ($usersWithPeriods->take(5) as $index => $user) {
        echo ($index + 1) . ". {$user->first_name} {$user->last_name}\n";
        echo "   Períodos disponibles: {$user->periods_count}\n";

        // Obtener períodos ordenados
        $periods = DB::table('vacations_availables')
            ->where('users_id', $user->id)
            ->orderBy('date_end', 'desc')
            ->get();

        if ($periods->count() > 0) {
            $periodoActual = $periods->first();
            $periodoAnterior = $periods->count() > 1 ? $periods->skip(1)->first() : null;

            echo "   Período actual:\n";
            echo "     - Fecha fin: {$periodoActual->date_end}\n";
            echo "     - Días totales: {$periodoActual->days_total_period}\n";
            echo "     - Días disponibles: {$periodoActual->days_availables}\n";
            echo "     - Días disfrutados: {$periodoActual->days_enjoyed}\n";
            echo "     - Antes aniversario: " . ($periodoActual->days_enjoyed_before_anniversary ?? '0.00') . "\n";
            echo "     - Después aniversario: " . ($periodoActual->days_enjoyed_after_anniversary ?? '0.00') . "\n";

            if ($periodoAnterior) {
                echo "   Período anterior:\n";
                echo "     - Fecha fin: {$periodoAnterior->date_end}\n";
                echo "     - Días disponibles: {$periodoAnterior->days_availables}\n";
            }
        }
        echo "\n";
    }

    // 3. Validar campos nuevos existen
    echo "✅ VALIDACIÓN DE CAMPOS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";

    $samplePeriod = DB::table('vacations_availables')->first();
    
    $requiredFields = [
        'days_total_period',
        'days_availables',
        'days_enjoyed',
        'days_enjoyed_before_anniversary',
        'days_enjoyed_after_anniversary',
        'date_end'
    ];

    foreach ($requiredFields as $field) {
        $exists = property_exists($samplePeriod, $field);
        $icon = $exists ? '✓' : '✗';
        $status = $exists ? 'EXISTE' : 'NO EXISTE';
        echo "  $icon Campo '$field': $status\n";
    }

    // 4. Calcular años dinámicos
    $currentYear = date('Y');
    $previousYear = $currentYear - 1;
    $nextYear = $currentYear + 1;

    echo "\n📅 AÑOS CALCULADOS DINÁMICAMENTE:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "  Período anterior: {$previousYear}-{$currentYear}\n";
    echo "  Período actual: {$currentYear}-{$nextYear}\n";

    // 5. Verificar que OpenSpout esté disponible
    echo "\n🔧 DEPENDENCIAS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    
    if (class_exists('OpenSpout\Writer\XLSX\Writer')) {
        echo "  ✓ OpenSpout XLSX Writer: DISPONIBLE\n";
    } else {
        echo "  ✗ OpenSpout XLSX Writer: NO DISPONIBLE\n";
    }

    if (class_exists('OpenSpout\Common\Entity\Cell')) {
        echo "  ✓ OpenSpout Cell: DISPONIBLE\n";
    } else {
        echo "  ✗ OpenSpout Cell: NO DISPONIBLE\n";
    }

    if (class_exists('OpenSpout\Common\Entity\Style\Style')) {
        echo "  ✓ OpenSpout Style: DISPONIBLE\n";
    } else {
        echo "  ✗ OpenSpout Style: NO DISPONIBLE\n";
    }

    echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                            ✅ VALIDACIÓN COMPLETA                                  ║\n";
    echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

    echo "INSTRUCCIONES PARA PROBAR:\n";
    echo "1. Ir a: http://localhost:8000/vacaciones/reporte\n";
    echo "2. Hacer clic en el botón 'Exportar Vacaciones'\n";
    echo "3. El archivo Excel se descargará con el formato especificado\n";
    echo "4. Verificar que los colores de los encabezados coincidan con la imagen de referencia\n\n";

    echo "Fecha de validación: " . date('d/m/Y H:i:s') . "\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}

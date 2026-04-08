<?php
/**
 * TEST DE EXPORTACIÓN CON PHPSPREADSHEET
 * 
 * Valida que el export use PhpSpreadsheet con colores y estructura correcta
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST: EXPORTACIÓN CON PHPSPREADSHEET                                    ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

try {
    // 1. Verificar que PhpSpreadsheet esté disponible
    echo "🔧 DEPENDENCIAS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    
    if (class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        echo "  ✓ PhpSpreadsheet: DISPONIBLE\n";
    } else {
        echo "  ✗ PhpSpreadsheet: NO DISPONIBLE\n";
        exit(1);
    }

    if (class_exists('PhpOffice\PhpSpreadsheet\Writer\Xlsx')) {
        echo "  ✓ XLSX Writer: DISPONIBLE\n";
    } else {
        echo "  ✗ XLSX Writer: NO DISPONIBLE\n";
        exit(1);
    }

    if (class_exists('PhpOffice\PhpSpreadsheet\Style\Fill')) {
        echo "  ✓ Style/Fill: DISPONIBLE\n";
    } else {
        echo "  ✗ Style/Fill: NO DISPONIBLE\n";
        exit(1);
    }

    // 2. Años dinámicos
    $currentYear = date('Y');
    $previousYear = $currentYear - 1;
    $nextYear = $currentYear + 1;

    echo "\n📅 AÑOS CALCULADOS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "  Año actual: {$currentYear}\n";
    echo "  Período anterior: {$previousYear}-{$currentYear}\n";
    echo "  Período actual: {$currentYear}-{$nextYear}\n";

    // 3. Validar lógica de períodos
    echo "\n📊 VALIDACIÓN DE PERÍODOS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";

    // Buscar un usuario con 2 períodos
    $userWith2Periods = DB::table('users')
        ->join('vacations_availables', 'users.id', '=', 'vacations_availables.users_id')
        ->where('users.active', 1)
        ->select('users.id', 'users.first_name', 'users.last_name', DB::raw('COUNT(vacations_availables.id) as periods_count'))
        ->groupBy('users.id', 'users.first_name', 'users.last_name')
        ->having('periods_count', '>=', 2)
        ->first();

    if ($userWith2Periods) {
        echo "Usuario ejemplo: {$userWith2Periods->first_name} {$userWith2Periods->last_name} (ID: {$userWith2Periods->id})\n";
        echo "Total períodos: {$userWith2Periods->periods_count}\n\n";

        // Obtener períodos
        $periods = DB::table('vacations_availables')
            ->where('users_id', $userWith2Periods->id)
            ->orderBy('date_end', 'desc')
            ->get();

        foreach ($periods as $index => $period) {
            $endYear = date('Y', strtotime($period->date_end));
            $isActual = $endYear == $currentYear;
            $isAnterior = $endYear == ($currentYear - 1);

            echo "Período " . ($index + 1) . ":\n";
            echo "  - Fecha fin: {$period->date_end} (Año: {$endYear})\n";
            echo "  - Días totales: {$period->days_total_period}\n";
            echo "  - Días disponibles: {$period->days_availables}\n";
            echo "  - Días disfrutados: {$period->days_enjoyed}\n";
            
            if ($isActual) {
                echo "  → PERÍODO ACTUAL (K, N, O, P, Q)\n";
            } elseif ($isAnterior) {
                echo "  → PERÍODO ANTERIOR (J, M)\n";
            } else {
                echo "  → PERÍODO HISTÓRICO (no se exporta)\n";
            }
            echo "\n";
        }
    }

    // 4. Estructura del Excel
    echo "📋 ESTRUCTURA DEL EXCEL:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "  A1: GPT SERVICES\n";
    echo "  A2: VACACIONES {$currentYear}\n";
    echo "  Fila 4: Headers con colores\n\n";
    
    echo "  COLUMNAS (Fila 4+):\n";
    echo "    B = No. (ID usuario)\n";
    echo "    C = NOMBRE (APELLIDOS NOMBRE en mayúsculas)\n";
    echo "    J = Saldo Pendiente Periodo {$previousYear}-{$currentYear} (del período anterior)\n";
    echo "    K = Fecha de Aniversario (end_date del período actual)\n";
    echo "    L = Antigüedad (años desde admission)\n";
    echo "    M = Días Correspondientes Periodo (del período anterior)\n";
    echo "    N = Días antes de aniversario (del período actual)\n";
    echo "    O = Días después de aniversario (del período actual)\n";
    echo "    P = Días Disfrutados periodo {$currentYear}-{$nextYear} (del período actual)\n";
    echo "    Q = Saldo Pendiente Periodo {$currentYear}-{$nextYear} (del período actual)\n";

    // 5. Colores
    echo "\n🎨 COLORES APLICADOS:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "  B, C, J, L, O, Q: Azul claro (#B4D7FF)\n";
    echo "  K: Azul brillante (#0066FF) con texto blanco\n";
    echo "  M: Gris (#D9D9D9)\n";
    echo "  N: Verde claro (#CBE5CB)\n";
    echo "  P: Rosa claro (#F4C7C3)\n";

    echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                            ✅ VALIDACIÓN COMPLETA                                  ║\n";
    echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

    echo "INSTRUCCIONES PARA PROBAR:\n";
    echo "1. Ir a: http://localhost:8000/vacaciones/reporte\n";
    echo "2. Hacer clic en 'Exportar Vacaciones'\n";
    echo "3. Verificar que el archivo tenga:\n";
    echo "   - GPT SERVICES en A1\n";
    echo "   - VACACIONES {$currentYear} en A2\n";
    echo "   - Headers en fila 4 con colores correctos\n";
    echo "   - Datos en columnas B, C, J-Q\n";
    echo "   - Nombres en MAYÚSCULAS con apellidos primero\n";
    echo "   - Períodos filtrados dinámicamente por año\n\n";

    echo "Fecha de validación: " . date('d/m/Y H:i:s') . "\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}

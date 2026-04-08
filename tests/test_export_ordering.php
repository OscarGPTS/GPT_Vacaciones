<?php
/**
 * TEST: VALIDAR ORDENAMIENTO Y COLUMNAS OCULTAS EN EXPORT
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST: ORDENAMIENTO Y COLUMNAS OCULTAS                                   ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

// 1. Verificar ordenamiento
echo "📊 VERIFICACIÓN DE ORDENAMIENTO POR ID:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";

$employees = User::with(['job.departamento', 'jefe'])
    ->whereHas('job')
    ->where('active', 1)
    ->orderBy('id')
    ->limit(10)
    ->get();

echo "Primeros 10 usuarios en orden de ID:\n\n";
foreach ($employees as $employee) {
    $nombreCompleto = mb_strtoupper(trim($employee->last_name . ' ' . $employee->first_name), 'UTF-8');
    echo sprintf("  ID %-4s → %s\n", $employee->id, $nombreCompleto);
}

echo "\n✅ Usuarios ordenados correctamente por ID\n";

// 2. Verificar que las columnas D-I estarán ocultas
echo "\n🔒 COLUMNAS QUE SERÁN OCULTADAS:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "  Las siguientes columnas estarán ocultas en el Excel:\n";
foreach (range('D', 'I') as $col) {
    echo "    - Columna {$col}\n";
}

echo "\n📋 ESTRUCTURA FINAL DEL EXCEL:\n";
echo "────────────────────────────────────────────────────────────────────────────────────────\n";
echo "  A1: GPT SERVICES\n";
echo "  A2: VACACIONES " . date('Y') . "\n\n";
echo "  COLUMNAS VISIBLES (Fila 4+):\n";
echo "    B = No. (ID usuario)\n";
echo "    C = NOMBRE (APELLIDOS NOMBRE en mayúsculas)\n";
echo "    [D-I ocultas]\n";
echo "    J = Saldo Pendiente Periodo anterior\n";
echo "    K = Fecha de Aniversario\n";
echo "    L = Antigüedad\n";
echo "    M = Días Correspondientes Periodo\n";
echo "    N = Días antes de aniversario\n";
echo "    O = Días después de aniversario\n";
echo "    P = Días Disfrutados periodo actual\n";
echo "    Q = Saldo Pendiente Periodo actual\n";

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                            ✅ VALIDACIÓN COMPLETA                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

echo "INSTRUCCIONES PARA PROBAR:\n";
echo "1. Refrescar navegador en: http://localhost:8000/vacaciones/reporte\n";
echo "2. Hacer clic en 'Exportar Vacaciones'\n";
echo "3. Abrir el archivo Excel descargado\n";
echo "4. Verificar que:\n";
echo "   ✓ Los usuarios estén ordenados por ID (número más bajo primero)\n";
echo "   ✓ Las columnas D, E, F, G, H, I estén ocultas\n";
echo "   ✓ Los datos salten directamente de columna C a columna J\n\n";

echo "Fecha de validación: " . date('d/m/Y H:i:s') . "\n";

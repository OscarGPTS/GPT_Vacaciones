<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SystemLog;
use App\Models\User;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║              TEST: SISTEMA DE LOGS                             ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// 1. Crear logs de prueba
echo "📝 CREANDO LOGS DE PRUEBA...\n";
echo str_repeat("─", 70) . "\n";

$testUser = User::where('active', 1)->first();

// Error de importación
$log1 = SystemLog::logError(
    'vacation_import',
    'Usuario no encontrado en la base de datos',
    null,
    ['nombre_completo' => 'PRUEBA TEST USUARIO', 'numero_empleado' => '999']
);
echo "✓ Log #1 creado: Error de importación (usuario no identificado)\n";

// Error de período no encontrado
$log2 = SystemLog::logError(
    'vacation_import',
    'No se encontró período con fecha fin 01-06-2026',
    $testUser->id,
    [
        'nombre_completo' => $testUser->full_name,
        'fecha_excel' => '01-06-2026',
        'fecha_admision_real' => '02-06-2021',
    ]
);
echo "✓ Log #2 creado: Error de período no encontrado (user_id: {$testUser->id})\n";

// Warning de usuario inactivo
$log3 = SystemLog::logWarning(
    'vacation_import',
    'Usuario encontrado, pero está en estado inactivo',
    $testUser->id + 1,
    ['nombre_completo' => 'USUARIO INACTIVO PRUEBA']
);
echo "✓ Log #3 creado: Warning de usuario inactivo\n";

// Info
$log4 = SystemLog::logInfo(
    'vacation_period_created',
    'Nuevo período creado exitosamente',
    $testUser->id,
    ['period_id' => 123, 'year' => 2026]
);
echo "✓ Log #4 creado: Info de período creado\n\n";

// 2. Consultar logs
echo "🔍 CONSULTAS DE LOGS:\n";
echo str_repeat("─", 70) . "\n";

$pendingErrors = SystemLog::errors()->pending()->count();
echo "Errores pendientes: {$pendingErrors}\n";

$warnings = SystemLog::warnings()->count();
echo "Advertencias total: {$warnings}\n";

$vacationImportLogs = SystemLog::byType('vacation_import')->count();
echo "Logs de vacation_import: {$vacationImportLogs}\n";

$userLogs = SystemLog::forUser($testUser->id)->count();
echo "Logs del usuario #{$testUser->id}: {$userLogs}\n\n";

// 3. Mostrar logs creados
echo "📋 LOGS CREADOS (ÚLTIMOS 10):\n";
echo str_repeat("─", 70) . "\n";

$logs = SystemLog::with('user')->latest()->limit(10)->get();

foreach ($logs as $log) {
    $userName = $log->user ? $log->user->full_name : 'N/A';
    echo sprintf(
        "ID: %-3d | %-10s | %-20s | User: %-20s\n",
        $log->id,
        strtoupper($log->level),
        $log->type,
        substr($userName, 0, 20)
    );
    echo "      Mensaje: " . substr($log->message, 0, 60) . "\n";
    echo "      Status: {$log->status} | Creado: {$log->created_at->format('Y-m-d H:i')}\n";
    if ($log->context) {
        echo "      Context: " . json_encode($log->context) . "\n";
    }
    echo "\n";
}

// 4. Marcar como resuelto
echo "✅ MARCANDO LOGS COMO RESUELTOS...\n";
echo str_repeat("─", 70) . "\n";

$log2->markAsResolved('Se corrigió manualmente la fecha de aniversario');
echo "✓ Log #{$log2->id} marcado como resuelto\n";

$log3->markAsIgnored('Usuario duplicado, ya se procesó en otro log');
echo "✓ Log #{$log3->id} marcado como ignorado\n\n";

// 5. Estadísticas
echo "📊 ESTADÍSTICAS:\n";
echo str_repeat("─", 70) . "\n";

$stats = [
    'Total logs' => SystemLog::count(),
    'Errores pendientes' => SystemLog::errors()->pending()->count(),
    'Warnings pendientes' => SystemLog::warnings()->pending()->count(),
    'Logs resueltos' => SystemLog::resolved()->count(),
    'Logs ignorados' => SystemLog::where('status', 'ignored')->count(),
];

foreach ($stats as $label => $value) {
    echo str_pad($label . ':', 25) . $value . "\n";
}

echo "\n";

// 6. Errores por tipo
echo "📈 ERRORES POR TIPO:\n";
echo str_repeat("─", 70) . "\n";

$errorsByType = SystemLog::errors()
    ->select('type', \DB::raw('count(*) as total'))
    ->groupBy('type')
    ->get();

foreach ($errorsByType as $item) {
    echo str_pad($item->type . ':', 30) . $item->total . " errores\n";
}

echo "\n";

// 7. Usuarios con más errores
echo "👥 USUARIOS CON MÁS ERRORES PENDIENTES:\n";
echo str_repeat("─", 70) . "\n";

$topUsersWithErrors = SystemLog::errors()
    ->pending()
    ->whereNotNull('user_id')
    ->select('user_id', \DB::raw('count(*) as total'))
    ->groupBy('user_id')
    ->orderBy('total', 'desc')
    ->limit(5)
    ->with('user')
    ->get();

if ($topUsersWithErrors->isEmpty()) {
    echo "No hay usuarios con errores pendientes\n";
} else {
    foreach ($topUsersWithErrors as $item) {
        $userName = $item->user ? $item->user->full_name : 'Usuario desconocido';
        echo sprintf(
            "%-40s %d errores\n",
            substr($userName, 0, 40),
            $item->total
        );
    }
}

echo "\n";

// 8. Limpiar logs de prueba
echo "🧹 LIMPIEZA:\n";
echo str_repeat("─", 70) . "\n";

$idsToDelete = [$log1->id, $log2->id, $log3->id, $log4->id];
SystemLog::whereIn('id', $idsToDelete)->delete();
echo "✓ Logs de prueba eliminados (IDs: " . implode(', ', $idsToDelete) . ")\n";

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ TEST COMPLETADO                          ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

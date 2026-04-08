<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SystemLog;
use App\Models\User;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║     TEST: LOGS DE USUARIOS INACTIVOS CON USER_ID              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// 1. Buscar usuarios inactivos
echo "🔍 BUSCANDO USUARIOS INACTIVOS...\n";
echo str_repeat("─", 70) . "\n";

$inactiveUsers = User::where('active', 2)->take(3)->get();

if ($inactiveUsers->isEmpty()) {
    echo "⚠️  No hay usuarios inactivos en la base de datos.\n";
    echo "   Creando usuario inactivo de prueba...\n\n";
    
    $testUser = User::create([
        'first_name' => 'USUARIO',
        'last_name' => 'INACTIVO PRUEBA',
        'email' => 'test_inactive_' . time() . '@example.com',
        'password' => bcrypt('password'),
        'active' => 2,
        'admission' => '2020-01-15',
    ]);
    
    $inactiveUsers = collect([$testUser]);
    echo "✓ Usuario inactivo creado: ID {$testUser->id}\n\n";
}

foreach ($inactiveUsers as $user) {
    echo sprintf("ID: %-5d | %-40s | Estado: %s\n", 
        $user->id, 
        $user->first_name . ' ' . $user->last_name,
        $user->active == 2 ? 'INACTIVO' : 'ACTIVO'
    );
}

echo "\n";

// 2. Crear logs para usuarios inactivos
echo "📝 CREANDO LOGS DE PRUEBA PARA USUARIOS INACTIVOS...\n";
echo str_repeat("─", 70) . "\n";

$createdLogs = [];

foreach ($inactiveUsers as $user) {
    $log = SystemLog::logError(
        'vacation_import',
        'Usuario encontrado, pero está en estado inactivo, actualiza su estado para poder importarlo e intenta importar las vacaciones nuevamente.',
        $user->id, // IMPORTANTE: Debe tener el user_id
        [
            'nombre_completo' => $user->first_name . ' ' . $user->last_name,
            'user_status' => $user->active,
        ]
    );
    
    $createdLogs[] = $log;
    
    echo sprintf("✓ Log #%-3d creado para usuario ID %-3d (%-30s)\n", 
        $log->id, 
        $user->id,
        substr($user->first_name . ' ' . $user->last_name, 0, 30)
    );
}

echo "\n";

// 3. Verificar logs creados
echo "✅ VERIFICACIÓN DE LOGS:\n";
echo str_repeat("─", 70) . "\n";

$logsWithUserId = SystemLog::byType('vacation_import')
    ->whereNotNull('user_id')
    ->whereIn('id', collect($createdLogs)->pluck('id'))
    ->get();

$logsWithoutUserId = SystemLog::byType('vacation_import')
    ->whereNull('user_id')
    ->whereIn('id', collect($createdLogs)->pluck('id'))
    ->get();

echo "Logs con user_id:    " . $logsWithUserId->count() . " ✓\n";
echo "Logs sin user_id:    " . $logsWithoutUserId->count() . ($logsWithoutUserId->count() > 0 ? ' ⚠️  ERROR' : ' ✓') . "\n";

if ($logsWithoutUserId->count() > 0) {
    echo "\n❌ ERROR: Hay logs sin user_id cuando deberían tenerlo:\n";
    foreach ($logsWithoutUserId as $log) {
        echo "   Log #{$log->id}: {$log->message}\n";
    }
} else {
    echo "\n✓ TODOS LOS LOGS TIENEN user_id CORRECTAMENTE\n";
}

echo "\n";

// 4. Mostrar detalles de logs creados
echo "📋 DETALLES DE LOGS CREADOS:\n";
echo str_repeat("─", 70) . "\n";

foreach ($logsWithUserId as $log) {
    echo "Log ID: {$log->id}\n";
    echo "  User ID: {$log->user_id} ✓\n";
    echo "  Usuario: {$log->user->first_name} {$log->user->last_name}\n";
    echo "  Estado usuario: " . ($log->user->active == 2 ? 'INACTIVO' : 'ACTIVO') . "\n";
    echo "  Mensaje: " . substr($log->message, 0, 50) . "...\n";
    echo "  Context: " . json_encode($log->context) . "\n";
    echo "\n";
}

// 5. Consultar usuarios con incidencias
echo "👥 USUARIOS CON INCIDENCIAS (AGRUPADOS):\n";
echo str_repeat("─", 70) . "\n";

$usersWithIncidents = SystemLog::with('user')
    ->byType('vacation_import')
    ->pending()
    ->whereNotNull('user_id')
    ->get()
    ->groupBy('user_id');

echo "Total de usuarios con incidencias pendientes: " . $usersWithIncidents->count() . "\n\n";

foreach ($usersWithIncidents as $userId => $logs) {
    $user = $logs->first()->user;
    if ($user) {
        echo sprintf("User ID %-3d: %-40s - %d incidencias\n", 
            $userId,
            substr($user->first_name . ' ' . $user->last_name, 0, 40),
            $logs->count()
        );
    }
}

echo "\n";

// 6. Limpiar logs de prueba
echo "🧹 LIMPIEZA:\n";
echo str_repeat("─", 70) . "\n";

$idsToDelete = collect($createdLogs)->pluck('id')->toArray();
SystemLog::whereIn('id', $idsToDelete)->delete();
echo "✓ Logs de prueba eliminados (" . count($idsToDelete) . " logs)\n";

// Eliminar usuario de prueba si fue creado
if (isset($testUser)) {
    $testUser->delete();
    echo "✓ Usuario inactivo de prueba eliminado (ID: {$testUser->id})\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ TEST COMPLETADO                          ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

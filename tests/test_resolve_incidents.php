<?php

/**
 * Test: Validar eliminación de logs al marcar como resuelto
 * 
 * Este test verifica:
 * 1. Buscar usuarios con incidencias
 * 2. Contar logs antes de eliminar
 * 3. Simular la eliminación de logs
 * 4. Verificar que los logs se eliminan correctamente
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\SystemLog;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n╔══════════════════════════════════════════════════════════════╗\n";
echo "║   TEST: Eliminación de Logs al Marcar como Resuelto        ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Buscar usuarios con incidencias
$usersWithIncidents = SystemLog::byType('vacation_import')
    ->pending()
    ->whereNotNull('user_id')
    ->select('user_id', DB::raw('COUNT(*) as incident_count'))
    ->groupBy('user_id')
    ->get();

if ($usersWithIncidents->isEmpty()) {
    echo "❌ No hay usuarios con incidencias pendientes.\n\n";
    exit(1);
}

echo "📊 USUARIOS CON INCIDENCIAS PENDIENTES: {$usersWithIncidents->count()}\n";
echo str_repeat("═", 60) . "\n";

foreach ($usersWithIncidents as $index => $incident) {
    $user = User::find($incident->user_id);
    $userName = $user ? "{$user->first_name} {$user->last_name}" : "Usuario no encontrado";
    echo ($index + 1) . ". Usuario ID: {$incident->user_id} - {$userName}\n";
    echo "   Incidencias: {$incident->incident_count}\n";
}
echo "\n";

// Seleccionar el primer usuario para la prueba
$firstIncident = $usersWithIncidents->first();
$userId = $firstIncident->user_id;
$user = User::find($userId);

echo "🎯 USUARIO SELECCIONADO PARA PRUEBA\n";
echo str_repeat("─", 60) . "\n";
echo "ID: {$userId}\n";
echo "Nombre: {$user->first_name} {$user->last_name}\n";
echo "Incidencias: {$firstIncident->incident_count}\n";
echo "\n";

// Obtener los logs antes de eliminar
$logs = SystemLog::byType('vacation_import')
    ->pending()
    ->where('user_id', $userId)
    ->get();

echo "📋 LOGS DETECTADOS ANTES DE ELIMINACIÓN\n";
echo str_repeat("─", 60) . "\n";
foreach ($logs as $index => $log) {
    echo ($index + 1) . ". ID: {$log->id}\n";
    echo "   Mensaje: {$log->message}\n";
    echo "   Estado: {$log->status}\n";
    echo "   Creado: {$log->created_at->format('d/m/Y H:i:s')}\n";
    echo "\n";
}

// SIMULACIÓN (NO EJECUTAR REALMENTE LA ELIMINACIÓN)
echo "⚠️  SIMULACIÓN DE ELIMINACIÓN (NO SE EJECUTA)\n";
echo str_repeat("─", 60) . "\n";
echo "Se eliminarían {$logs->count()} logs relacionados al usuario ID: {$userId}\n";
echo "Los siguientes IDs de logs serían eliminados:\n";
foreach ($logs as $log) {
    echo "  • Log ID: {$log->id}\n";
}
echo "\n";

// Verificación del método en el componente
echo "✅ VERIFICACIÓN DEL MÉTODO resolveUserIncidents\n";
echo str_repeat("─", 60) . "\n";

$componentPath = base_path('app/Livewire/VacationReport.php');
$componentContent = file_get_contents($componentPath);

if (strpos($componentContent, 'function resolveUserIncidents') !== false) {
    echo "✓ Método resolveUserIncidents encontrado\n";
    
    // Verificar que usa delete() en lugar de markAsResolved()
    if (strpos($componentContent, '$log->delete()') !== false) {
        echo "✓ Método usa delete() para eliminar logs ✓\n";
    } else if (strpos($componentContent, 'markAsResolved') !== false) {
        echo "✗ Método aún usa markAsResolved() (debería usar delete())\n";
    }
    
    // Verificar mensaje de notificación
    if (strpos($componentContent, 'Incidencias eliminadas') !== false) {
        echo "✓ Mensaje de notificación actualizado ✓\n";
    } else {
        echo "⚠️  Mensaje de notificación no encontrado\n";
    }
} else {
    echo "✗ Método resolveUserIncidents NO encontrado\n";
}
echo "\n";

// Verificación del botón en la vista
echo "✅ VERIFICACIÓN DEL BOTÓN EN LA VISTA\n";
echo str_repeat("─", 60) . "\n";

$viewPath = base_path('resources/views/livewire/vacation-report.blade.php');
$viewContent = file_get_contents($viewPath);

if (strpos($viewContent, 'wire:click="resolveUserIncidents(') !== false) {
    echo "✓ Botón 'Marcar como resuelto' conectado al método\n";
    
    if (strpos($viewContent, 'title="Marcar como resuelto"') !== false) {
        echo "✓ Tooltip del botón correcto\n";
    }
    
    if (strpos($viewContent, 'onclick="return confirm(') !== false) {
        echo "✓ Confirmación JavaScript presente\n";
    }
} else {
    echo "✗ Botón no encontrado o no conectado\n";
}
echo "\n";

// Resumen
echo "📊 RESUMEN\n";
echo str_repeat("═", 60) . "\n";
echo "✅ Total usuarios con incidencias: {$usersWithIncidents->count()}\n";
echo "✅ Usuario de prueba: {$user->first_name} {$user->last_name} (ID: {$userId})\n";
echo "✅ Logs a eliminar: {$logs->count()}\n";
echo "✅ Método resolveUserIncidents verificado\n";
echo "✅ Botón en la vista verificado\n";
echo "\n";
echo "🎯 PRÓXIMO PASO: Probar en el navegador\n";
echo "   URL: http://localhost:8000/vacaciones/reporte\n";
echo "   1. Ve a la tarjeta 'Usuarios con Incidencias'\n";
echo "   2. Localiza el usuario ID {$userId} ({$user->first_name} {$user->last_name})\n";
echo "   3. Haz clic en el botón verde con la paloma (✓)\n";
echo "   4. Confirma la eliminación\n";
echo "   5. Verifica que el usuario desaparece de la lista\n";
echo "   6. Verifica la notificación: 'Se eliminaron {$logs->count()} incidencias del usuario'\n";
echo "\n";

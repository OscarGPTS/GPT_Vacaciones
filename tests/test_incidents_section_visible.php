<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SystemLog;
use App\Models\User;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║       TEST: SECCIÓN DE INCIDENCIAS SIEMPRE VISIBLE            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Verificar que hay usuarios con incidencias
echo "📊 VERIFICANDO USUARIOS CON INCIDENCIAS:\n";
echo str_repeat("─", 70) . "\n";

$usersWithIncidents = SystemLog::errors()
    ->pending()
    ->byType('vacation_import')
    ->whereNotNull('user_id')
    ->with('user')
    ->get()
    ->groupBy('user_id');

echo "Total de usuarios con incidencias: " . $usersWithIncidents->count() . "\n\n";

if ($usersWithIncidents->isEmpty()) {
    echo "⚠️  NO HAY USUARIOS CON INCIDENCIAS\n";
    echo "La sección de incidencias NO se mostrará en la vista.\n\n";
} else {
    echo "✅ HAY USUARIOS CON INCIDENCIAS\n";
    echo "La sección de incidencias estará visible en la vista.\n\n";
    
    echo "📋 LISTA DE USUARIOS CON INCIDENCIAS:\n";
    echo str_repeat("─", 70) . "\n";
    
    foreach ($usersWithIncidents as $userId => $logs) {
        $user = User::find($userId);
        if ($user) {
            echo sprintf(
                "ID: %-3d | %-35s | Errores: %d\n",
                $user->id,
                substr($user->first_name . ' ' . $user->last_name, 0, 35),
                $logs->count()
            );
            
            // Mostrar primer error
            $firstLog = $logs->first();
            echo "         └─ " . substr($firstLog->message, 0, 60) . "\n";
        }
    }
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    COMPORTAMIENTO ESPERADO                     ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "1. La sección de incidencias está SIEMPRE VISIBLE cuando hay errores\n";
echo "2. Usa un acordeón de Bootstrap (colapsable)\n";
echo "3. Está EXPANDIDA por defecto (class=\"collapse show\")\n";
echo "4. El usuario puede colapsar/expandir haciendo clic en el header\n";
echo "5. NO requiere hacer clic en un botón separado\n\n";

echo "🔗 Para verificar visualmente:\n";
echo "   http://localhost:8000/vacaciones/reporte\n\n";

if ($usersWithIncidents->isNotEmpty()) {
    echo "✅ Deberías ver la sección \"Usuarios con Incidencias\" expandida\n";
    echo "   con un fondo amarillo claro y un icono de advertencia.\n";
} else {
    echo "ℹ️  La sección NO aparecerá porque no hay incidencias pendientes.\n";
    echo "   Importa un archivo Excel con errores para ver la sección.\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ TEST COMPLETADO                          ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

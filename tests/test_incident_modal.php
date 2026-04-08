<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SystemLog;
use App\Models\User;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║     TEST: MODAL DE EDICIÓN DE INCIDENCIAS - FUNCIONAMIENTO    ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// 1. Verificar usuarios con incidencias pendientes
echo "📋 VERIFICANDO USUARIOS CON INCIDENCIAS:\n";
echo str_repeat("─", 70) . "\n";

$usersWithIncidents = SystemLog::byType('vacation_import')
    ->pending()
    ->whereNotNull('user_id')
    ->select('user_id', \DB::raw('count(*) as error_count'))
    ->groupBy('user_id')
    ->with('user')
    ->get();

echo "Total de usuarios con incidencias: " . $usersWithIncidents->count() . "\n\n";

if ($usersWithIncidents->count() > 0) {
    echo "Usuarios con errores pendientes:\n";
    foreach ($usersWithIncidents as $incident) {
        $user = $incident->user;
        if (!$user) continue;
        
        echo sprintf(
            "  ID %d: %-40s  %d error(es)\n",
            $user->id,
            substr($user->first_name . ' ' . $user->last_name, 0, 40),
            $incident->error_count
        );
        
        // Obtener último error
        $latestLog = SystemLog::byType('vacation_import')
            ->pending()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($latestLog) {
            echo "         └─ Último error: " . substr($latestLog->message, 0, 60) . "...\n";
        }
    }
    echo "\n";
} else {
    echo "✓ No hay usuarios con incidencias pendientes\n\n";
}

// 2. Simular apertura de modal (datos que se cargarían)
if ($usersWithIncidents->count() > 0) {
    $testUser = $usersWithIncidents->first()->user;
    
    echo "🔍 SIMULANDO APERTURA DE MODAL PARA USUARIO #{$testUser->id}:\n";
    echo str_repeat("─", 70) . "\n";
    
    $userWithRelations = User::with(['job.departamento'])->find($testUser->id);
    
    echo "Información General (Readonly):\n";
    echo "  - ID: {$userWithRelations->id}\n";
    echo "  - Nombre: {$userWithRelations->first_name} {$userWithRelations->last_name}\n";
    echo "  - Puesto: " . ($userWithRelations->job ? $userWithRelations->job->name : 'Sin puesto') . "\n";
    echo "  - Departamento: " . ($userWithRelations->job && $userWithRelations->job->departamento ? $userWithRelations->job->departamento->name : 'Sin departamento') . "\n";
    echo "\n";
    
    echo "Campos Editables (Corregir):\n";
    echo "  - Fecha de Admisión: " . ($userWithRelations->admission ? \Carbon\Carbon::parse($userWithRelations->admission)->format('d/m/Y') : 'Sin fecha') . "\n";
    echo "  - Estado: " . ($userWithRelations->active == 1 ? 'Activo' : 'Inactivo') . "\n";
    echo "\n";
    
    $userLogs = SystemLog::byType('vacation_import')
        ->pending()
        ->where('user_id', $testUser->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    echo "Errores Detectados ({$userLogs->count()}):\n";
    foreach ($userLogs as $index => $log) {
        echo "  " . ($index + 1) . ". " . $log->message . "\n";
    }
    echo "\n";
}

// 3. Verificar estructura del componente
echo "🔧 VERIFICANDO PROPIEDADES DEL COMPONENTE:\n";
echo str_repeat("─", 70) . "\n";

$componentFile = file_get_contents(__DIR__ . '/../app/Livewire/VacationReport.php');

$properties = [
    'showEditIncidentModal' => 'Mostrar modal',
    'editingIncidentUserId' => 'ID del usuario editando',
    'editingIncidentUser' => 'Objeto usuario editando',
    'editingIncidentLogs' => 'Logs del usuario',
    'editingAdmission' => 'Fecha de admisión temporal',
    'editingStatus' => 'Estado temporal',
];

$methods = [
    'openEditIncidentModal' => 'Abrir modal de edición',
    'closeEditIncidentModal' => 'Cerrar modal de edición',
    'saveIncidentUser' => 'Guardar cambios y resolver logs',
];

echo "Propiedades definidas:\n";
foreach ($properties as $prop => $desc) {
    $found = strpos($componentFile, '$' . $prop) !== false;
    $status = $found ? '✓' : '✗';
    echo "  {$status} \${$prop} - {$desc}\n";
}

echo "\nMétodos definidos:\n";
foreach ($methods as $method => $desc) {
    $found = strpos($componentFile, 'function ' . $method) !== false;
    $status = $found ? '✓' : '✗';
    echo "  {$status} {$method}() - {$desc}\n";
}

echo "\n";

// 4. Verificar vista blade
echo "🎨 VERIFICANDO VISTA BLADE:\n";
echo str_repeat("─", 70) . "\n";

$viewFile = file_get_contents(__DIR__ . '/../resources/views/livewire/vacation-report.blade.php');

$bladeElements = [
    'Modal de Edición de Incidencias' => 'showEditIncidentModal',
    'Botón Guardar y Resolver' => 'saveIncidentUser',
    'Campos readonly (ID, Nombre, Puesto)' => 'readonly',
    'Campos editables resaltados' => 'border-warning',
    'Lista de errores' => 'editingIncidentLogs',
];

echo "Elementos en la vista:\n";
foreach ($bladeElements as $desc => $search) {
    $found = strpos($viewFile, $search) !== false;
    $status = $found ? '✓' : '✗';
    echo "  {$status} {$desc}\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ VERIFICACIÓN COMPLETADA                  ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";

echo "\n💡 INSTRUCCIONES DE USO:\n";
echo str_repeat("─", 70) . "\n";
echo "1. Accede a: http://localhost:8000/vacaciones/reporte\n";
echo "2. Si hay incidencias, verás la tarjeta 'Usuarios con Incidencias'\n";
echo "3. Haz clic en el botón de 'Editar' (ícono lápiz)\n";
echo "4. Se abrirá un modal con:\n";
echo "   - Información general del usuario (readonly)\n";
echo "   - Fecha de admisión y estado (editables, resaltados)\n";
echo "   - Lista de todos los errores detectados\n";
echo "5. Corrige los datos y haz clic en 'Guardar y Resolver Incidencias'\n";
echo "6. Los errores se marcarán automáticamente como resueltos\n";
echo "\n👉 Mensaje en importación:\n";
echo "   Cuando haya errores en /vacaciones/importar, se mostrará un mensaje\n";
echo "   claro indicando que pueden resolverse desde el reporte de vacaciones.\n";

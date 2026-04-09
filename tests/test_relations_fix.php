<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\RequestVacations;

echo "=== Verificando relaciones de RequestVacations ===\n\n";

$r = new RequestVacations;
$r->user_id = 13;
$r->direct_manager_id = 14;

$relations = ['user', 'directManager', 'directionApprover', 'reveal', 'createdBy'];

foreach ($relations as $name) {
    $rel = $r->$name();
    $isValid = $rel instanceof \Illuminate\Database\Eloquent\Relations\Relation;
    $type = get_class($rel);
    echo ($isValid ? '✅' : '❌') . " {$name}() => {$type}\n";
}

echo "\n=== Test load() con directManager ===\n";
try {
    // Simular lo que hace el controlador
    $testRequest = RequestVacations::first();
    if ($testRequest) {
        $testRequest->load('directManager');
        echo "✅ load('directManager') funciona correctamente\n";
        echo "   Manager: " . ($testRequest->directManager ? $testRequest->directManager->nombre() : 'N/A') . "\n";
    } else {
        // Si no hay datos, al menos verificar que la relación es válida
        echo "⚠️  No hay solicitudes, pero la relación es válida\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ VERIFICACIÓN COMPLETA\n";

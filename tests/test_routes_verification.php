<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║              TEST: VERIFICACIÓN DE RUTAS                       ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Rutas críticas a verificar
$routesToCheck = [
    'vacaciones.index',
    'vacaciones.importar',
    'vacaciones.reporte',
    'admin.index',
    'vacaciones.direccion',
    'vacaciones.rh',
];

echo "🔍 VERIFICANDO RUTAS CRÍTICAS:\n";
echo str_repeat("─", 70) . "\n";

$allOk = true;

foreach ($routesToCheck as $routeName) {
    try {
        $url = route($routeName);
        echo sprintf("✓ %-30s → %s\n", $routeName, $url);
    } catch (\Exception $e) {
        echo sprintf("✗ %-30s → ERROR: %s\n", $routeName, $e->getMessage());
        $allOk = false;
    }
}

echo "\n";

if ($allOk) {
    echo "╔════════════════════════════════════════════════════════════════╗\n";
    echo "║              ✅ TODAS LAS RUTAS FUNCIONAN CORRECTAMENTE        ║\n";
    echo "╚════════════════════════════════════════════════════════════════╝\n";
} else {
    echo "╔════════════════════════════════════════════════════════════════╗\n";
    echo "║              ⚠️  HAY RUTAS CON ERRORES                         ║\n";
    echo "╚════════════════════════════════════════════════════════════════╝\n";
}

echo "\n📊 RUTAS DE VACACIONES DISPONIBLES:\n";
echo str_repeat("─", 70) . "\n";

$routes = Route::getRoutes();
$vacationRoutes = [];

foreach ($routes as $route) {
    $name = $route->getName();
    if ($name && str_starts_with($name, 'vacaciones.')) {
        $vacationRoutes[] = [
            'name' => $name,
            'uri' => $route->uri(),
            'methods' => implode('|', $route->methods()),
        ];
    }
}

foreach ($vacationRoutes as $route) {
    echo sprintf("%-35s %-15s %s\n", $route['name'], $route['methods'], $route['uri']);
}

echo "\n";

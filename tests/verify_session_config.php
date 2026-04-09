<?php

/**
 * Script para verificar la configuración de sesiones
 * Ejecutar: php tests/verify_session_config.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n🔍 VERIFICANDO CONFIGURACIÓN DE SESIONES\n";
echo str_repeat("=", 60) . "\n\n";

// 1. Configuración de sesión
echo "📋 CONFIGURACIÓN DE SESIÓN:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutos\n";
echo "   Path: " . config('session.path') . "\n";
echo "   Domain: " . config('session.domain') . "\n";
echo "   Secure: " . (config('session.secure') ? '✅ true' : '❌ false') . "\n";
echo "   HTTP Only: " . (config('session.http_only') ? '✅ true' : '❌ false') . "\n";
echo "   Same Site: " . config('session.same_site') . "\n\n";

// 2. Verificar directorio de sesiones
$sessionPath = storage_path('framework/sessions');
echo "📁 DIRECTORIO DE SESIONES:\n";
echo "   Path: $sessionPath\n";
echo "   Existe: " . (is_dir($sessionPath) ? '✅ Si' : '❌ No') . "\n";
echo "   Escribible: " . (is_writable($sessionPath) ? '✅ Si' : '❌ No') . "\n";

if (is_dir($sessionPath)) {
    $sessionFiles = glob($sessionPath . '/*');
    echo "   Archivos de sesión: " . count($sessionFiles) . "\n";
    
    if (count($sessionFiles) > 0) {
        echo "   Sesiones recientes:\n";
        $recentSessions = array_slice($sessionFiles, -5);
        foreach ($recentSessions as $file) {
            $mtime = filemtime($file);
            $age = time() - $mtime;
            echo "      - " . basename($file) . " (hace " . gmdate('H:i:s', $age) . ")\n";
        }
    }
}
echo "\n";

// 3. Middleware de sesión
echo "🔧 MIDDLEWARE:\n";
$middleware = config('app.middleware');
$webMiddleware = config('app.middleware_groups.web') ?? [];
echo "   Web middleware group:\n";
foreach ($webMiddleware as $mw) {
    $name = is_string($mw) ? $mw : get_class($mw);
    $isSession = str_contains($name, 'StartSession');
    echo "      " . ($isSession ? '✅' : '  ') . " $name\n";
}
echo "\n";

// 4. Variables de entorno críticas
echo "🌐 VARIABLES DE ENTORNO:\n";
echo "   APP_URL: " . env('APP_URL') . "\n";
echo "   SESSION_DRIVER: " . env('SESSION_DRIVER') . "\n";
echo "   SESSION_SECURE_COOKIE: " . env('SESSION_SECURE_COOKIE') . "\n";
echo "   SESSION_SAME_SITE: " . env('SESSION_SAME_SITE') . "\n";
echo "   FORCE_HTTPS: " . env('FORCE_HTTPS') . "\n\n";

// 5. Verificar ruta de callback
echo "🔗 RUTAS DE AUTENTICACIÓN:\n";
$routes = app('router')->getRoutes();
foreach ($routes as $route) {
    $uri = $route->uri();
    if (str_contains($uri, 'login/google')) {
        $middleware = implode(', ', $route->middleware());
        echo "   $uri\n";
        echo "      Middleware: $middleware\n";
        echo "      Tiene 'web': " . (str_contains($middleware, 'web') ? '✅ Si' : '❌ No') . "\n";
    }
}
echo "\n";

// 6. Recomendaciones
echo "💡 RECOMENDACIONES:\n";
$warnings = [];

if (!config('session.secure') && str_contains(env('APP_URL', ''), 'https://')) {
    $warnings[] = "SESSION_SECURE_COOKIE debería estar en true para HTTPS";
}

if (config('session.driver') === 'file' && !is_writable($sessionPath)) {
    $warnings[] = "El directorio de sesiones no es escribible";
}

$hasStartSession = false;
foreach ($webMiddleware as $mw) {
    if (str_contains(is_string($mw) ? $mw : get_class($mw), 'StartSession')) {
        $hasStartSession = true;
        break;
    }
}
if (!$hasStartSession) {
    $warnings[] = "El middleware StartSession no está en el grupo 'web'";
}

if (empty($warnings)) {
    echo "   ✅ Todo parece estar bien configurado\n";
} else {
    foreach ($warnings as $warning) {
        echo "   ⚠️ $warning\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✅ Verificación completada\n\n";

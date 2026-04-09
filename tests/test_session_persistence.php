<?php

/**
 * Script para probar la persistencia de sesión manualmente
 * Ejecutar: php tests/test_session_persistence.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "\n🧪 PROBANDO PERSISTENCIA DE SESIÓN\n";
echo str_repeat("=", 60) . "\n\n";

// Crear una request simulada
use Illuminate\Http\Request;
use Illuminate\Session\Store;

$request = Request::create('https://vacaciones.tech-energy.lat/test', 'GET');

// Iniciar la sesión manualmente usando el SessionManager
$sessionManager = $app->make('session');
$session = $sessionManager->driver();
$session->setId($session->getId() ?: \Illuminate\Support\Str::random(40));
$session->start();

$sessionId = $session->getId();
echo "📋 Session ID creado: $sessionId\n\n";

// Guardar un valor en la sesión
$testKey = 'test_oauth_' . time();
$testValue = 'Test Value ' . rand(1000, 9999);
$session->put($testKey, $testValue);
echo "💾 Guardando en sesión:\n";
echo "   Clave: $testKey\n";
echo "   Valor: $testValue\n\n";

// Guardar la sesión en disco
$session->save();
echo "✅ Sesión guardada en disco\n\n";

// Verificar que el archivo se creó
$sessionPath = storage_path('framework/sessions');
$sessionFile = $sessionPath . '/' . $session->getId();

echo "📁 Verificando archivo de sesión:\n";
echo "   Path: $sessionFile\n";

if (file_exists($sessionFile)) {
    echo "   ✅ Archivo existe\n";
    $fileSize = filesize($sessionFile);
    echo "   Tamaño: $fileSize bytes\n";
    $content = file_get_contents($sessionFile);
    echo "   Contenido (primeros 200 chars):\n";
    echo "   " . substr($content, 0, 200) . "...\n\n";
} else {
    echo "   ❌ Archivo NO existe\n\n";
}

// Simular una segunda request (como el callback de OAuth)
echo "🔄 Simulando nueva request (como callback de OAuth)...\n\n";

// Crear una nueva sesión con el mismo ID
$newSession = $app->make('session')->driver();
$newSession->setId($sessionId);
$newSession->start();

echo "📋 Session ID de nueva request: " . $newSession->getId() . "\n";
echo "   ¿Es el mismo ID? " . ($newSession->getId() === $sessionId ? '✅ Si' : '❌ No') . "\n\n";

// Intentar recuperar el valor
$retrievedValue = $newSession->get($testKey);
echo "🔍 Intentando recuperar valor:\n";
echo "   Clave buscada: $testKey\n";
echo "   Valor recuperado: " . ($retrievedValue ?? 'NULL') . "\n";
echo "   ¿Coincide? " . ($retrievedValue === $testValue ? '✅ Si' : '❌ No') . "\n\n";

// Probar Auth::login() simulado
echo "🔓 Probando simulación de Auth::login()...\n";

$user = \App\Models\User::where('active', 1)->first();

if (!$user) {
    echo "   ❌ No se encontró ningún usuario activo para probar\n\n";
} else {
    echo "   Usuario de prueba: {$user->id} - {$user->email}\n";
    
    // Guardar el ID del usuario en la sesión (esto es lo que hace Auth::login internamente)
    $authKey = 'login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d';
    $newSession->put($authKey, $user->id);
    $newSession->save();
    
    echo "   💾 ID de usuario guardado en sesión\n";
    echo "   Clave: $authKey\n";
    echo "   User ID: {$user->id}\n\n";
    
    // Simular OTRA request (después del login)
    echo "🔄 Simulando request después de login...\n";
    
    $thirdSession = $app->make('session')->driver();
    $thirdSession->setId($sessionId);
    $thirdSession->start();
    
    $retrievedUserId = $thirdSession->get($authKey);
    echo "   Session ID: " . $thirdSession->getId() . "\n";
    echo "   User ID recuperado: " . ($retrievedUserId ?? 'NULL') . "\n";
    echo "   ¿Usuario autenticado? " . ($retrievedUserId === $user->id ? '✅ Si' : '❌ No') . "\n\n";
}

// Limpiar
$newSession->forget($testKey);
if (isset($authKey)) {
    $newSession->forget($authKey);
}
$newSession->save();

echo str_repeat("=", 60) . "\n";

// Diagnóstico final
echo "\n💡 DIAGNÓSTICO:\n\n";

if (!file_exists($sessionFile)) {
    echo "❌ PROBLEMA: Los archivos de sesión no se están creando\n";
    echo "   Verifica permisos de escritura en $sessionPath\n\n";
} elseif ($retrievedValue !== $testValue) {
    echo "❌ PROBLEMA: La sesión no persiste entre requests\n";
    echo "   El archivo se crea pero no se puede leer correctamente\n";
    echo "   Puede ser un problema de configuración de sesión\n\n";
} elseif (isset($retrievedUserId) && $retrievedUserId !== $user->id) {
    echo "❌ PROBLEMA: Auth no persiste entre requests\n";
    echo "   La sesión funciona pero el ID de usuario no se guarda\n";
    echo "   Revisa el middleware StartSession en el grupo 'web'\n\n";
} else {
    echo "✅ TODO FUNCIONA: Las sesiones persisten correctamente\n";
    echo "   El problema debe estar en otra parte del flujo OAuth\n\n";
    echo "   Posibles causas:\n";
    echo "   - Las cookies no se envían correctamente por HTTPS\n";
    echo "   - El navegador no acepta cookies del tunnel\n";
    echo "   - Hay un redirect que pierde la sesión\n";
    echo "   - El middleware no se aplica a las rutas de OAuth\n\n";
}

echo "✅ Prueba completada\n\n";

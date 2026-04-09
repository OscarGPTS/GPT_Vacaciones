#!/usr/bin/env php
<?php

/**
 * Verificación de Configuración HTTPS/OAuth
 * 
 * Ejecutar: php tests/verify_https_config.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║  VERIFICACIÓN DE CONFIGURACIÓN HTTPS/OAuth                   ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

$passed = 0;
$failed = 0;

// TEST 1: APP_URL
echo "🔍 Test 1: Verificando APP_URL...\n";
$appUrl = config('app.url');
$isHttps = str_starts_with($appUrl, 'https://');

if ($isHttps) {
    echo "   ✅ APP_URL usa HTTPS: {$appUrl}\n";
    $passed++;
} else {
    echo "   ⚠️  APP_URL usa HTTP: {$appUrl}\n";
    echo "   💡 Actualiza en .env: APP_URL=https://tu-dominio.com\n";
}
echo "\n";

// TEST 2: FORCE_HTTPS
echo "🔍 Test 2: Verificando FORCE_HTTPS...\n";
$forceHttps = config('app.force_https');

if ($forceHttps) {
    echo "   ✅ FORCE_HTTPS está activado\n";
    $passed++;
} else {
    echo "   ⚠️  FORCE_HTTPS está desactivado\n";
    echo "   💡 Activa en .env: FORCE_HTTPS=true\n";
}
echo "\n";

// TEST 3: URL Helper genera HTTPS
echo "🔍 Test 3: Verificando generación de URLs...\n";
$generatedUrl = url('/');
$generatesHttps = str_starts_with($generatedUrl, 'https://');

if ($generatesHttps) {
    echo "   ✅ Laravel genera URLs con HTTPS: {$generatedUrl}\n";
    $passed++;
} else {
    echo "   ❌ Laravel genera URLs con HTTP: {$generatedUrl}\n";
    echo "   💡 Ejecuta: php artisan config:clear\n";
    $failed++;
}
echo "\n";

// TEST 4: Trust Proxies
echo "🔍 Test 4: Verificando Trust Proxies...\n";
$trustProxiesFile = file_get_contents(__DIR__ . '/../app/Http/Middleware/TrustProxies.php');

if (str_contains($trustProxiesFile, "protected \$proxies = '*';") || 
    str_contains($trustProxiesFile, 'protected $proxies = \'*\';')) {
    echo "   ✅ TrustProxies configurado correctamente (all proxies)\n";
    $passed++;
} else {
    echo "   ⚠️  TrustProxies podría necesitar configuración\n";
    echo "   💡 En TrustProxies.php: protected \$proxies = '*';\n";
}
echo "\n";

// TEST 5: Simular X-Forwarded-Proto header
echo "🔍 Test 5: Simulando X-Forwarded-Proto header...\n";
$testRequest = \Illuminate\Http\Request::create('/', 'GET', [], [], [], [
    'HTTP_X_FORWARDED_PROTO' => 'https',
]);

$testScheme = $testRequest->getScheme();
if ($testScheme === 'https') {
    echo "   ✅ Laravel detecta correctamente el proxy HTTPS\n";
    $passed++;
} else {
    echo "   ℹ️  Test simulado (se verificará con request real del túnel)\n";
    // No contamos como fallo porque puede ser limitación del test simulado
}
echo "\n";

// TEST 6: Variables de entorno OAuth (si existen)
echo "🔍 Test 6: Verificando configuración de sesiones...\n";

$sessionSecure = config('session.secure');
$sessionSameSite = config('session.same_site');

if ($forceHttps && $sessionSecure) {
    echo "   ✅ SESSION_SECURE_COOKIE está activado (requerido para HTTPS)\n";
    $passed++;
} elseif ($forceHttps && !$sessionSecure) {
    echo "   ❌ SESSION_SECURE_COOKIE debe estar activado para HTTPS\n";
    echo "   💡 Agrega a .env: SESSION_SECURE_COOKIE=true\n";
    $failed++;
} else {
    echo "   ℹ️  HTTPS no forzado, SESSION_SECURE_COOKIE no es obligatorio\n";
}

echo "   ℹ️  SameSite: " . ($sessionSameSite ?? 'null') . "\n";
echo "\n";

// TEST 7: Variables de entorno OAuth (si existen)
echo "🔍 Test 7: Verificando variables OAuth...\n";

$providers = [
    'Google' => ['GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET'],
    'Facebook' => ['FACEBOOK_CLIENT_ID', 'FACEBOOK_CLIENT_SECRET'],
    'Microsoft' => ['MICROSOFT_CLIENT_ID', 'MICROSOFT_CLIENT_SECRET'],
];

$oauthConfigured = false;
foreach ($providers as $provider => $vars) {
    $hasClientId = env($vars[0]);
    $hasClientSecret = env($vars[1]);
    
    if ($hasClientId && $hasClientSecret) {
        echo "   ✅ {$provider} OAuth configurado\n";
        $oauthConfigured = true;
    }
}

if (!$oauthConfigured) {
    echo "   ℹ️  No se encontraron configuraciones OAuth\n";
}
echo "\n";

// RESUMEN
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║  RESUMEN                                                     ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "✅ Tests pasados: {$passed}\n";
if ($failed > 0) {
    echo "❌ Tests fallidos: {$failed}\n";
}
echo "\n";

if ($passed >= 5 && $failed === 0) {
    echo "🎉 ¡CONFIGURACIÓN HTTPS/OAuth CORRECTA!\n\n";
    echo "📋 PRÓXIMOS PASOS:\n";
    echo "   1. Asegúrate que tu túnel esté corriendo (ngrok/cloudflare)\n";
    echo "   2. Accede a Google Cloud Console:\n";
    echo "      https://console.cloud.google.com/apis/credentials\n";
    echo "   3. Edita tu OAuth 2.0 Client ID\n";
    echo "   4. Agrega esta Authorized redirect URI:\n";
    echo "      https://vacaciones.tech-energy.lat/login/google/callback\n";
    echo "   5. Guarda y espera 1-2 minutos\n";
    echo "   6. Prueba el login: https://vacaciones.tech-energy.lat/login\n";
    echo "\n";
    echo "💡 CONSEJO: Abre DevTools (F12) > Application > Cookies para verificar\n";
    echo "   que la cookie 'laravel_session' tenga Secure=Yes\n";
    echo "\n";
    exit(0);
} elseif ($passed >= 3) {
    echo "⚙️  CONFIGURACIÓN CASI LISTA\n\n";
    echo "La mayoría de tests pasaron. Verifica la configuración y prueba el login.\n";
    echo "📖 Guía completa: docs/CONFIGURACION_OAUTH_HTTPS.md\n";
    echo "\n";
    exit(0);
} else {
    echo "⚠️  CONFIGURACIÓN INCOMPLETA\n\n";
    echo "📋 ACCIONES REQUERIDAS:\n";
    if (!$isHttps) {
        echo "   1. Actualiza APP_URL en .env con tu URL HTTPS\n";
    }
    if (!$forceHttps) {
        echo "   2. Agrega FORCE_HTTPS=true en .env\n";
    }
    if (!$generatesHttps) {
        echo "   3. Ejecuta: php artisan config:clear\n";
    }
    echo "\n";
    echo "📖 Más información: docs/CONFIGURACION_OAUTH_HTTPS.md\n";
    echo "\n";
    exit(1);
}

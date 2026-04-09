<?php

/**
 * Script para monitorear logs de OAuth en tiempo real
 * Ejecutar: php tests/watch_oauth_logs.php
 * 
 * Presiona Ctrl+C para detener
 */

$logFile = __DIR__ . '/../storage/logs/laravel.log';

if (!file_exists($logFile)) {
    echo "❌ Archivo de logs no encontrado: $logFile\n";
    echo "El archivo se creará automáticamente cuando hagas login.\n";
    exit(1);
}

echo "\n👀 MONITOREANDO LOGS DE OAUTH\n";
echo str_repeat("=", 80) . "\n";
echo "Archivo: $logFile\n";
echo "Esperando eventos de OAuth...\n";
echo "Presiona Ctrl+C para detener\n";
echo str_repeat("=", 80) . "\n\n";

// Mover el puntero al final del archivo
$handle = fopen($logFile, 'r');
fseek($handle, 0, SEEK_END);

$emojis = [
    '🔐' => 'OAuth: Iniciando',
    '🔄' => 'OAuth: Callback',
    '📡' => 'OAuth: Solicitando',
    '✅' => 'OAuth: Éxito',
    '👤' => 'OAuth: Usuario',
    '🔓' => 'OAuth: Login',
    '🔄' => 'OAuth: Sesión',
    '🏠' => 'OAuth: Redirección',
    '↩️' => 'OAuth: Volviendo',
    '🏡' => 'OAuth: Home',
    '⚠️' => 'OAuth: Advertencia',
    '❌' => 'OAuth: Error',
];

while (true) {
    $line = fgets($handle);
    
    if ($line === false) {
        usleep(250000); // 0.25 segundos
        clearstatcache(false, $logFile);
        continue;
    }
    
    // Filtrar solo líneas que contengan emojis de OAuth
    $isOAuthLine = false;
    foreach ($emojis as $emoji => $desc) {
        if (str_contains($line, $emoji)) {
            $isOAuthLine = true;
            break;
        }
    }
    
    if (!$isOAuthLine) {
        continue;
    }
    
    // Colorear y formatear la salida
    $timestamp = date('H:i:s');
    
    // Extraer el mensaje principal (después del timestamp de Laravel)
    if (preg_match('/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\].*?(🔐|🔄|📡|✅|👤|🔓|🏠|↩️|🏡|⚠️|❌)(.*)/', $line, $matches)) {
        $emoji = $matches[2];
        $message = trim($matches[3]);
        
        echo "[$timestamp] $emoji $message\n";
    } else {
        echo "[$timestamp] " . trim($line) . "\n";
    }
    
    flush();
}

fclose($handle);

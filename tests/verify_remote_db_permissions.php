<?php

/**
 * Script para verificar permisos de base de datos remota
 * Ejecutar: php tests/verify_remote_db_permissions.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "\n🔍 VERIFICANDO PERMISOS DE BASE DE DATOS REMOTA\n";
echo str_repeat("=", 70) . "\n\n";

// Información de conexión
$connections = ['mysql', 'mysql_vacations'];

foreach ($connections as $connectionName) {
    echo "📊 CONEXIÓN: $connectionName\n";
    echo str_repeat("-", 70) . "\n";
    
    $config = Config::get("database.connections.$connectionName");
    
    echo "   Host: {$config['host']}:{$config['port']}\n";
    echo "   Base de datos: {$config['database']}\n";
    echo "   Usuario: {$config['username']}\n\n";
    
    // Probar conexión
    echo "   🔌 Probando conexión... ";
    try {
        DB::connection($connectionName)->getPdo();
        echo "✅ Conectado\n\n";
    } catch (\Exception $e) {
        echo "❌ Error de conexión\n";
        echo "   Error: " . $e->getMessage() . "\n\n";
        continue;
    }
    
    // Mostrar información del usuario actual
    echo "   👤 Usuario de base de datos:\n";
    try {
        $currentUser = DB::connection($connectionName)
            ->select("SELECT USER() as user, DATABASE() as db")[0];
        echo "      Usuario actual: {$currentUser->user}\n";
        echo "      Base de datos actual: {$currentUser->db}\n\n";
    } catch (\Exception $e) {
        echo "      ❌ No se pudo obtener información del usuario\n";
        echo "      Error: " . $e->getMessage() . "\n\n";
    }
    
    // Probar permisos de SOLO LECTURA (seguro para producción)
    echo "   🔐 Probando permisos de LECTURA:\n";
    
    echo "      SELECT: ";
    try {
        if ($connectionName === 'mysql') {
            $count = DB::connection($connectionName)->table('users')->count();
            echo "✅ OK (encontrados $count usuarios)\n";
        } else {
            $count = DB::connection($connectionName)->table('requests')->count();
            echo "✅ OK (encontradas $count solicitudes)\n";
        }
    } catch (\Exception $e) {
        echo "❌ Sin permiso\n";
        if (str_contains($e->getMessage(), 'Access denied')) {
            echo "         Error: Acceso denegado a la base de datos\n";
        } else {
            echo "         Error: " . substr($e->getMessage(), 0, 100) . "...\n";
        }
    }
    
    echo "\n";
    
    // Listar tablas (SOLO LECTURA)
    echo "   📋 Tablas principales:\n";
    try {
        if ($connectionName === 'mysql') {
            $tables = ['users', 'jobs', 'departamentos', 'personal_data'];
        } else {
            $tables = ['requests', 'vacations_availables', 'request_approveds', 'request_rejecteds'];
        }
        
        foreach ($tables as $table) {
            try {
                $exists = DB::connection($connectionName)
                    ->select("SELECT 1 FROM $table LIMIT 1");
                echo "      ✅ $table (accesible)\n";
            } catch (\Exception $e) {
                echo "      ⚠️  $table (no accesible o no existe)\n";
            }
        }
    } catch (\Exception $e) {
        echo "      ❌ Error al verificar tablas\n";
        echo "      Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat("-", 70) . "\n\n";
}

// Probar la consulta específica que falla en OAuth
echo "🔍 PRUEBA ESPECÍFICA: Consulta de OAuth\n";
echo str_repeat("-", 70) . "\n\n";

echo "Intentando ejecutar la misma consulta del login OAuth:\n";
echo "SELECT * FROM users WHERE email = ? AND active = 1\n\n";

try {
    $testEmail = 'ochavez@gptservices.com';
    $user = DB::connection('mysql')
        ->table('users')
        ->where('email', $testEmail)
        ->where('active', 1)
        ->first();
    
    if ($user) {
        echo "✅ ÉXITO: Usuario encontrado\n";
        echo "   ID: {$user->id}\n";
        echo "   Email: {$user->email}\n";
        echo "   Nombre: {$user->first_name} {$user->last_name}\n\n";
    } else {
        echo "⚠️  Usuario no encontrado (pero la consulta funcionó)\n\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: No se pudo ejecutar la consulta\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    if (str_contains($e->getMessage(), 'Access denied')) {
        echo "💡 SOLUCIÓN:\n";
        echo "   1. Ve al panel de StackCP\n";
        echo "   2. Busca la sección de Bases de Datos\n";
        echo "   3. Asigna el usuario 'remote_user-034a' a la base de datos 'rrhh_db-3530323522bf'\n";
        echo "   4. Otorga permisos: SELECT, INSERT, UPDATE, DELETE\n";
        echo "   5. Gu FINAL:\n\n";

$mysqlOk = false;
$vacationsOk = false;

// Verificar conexión mysql (base de datos principal)
try {
    DB::connection('mysql')->getPdo();
    try {
        $user = DB::connection('mysql')->table('users')->where('active', 1)->first();
        if ($user) {
            $mysqlOk = true;
            echo "✅ Base de datos PRINCIPAL (rrhh_db): Conectado y con permisos SELECT\n";
        }
    } catch (\Exception $e) {
        echo "❌ Base de datos PRINCIPAL: Conectado pero SIN permisos SELECT\n";
        echo "   Error: " . substr($e->getMessage(), 0, 150) . "\n";
    }
} catch (\Exception $e) {
    echo "❌ Base de datos PRINCIPAL: No se puede conectar\n";
    echo "   Error: " . substr($e->getMessage(), 0, 150) . "\n";
}

echo "\n";

// Verificar conexión mysql_vacations
try {
    DB::connection('mysql_vacations')->getPdo();
    try {
        $request = DB::connection('mysql_vacations')->table('requests')->first();
        $vacationsOk = true;
        echo "✅ Base de datos VACACIONES (rrhh_vacations): Conectado y con permisos SELECT\n";
    } catch (\Exception $e) {
        echo "❌ Base de datos VACACIONES: Conectado pero SIN permisos SELECT\n";
        echo "   Error: " . substr($e->getMessage(), 0, 150) . "\n";
    }
} catch (\Exception $e) {
    echo "❌ Base de datos VACACIONES: No se puede conectar\n";
    echo "   Error: " . substr($e->getMessage(), 0, 150) . "\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

if ($mysqlOk && $vacationsOk) {
    echo "🎉 PERFECTO: Ambas bases de datos funcionan correctamente\n";
    echo "   ✅ El login OAuth debería funcionar ahora\n";
    echo "   ✅ Las solicitudes de vacaciones deberían funcionar\n\n";
} elseif ($mysqlOk && !$vacationsOk) {
    echo "⚠️  Base de datos principal OK, pero hay problemas con la de vacaciones\n";
    echo "   El login funcionará, pero las vacaciones pueden tener errores\n\n";
} elseif (!$mysqlOk && $vacationsOk) {
    echo "❌ CRÍTICO: La base de datos principal NO funciona\n";
    echo "   El login OAuth NO funcionará hasta que se corrija\n";
    echo "   Verifica los permisos de 'remote_user-034a' en 'rrhh_db-3530323522bf'\n\n";
} else {
    echo "❌ CRÍTICO: Ninguna base de datos funciona correctamente\n";
    echo "   Verifica las credenciales y permisos en el archivo .env\n\n";
}

echo "✅ Verificación completada (solo consultas SELECT - datos seguros)
} catch (\Exception $e) {
    echo "❌ PROBLEMA DE CONEXIÓN: No se puede conectar a la base de datos\n";
    echo "   Verifica las credenciales en el archivo .env\n\n";
    echo "   Error específico: " . $e->getMessage() . "\n\n";
}

echo "✅ Verificación completada\n\n";

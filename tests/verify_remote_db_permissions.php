<?php

/**
 * Script para verificar permisos de base de datos remota
 * Ejecutar: php tests/verify_remote_db_permissions.php
 * 
 * IMPORTANTE: Solo realiza consultas SELECT (lectura) - No modifica datos
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "\n";
echo "================================================================================\n";
echo "  VERIFICACION DE PERMISOS DE BASE DE DATOS REMOTA\n";
echo "================================================================================\n\n";

// Información de conexión
$connections = ['mysql', 'mysql_vacations'];

foreach ($connections as $connectionName) {
    echo "CONEXION: $connectionName\n";
    echo str_repeat("-", 80) . "\n";
    
    $config = Config::get("database.connections.$connectionName");
    
    echo "  Host: {$config['host']}:{$config['port']}\n";
    echo "  Base de datos: {$config['database']}\n";
    echo "  Usuario: {$config['username']}\n\n";
    
    // Probar conexión
    echo "  [TEST] Probando conexion... ";
    try {
        DB::connection($connectionName)->getPdo();
        echo "[OK] Conectado\n\n";
    } catch (\Exception $e) {
        echo "[ERROR] No se pudo conectar\n";
        echo "         Error: " . $e->getMessage() . "\n\n";
        continue;
    }
    
    // Mostrar información del usuario actual
    echo "  [INFO] Usuario de base de datos:\n";
    try {
        $currentUser = DB::connection($connectionName)
            ->select("SELECT USER() as user, DATABASE() as db")[0];
        echo "         Usuario actual: {$currentUser->user}\n";
        echo "         Base de datos actual: {$currentUser->db}\n\n";
    } catch (\Exception $e) {
        echo "         [ERROR] No se pudo obtener informacion del usuario\n";
        echo "         Error: " . $e->getMessage() . "\n\n";
    }
    
    // Probar permisos de SOLO LECTURA (seguro para producción)
    echo "  [TEST] Probando permisos de LECTURA:\n";
    
    echo "         SELECT: ";
    try {
        if ($connectionName === 'mysql') {
            $count = DB::connection($connectionName)->table('users')->count();
            echo "[OK] Encontrados $count usuarios\n";
        } else {
            $count = DB::connection($connectionName)->table('requests')->count();
            echo "[OK] Encontradas $count solicitudes\n";
        }
    } catch (\Exception $e) {
        echo "[ERROR] Sin permiso\n";
        if (str_contains($e->getMessage(), 'Access denied')) {
            echo "                 Acceso denegado a la base de datos\n";
        } else {
            echo "                 Error: " . substr($e->getMessage(), 0, 100) . "...\n";
        }
    }
    
    echo "\n";
    
    // Listar tablas (SOLO LECTURA)
    echo "  [TEST] Verificando acceso a tablas principales:\n";
    try {
        if ($connectionName === 'mysql') {
            $tables = ['users', 'jobs', 'departamentos', 'personal_data'];
        } else {
            $tables = ['requests', 'vacations_availables', 'request_approveds', 'request_rejecteds'];
        }
        
        foreach ($tables as $table) {
            echo "         - $table: ";
            try {
                $exists = DB::connection($connectionName)
                    ->select("SELECT 1 FROM $table LIMIT 1");
                echo "[OK] Accesible\n";
            } catch (\Exception $e) {
                echo "[ERROR] No accesible\n";
            }
        }
    } catch (\Exception $e) {
        echo "         [ERROR] Error al verificar tablas\n";
        echo "         Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat("-", 80) . "\n\n";
}

// Probar la consulta específica que falla en OAuth
echo "================================================================================\n";
echo "  PRUEBA ESPECIFICA: Consulta de OAuth\n";
echo "================================================================================\n\n";

echo "Intentando ejecutar la misma consulta del login OAuth:\n";
echo "  SELECT * FROM users WHERE email = ? AND active = 1\n\n";

try {
    $testEmail = 'ochavez@gptservices.com';
    $user = DB::connection('mysql')
        ->table('users')
        ->where('email', $testEmail)
        ->where('active', 1)
        ->first();
    
    if ($user) {
        echo "[OK] EXITO: Usuario encontrado\n";
        echo "     ID: {$user->id}\n";
        echo "     Email: {$user->email}\n";
        echo "     Nombre: {$user->first_name} {$user->last_name}\n\n";
    } else {
        echo "[INFO] Usuario no encontrado (pero la consulta funciono)\n\n";
    }
    
} catch (\Exception $e) {
    echo "[ERROR] No se pudo ejecutar la consulta\n";
    echo "        Error: " . $e->getMessage() . "\n\n";
    
    if (str_contains($e->getMessage(), 'Access denied')) {
        echo "SOLUCION:\n";
        echo "  1. Ve al panel de StackCP\n";
        echo "  2. Busca la seccion de Bases de Datos\n";
        echo "  3. Asigna el usuario 'remote_user-034a' a la base de datos 'rrhh_db-3530323522bf'\n";
        echo "  4. Otorga permisos: SELECT, INSERT, UPDATE, DELETE\n";
        echo "  5. Guarda los cambios y vuelve a probar\n\n";
    }
}

// Diagnóstico final
echo "================================================================================\n";
echo "  DIAGNOSTICO FINAL\n";
echo "================================================================================\n\n";

$mysqlOk = false;
$vacationsOk = false;

// Verificar conexión mysql (base de datos principal)
try {
    DB::connection('mysql')->getPdo();
    try {
        $user = DB::connection('mysql')->table('users')->where('active', 1)->first();
        if ($user) {
            $mysqlOk = true;
            echo "[OK] Base de datos PRINCIPAL (rrhh_db): Conectado y con permisos SELECT\n";
        }
    } catch (\Exception $e) {
        echo "[ERROR] Base de datos PRINCIPAL: Conectado pero SIN permisos SELECT\n";
        echo "        Error: " . substr($e->getMessage(), 0, 150) . "\n";
    }
} catch (\Exception $e) {
    echo "[ERROR] Base de datos PRINCIPAL: No se puede conectar\n";
    echo "        Error: " . substr($e->getMessage(), 0, 150) . "\n";
}

echo "\n";

// Verificar conexión mysql_vacations
try {
    DB::connection('mysql_vacations')->getPdo();
    try {
        $request = DB::connection('mysql_vacations')->table('requests')->first();
        $vacationsOk = true;
        echo "[OK] Base de datos VACACIONES (rrhh_vacations): Conectado y con permisos SELECT\n";
    } catch (\Exception $e) {
        echo "[ERROR] Base de datos VACACIONES: Conectado pero SIN permisos SELECT\n";
        echo "        Error: " . substr($e->getMessage(), 0, 150) . "\n";
    }
} catch (\Exception $e) {
    echo "[ERROR] Base de datos VACACIONES: No se puede conectar\n";
    echo "        Error: " . substr($e->getMessage(), 0, 150) . "\n";
}

echo "\n" . str_repeat("-", 80) . "\n\n";

// Resultado final
if ($mysqlOk && $vacationsOk) {
    echo "RESULTADO: Ambas bases de datos funcionan correctamente\n\n";
    echo "  [OK] El login OAuth deberia funcionar ahora\n";
    echo "  [OK] Las solicitudes de vacaciones deberian funcionar\n\n";
} elseif ($mysqlOk && !$vacationsOk) {
    echo "RESULTADO: Base de datos principal OK, pero hay problemas con la de vacaciones\n\n";
    echo "  [OK] El login funcionara\n";
    echo "  [WARNING] Las vacaciones pueden tener errores\n\n";
} elseif (!$mysqlOk && $vacationsOk) {
    echo "RESULTADO CRITICO: La base de datos principal NO funciona\n\n";
    echo "  [ERROR] El login OAuth NO funcionara hasta que se corrija\n";
    echo "  [INFO] Verifica los permisos de 'remote_user-034a' en 'rrhh_db-3530323522bf'\n\n";
} else {
    echo "RESULTADO CRITICO: Ninguna base de datos funciona correctamente\n\n";
    echo "  [ERROR] Verifica las credenciales y permisos en el archivo .env\n\n";
}

echo "================================================================================\n";
echo "Verificacion completada (solo consultas SELECT - datos seguros)\n";
echo "================================================================================\n\n";

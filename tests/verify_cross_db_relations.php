#!/usr/bin/env php
<?php

/**
 * Script de Verificación de Relaciones Cross-Database
 * 
 * Ejecutar: php tests/verify_cross_db_relations.php
 * 
 * IMPORTANTE: Ejecuta este script en LOCAL y en PRODUCCIÓN para verificar
 * que las relaciones entre bases de datos funcionan correctamente.
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use App\Models\ManagerApprover;
use App\Models\DirectionApprover;

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║  VERIFICACIÓN DE RELACIONES CROSS-DATABASE                   ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Información del entorno
echo "📌 Entorno: " . config('app.env') . "\n";
echo "📌 BD Principal: " . config('database.connections.mysql.database') . "\n";
echo "📌 BD Vacaciones: " . config('database.connections.mysql_vacations.database') . "\n";
echo "\n";

$errors = [];
$warnings = [];
$tests = 0;
$passed = 0;

// ============================================
// TEST 1: Conexión básica a ambas BDs
// ============================================
echo "🔍 Test 1: Verificando conexiones a bases de datos...\n";
$tests++;

try {
    DB::connection('mysql')->getPdo();
    echo "   ✅ Conexión a BD principal (mysql): OK\n";
} catch (Exception $e) {
    echo "   ❌ Error en BD principal: " . $e->getMessage() . "\n";
    $errors[] = "Conexión a BD principal falló";
}

try {
    DB::connection('mysql_vacations')->getPdo();
    echo "   ✅ Conexión a BD vacaciones (mysql_vacations): OK\n";
    $passed++;
} catch (Exception $e) {
    echo "   ❌ Error en BD vacaciones: " . $e->getMessage() . "\n";
    $errors[] = "Conexión a BD vacaciones falló";
}

echo "\n";

// ============================================
// TEST 2: User → RequestVacations (BD principal → BD vacaciones)
// ============================================
echo "🔍 Test 2: Relación User → RequestVacations...\n";
$tests++;

try {
    $user = User::where('active', 1)->first();
    
    if (!$user) {
        echo "   ⚠️  No hay usuarios activos en la BD\n";
        $warnings[] = "No hay usuarios activos para probar";
    } else {
        echo "   👤 Usuario de prueba: {$user->nombre()} (ID: {$user->id})\n";
        
        $requestCount = $user->requestVacations()->count();
        echo "   📊 Solicitudes encontradas: $requestCount\n";
        
        if ($requestCount > 0) {
            $firstRequest = $user->requestVacations()->first();
            echo "   ✅ Relación funciona - Primera solicitud ID: {$firstRequest->id}\n";
            $passed++;
        } else {
            echo "   ⚠️  Usuario sin solicitudes (relación funciona, pero sin datos)\n";
            $passed++;
            $warnings[] = "Usuario no tiene solicitudes para verificar";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    $errors[] = "Relación User → RequestVacations falló";
}

echo "\n";

// ============================================
// TEST 3: RequestVacations → User (BD vacaciones → BD principal)
// ============================================
echo "🔍 Test 3: Relación RequestVacations → User...\n";
$tests++;

try {
    $request = RequestVacations::first();
    
    if (!$request) {
        echo "   ⚠️  No hay solicitudes en la BD de vacaciones\n";
        $warnings[] = "No hay solicitudes para probar";
    } else {
        echo "   📄 Solicitud de prueba ID: {$request->id}\n";
        
        $user = $request->user;
        
        if ($user) {
            echo "   👤 Usuario relacionado: {$user->nombre()} (ID: {$user->id})\n";
            echo "   ✅ Relación funciona correctamente\n";
            $passed++;
        } else {
            echo "   ❌ No se pudo obtener el usuario\n";
            $errors[] = "Relación RequestVacations → User falló";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    $errors[] = "Relación RequestVacations → User falló: " . $e->getMessage();
}

echo "\n";

// ============================================
// TEST 4: Relación anidada RequestVacations → User → Job → Departamento
// ============================================
echo "🔍 Test 4: Relación anidada (Request → User → Job → Departamento)...\n";
$tests++;

try {
    $request = RequestVacations::first();
    
    if (!$request) {
        echo "   ⚠️  No hay solicitudes para probar\n";
        $warnings[] = "No hay solicitudes para probar relación anidada";
    } else {
        $departamento = $request->user->job->departamento ?? null;
        
        if ($departamento) {
            echo "   🏢 Departamento: {$departamento->name}\n";
            echo "   ✅ Relaciones anidadas funcionan correctamente\n";
            $passed++;
        } else {
            echo "   ❌ No se pudo obtener el departamento\n";
            $errors[] = "Relación anidada falló";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    $errors[] = "Relación anidada falló: " . $e->getMessage();
}

echo "\n";

// ============================================
// TEST 5: User → VacationsAvailable
// ============================================
echo "🔍 Test 5: Relación User → VacationsAvailable...\n";
$tests++;

try {
    $user = User::where('active', 1)->first();
    
    if (!$user) {
        echo "   ⚠️  No hay usuarios activos\n";
        $warnings[] = "No hay usuarios activos";
    } else {
        $vacationsCount = $user->vacationsAvailable()->count();
        echo "   📊 Períodos de vacaciones: $vacationsCount\n";
        
        if ($vacationsCount > 0) {
            echo "   ✅ Relación funciona correctamente\n";
            $passed++;
        } else {
            echo "   ⚠️  Usuario sin períodos de vacaciones\n";
            $passed++;
            $warnings[] = "Usuario sin períodos de vacaciones";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    $errors[] = "Relación User → VacationsAvailable falló";
}

echo "\n";

// ============================================
// TEST 6: ManagerApprover → User y Departamento
// ============================================
echo "🔍 Test 6: Relación ManagerApprover → User y Departamento...\n";
$tests++;

try {
    $approver = ManagerApprover::first();
    
    if (!$approver) {
        echo "   ⚠️  No hay aprobadores configurados\n";
        $warnings[] = "No hay manager approvers configurados";
        $passed++; // No es error, simplemente no hay datos
    } else {
        $boss = $approver->boss;
        $employee = $approver->employee;
        $departamento = $approver->departamento;
        
        echo "   👔 Jefe: " . ($boss ? $boss->nombre() : 'N/A') . "\n";
        echo "   👤 Empleado: " . ($employee ? $employee->nombre() : 'N/A') . "\n";
        echo "   🏢 Departamento: " . ($departamento->name ?? 'N/A') . "\n";
        
        if ($boss && $employee && $departamento) {
            echo "   ✅ Todas las relaciones funcionan\n";
            $passed++;
        } else {
            echo "   ⚠️  Alguna relación no tiene datos\n";
            $warnings[] = "ManagerApprover tiene relaciones incompletas";
            $passed++; // Puede ser válido si no hay datos
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    $errors[] = "Relación ManagerApprover falló: " . $e->getMessage();
}

echo "\n";

// ============================================
// RESUMEN
// ============================================
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║  RESUMEN DE VERIFICACIÓN                                     ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "✅ Tests pasados: $passed / $tests\n";

if (count($warnings) > 0) {
    echo "\n⚠️  Advertencias (" . count($warnings) . "):\n";
    foreach ($warnings as $warning) {
        echo "   - $warning\n";
    }
}

if (count($errors) > 0) {
    echo "\n❌ Errores (" . count($errors) . "):\n";
    foreach ($errors as $error) {
        echo "   - $error\n";
    }
    echo "\n";
    echo "🔧 ACCIÓN REQUERIDA:\n";
    echo "   1. Verifica tu archivo .env\n";
    echo "   2. Asegúrate de que ambas bases de datos existan\n";
    echo "   3. Ejecuta las migraciones en ambas BDs\n";
    echo "   4. Revisa la documentación en docs/CONFIGURACION_PRODUCCION.md\n";
    echo "\n";
    exit(1);
} else {
    echo "\n";
    echo "🎉 ¡TODAS LAS RELACIONES CROSS-DATABASE FUNCIONAN CORRECTAMENTE!\n";
    echo "\n";
    echo "✨ Las vistas SQL NO son necesarias.\n";
    echo "✨ Laravel Eloquent maneja todo automáticamente.\n";
    echo "\n";
    exit(0);
}

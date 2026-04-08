<?php

require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ManagerApprover;
use App\Models\RequestVacations;

echo "===== PRUEBA DE LÓGICA DE ASIGNACIÓN DE JEFE DIRECTO =====\n\n";

// 1. Verificar configuración de manager_approvers
echo "1. Verificando configuración de manager_approvers:\n";
$approvers = ManagerApprover::where('is_active', true)
    ->with(['user', 'departamento'])
    ->get();

if ($approvers->isEmpty()) {
    echo "   ⚠ No hay aprobadores personalizados configurados\n";
} else {
    echo "   Aprobadores personalizados activos:\n";
    foreach ($approvers as $approver) {
        echo "     - Usuario {$approver->user_id} ({$approver->user->name}) autoriza depto {$approver->departamento_id} ({$approver->departamento->name})\n";
    }
}
echo "\n";

// 2. Probar con un usuario que tiene aprobador personalizado
echo "2. Probando asignación de jefe directo:\n";

// Buscar un usuario con departamento que tenga aprobador personalizado
$testUser = null;
foreach ($approvers as $approver) {
    $user = User::whereHas('job', function($q) use ($approver) {
            $q->where('depto_id', $approver->departamento_id);
        })
        ->with('job.departamento')
        ->first();
    
    if ($user) {
        $testUser = $user;
        $expectedManagerId = $approver->user_id;
        break;
    }
}

if ($testUser) {
    $deptoId = $testUser->job->depto_id ?? null;
    echo "   Usuario de prueba: {$testUser->id} - {$testUser->name}\n";
    echo "   Departamento (job->depto_id): {$deptoId}\n";
    echo "   boss_id (jefe natural): {$testUser->boss_id}\n";
    
    $customManagerId = $deptoId ? ManagerApprover::getManagerForDepartment($deptoId) : null;
    echo "   Jefe personalizado (manager_approvers): " . ($customManagerId ?? 'N/A') . "\n";
    
    $directManagerId = $customManagerId ?? $testUser->boss_id;
    echo "   Jefe asignado final: {$directManagerId}\n";
    
    if ($customManagerId && $customManagerId != $testUser->boss_id) {
        echo "   ✓ CORRECTO: Se usa el jefe personalizado en lugar del boss_id\n";
    } elseif ($customManagerId == $testUser->boss_id) {
        echo "   ℹ El jefe personalizado coincide con el boss_id\n";
    } else {
        echo "   ✓ Se usa boss_id porque no hay jefe personalizado\n";
    }
} else {
    echo "   ⚠ No se encontró usuario con aprobador personalizado para probar\n";
}
echo "\n";

// 3. Verificar solicitudes existentes
echo "3. Verificando solicitudes de vacaciones recientes:\n";
$recentRequests = RequestVacations::with(['user.job.departamento', 'directManager'])
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

if ($recentRequests->isEmpty()) {
    echo "   No hay solicitudes recientes\n";
} else {
    foreach ($recentRequests as $req) {
        $deptoId = $req->user->job->depto_id ?? null;
        
        $customManagerId = null;
        if ($deptoId) {
            $customManagerId = ManagerApprover::getManagerForDepartment($deptoId);
        }
        
        $expectedManagerId = $customManagerId ?? $req->user->boss_id;
        $actualManagerId = $req->direct_manager_id;
        
        echo "   Solicitud #{$req->id} - Usuario: {$req->user->name}\n";
        echo "     - Departamento (job->depto_id): " . ($deptoId ?? 'N/A') . "\n";
        echo "     - boss_id: {$req->user->boss_id}\n";
        echo "     - Jefe personalizado: " . ($customManagerId ?? 'N/A') . "\n";
        echo "     - direct_manager_id asignado: {$actualManagerId}\n";
        echo "     - Jefe esperado: {$expectedManagerId}\n";
        
        if ($actualManagerId == $expectedManagerId) {
            echo "     ✓ CORRECTO\n";
        } else {
            echo "     ✗ ERROR: direct_manager_id no coincide con el esperado\n";
        }
        echo "\n";
    }
}

// 4. Verificar vista /vacaciones/aprobar
echo "4. Simulando consulta de /vacaciones/aprobar:\n";

if ($testUser && $directManagerId) {
    // Simular que el jefe directo ve sus solicitudes
    $managerRequests = RequestVacations::where('direct_manager_status', 'Pendiente')
        ->where('direct_manager_id', $directManagerId)
        ->with(['user'])
        ->get();
    
    echo "   Usuario {$directManagerId} vería {$managerRequests->count()} solicitudes pendientes:\n";
    foreach ($managerRequests as $req) {
        echo "     - Solicitud #{$req->id} de {$req->user->name}\n";
    }
}

echo "\n===== FIN DE PRUEBA =====\n";

echo "\n===== PRUEBA DE APROBADORES DE DIRECCIÓN =====\n\n";

// 5. Verificar configuración de direction_approvers
echo "5. Verificando configuración de direction_approvers:\n";
$directionApprovers = \App\Models\DirectionApprover::where('is_active', true)
    ->with(['user', 'departamento'])
    ->get();

if ($directionApprovers->isEmpty()) {
    echo "   ⚠ No hay aprobadores de dirección personalizados configurados\n";
} else {
    echo "   Aprobadores de dirección personalizados activos:\n";
    foreach ($directionApprovers as $approver) {
        echo "     - Usuario {$approver->user_id} ({$approver->user->name}) autoriza depto {$approver->departamento_id} ({$approver->departamento->name})\n";
    }
}
echo "\n";

// 6. Verificar solicitudes con direction_approbation_id
echo "6. Verificando solicitudes aprobadas por jefe directo (pendientes de dirección):\n";
$directionPendingRequests = RequestVacations::where('direct_manager_status', 'Aprobada')
    ->where('direction_approbation_status', 'Pendiente')
    ->with(['user.job.departamento', 'directionApprover'])
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

if ($directionPendingRequests->isEmpty()) {
    echo "   No hay solicitudes pendientes de aprobación de dirección\n";
} else {
    foreach ($directionPendingRequests as $req) {
        $deptoId = $req->user->job->depto_id ?? null;
        
        $customDirectionApproverId = null;
        if ($deptoId) {
            $customDirectionApproverId = \App\Models\DirectionApprover::getDirectionApproverForDepartment($deptoId);
        }
        
        // Si no hay personalizado, buscar job_id = 60
        $expectedApproverId = $customDirectionApproverId;
        if (!$expectedApproverId) {
            $defaultDir = User::where('job_id', 60)->first();
            $expectedApproverId = $defaultDir?->id;
        }
        
        $actualApproverId = $req->direction_approbation_id;
        
        echo "   Solicitud #{$req->id} - Usuario: {$req->user->name}\n";
        echo "     - Departamento (job->depto_id): " . ($deptoId ?? 'N/A') . "\n";
        echo "     - Aprobador dirección personalizado: " . ($customDirectionApproverId ?? 'N/A') . "\n";
        echo "     - direction_approbation_id asignado: " . ($actualApproverId ?? 'NO ASIGNADO') . "\n";
        echo "     - Aprobador esperado: " . ($expectedApproverId ?? 'N/A') . "\n";
        
        if ($actualApproverId == $expectedApproverId) {
            echo "     ✓ CORRECTO\n";
        } elseif (!$actualApproverId) {
            echo "     ⚠ ADVERTENCIA: Solicitud antigua sin direction_approbation_id asignado\n";
        } else {
            echo "     ✗ ERROR: direction_approbation_id no coincide con el esperado\n";
        }
        echo "\n";
    }
}

echo "\n===== FIN DE PRUEBA COMPLETA =====\n";

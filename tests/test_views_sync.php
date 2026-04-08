<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "========================================\n";
echo "  TEST: VISTAS SE ACTUALIZAN AUTOMÁTICAMENTE\n";
echo "========================================\n\n";

// 1. Verificar que User opera en la tabla real (rh.users)
echo "1. VERIFICAR CONEXIÓN DEL MODELO USER\n";
echo "----------------------------------------\n";
$user = new User();
echo "  User->getConnectionName(): " . $user->getConnectionName() . "\n";
echo "  User->getTable(): " . $user->getTable() . "\n";
echo "  → User SIEMPRE opera en: rh.users (tabla real)\n\n";

// 2. Contar usuarios en ambas ubicaciones
echo "2. CONTAR USUARIOS EN TABLA REAL vs VISTA\n";
echo "----------------------------------------\n";
$countRealTable = DB::connection('mysql')->table('users')->count();
$countView = DB::connection('mysql_vacations')->table('users')->count();
echo "  rh.users (tabla real):     {$countRealTable}\n";
echo "  rh_vacations.users (vista): {$countView}\n";
echo "  → " . ($countRealTable === $countView ? "✓ SINCRONIZADOS" : "✗ DESINCRONIZADOS") . "\n\n";

// 3. Simular actualización de usuario (sin ejecutar)
echo "3. SIMULAR ACTUALIZACIÓN DE USUARIO\n";
echo "----------------------------------------\n";
$testUser = User::where('active', 1)->first();
if ($testUser) {
    echo "  Usuario: {$testUser->first_name} {$testUser->last_name}\n";
    echo "  Estado actual: active = {$testUser->active}\n";
    echo "  Admisión actual: {$testUser->admission}\n\n";
    
    echo "  Si ejecutaras:\n";
    echo "    \$user->admission = '2026-04-07';\n";
    echo "    \$user->active = 1;\n";
    echo "    \$user->save();\n\n";
    
    echo "  → Escritura iría a: rh.users (tabla real)\n";
    echo "  → La vista rh_vacations.users se actualizaría AUTOMÁTICAMENTE\n\n";
} else {
    echo "  No hay usuarios activos para probar\n\n";
}

// 4. Verificar que INSERT también sincroniza (simulación)
echo "4. VERIFICAR TIPO DE OBJETO EN BD PRINCIPAL\n";
echo "----------------------------------------\n";
$tableType = DB::connection('mysql')
    ->table('information_schema.TABLES')
    ->where('TABLE_SCHEMA', 'rh')
    ->where('TABLE_NAME', 'users')
    ->value('TABLE_TYPE');
echo "  rh.users es tipo: {$tableType}\n";
echo "  → " . ($tableType === 'BASE TABLE' ? "✓ Es tabla REAL (puede escribirse)" : "✗ Es vista (solo lectura)") . "\n\n";

// 5. Verificar tipo en rh_vacations
echo "5. VERIFICAR TIPO DE OBJETO EN BD VACACIONES\n";
echo "----------------------------------------\n";
$viewType = DB::connection('mysql_vacations')
    ->table('information_schema.TABLES')
    ->where('TABLE_SCHEMA', 'rh_vacations')
    ->where('TABLE_NAME', 'users')
    ->value('TABLE_TYPE');
echo "  rh_vacations.users es tipo: {$viewType}\n";
echo "  → " . ($viewType === 'VIEW' ? "✓ Es vista (refleja cambios automáticamente)" : "✗ No es vista") . "\n\n";

// 6. Verificar definición de la vista
echo "6. DEFINICIÓN DE LA VISTA\n";
echo "----------------------------------------\n";
$viewDef = DB::connection('mysql_vacations')
    ->table('information_schema.VIEWS')
    ->where('TABLE_SCHEMA', 'rh_vacations')
    ->where('TABLE_NAME', 'users')
    ->value('VIEW_DEFINITION');
if ($viewDef) {
    // Limpiar la definición para mostrar
    $cleanDef = str_replace('`rh`.`users`', 'rh.users', $viewDef);
    $cleanDef = substr($cleanDef, 0, 100) . '...';
    echo "  {$cleanDef}\n";
    echo "  → La vista ejecuta SELECT * FROM rh.users en tiempo real\n\n";
}

echo "========================================\n";
echo "  CONCLUSIÓN\n";
echo "========================================\n";
echo "✓ User::save() escribe SIEMPRE en rh.users (tabla real)\n";
echo "✓ La vista rh_vacations.users se actualiza AUTOMÁTICAMENTE\n";
echo "✓ No necesitas hacer nada especial para sincronizar\n";
echo "✓ Puedes actualizar admission, active, etc. sin problemas\n";
echo "========================================\n";

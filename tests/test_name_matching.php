<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== Test de Coincidencia de Nombres (Case-Insensitive) ===\n\n";

// Simular el método findUserByName
function findUserByName(string $nombreCompleto): ?User
{
    // Normalizar: convertir a mayúsculas, limpiar espacios múltiples
    $nombreNormalizado = strtoupper(trim(preg_replace('/\s+/', ' ', $nombreCompleto)));

    // Buscar coincidencia exacta (APELLIDO NOMBRE)
    $user = User::whereRaw("UPPER(TRIM(CONCAT(TRIM(last_name), ' ', TRIM(first_name)))) = ?", [$nombreNormalizado])
        ->where('active', 1)
        ->first();

    if ($user) {
        return $user;
    }

    // Buscar coincidencia invertida (NOMBRE APELLIDO)
    $user = User::whereRaw("UPPER(TRIM(CONCAT(TRIM(first_name), ' ', TRIM(last_name)))) = ?", [$nombreNormalizado])
        ->where('active', 1)
        ->first();

    if ($user) {
        return $user;
    }

    // Intentar búsqueda parcial por apellido
    $partes = explode(' ', $nombreNormalizado);
    if (count($partes) >= 2) {
        // Buscar por las primeras dos palabras (generalmente apellidos)
        $dosPartes = $partes[0] . ' ' . $partes[1];
        $user = User::whereRaw("UPPER(TRIM(last_name)) LIKE ?", [$dosPartes . '%'])
            ->where('active', 1)
            ->first();
        
        if ($user) {
            return $user;
        }
    }

    return null;
}

// Obtener un usuario de ejemplo de la base de datos
$usuario = User::where('active', 1)->first();

if (!$usuario) {
    echo "❌ No se encontraron usuarios activos en la base de datos.\n";
    exit(1);
}

echo "Usuario de prueba en DB:\n";
echo "  - last_name: {$usuario->last_name}\n";
echo "  - first_name: {$usuario->first_name}\n";
echo "  - ID: {$usuario->id}\n\n";

// Crear variaciones del nombre para probar
$nombreOriginal = "{$usuario->last_name} {$usuario->first_name}";
$nombreInvertido = "{$usuario->first_name} {$usuario->last_name}";

$testCases = [
    // Mayúsculas
    strtoupper($nombreOriginal) => 'TODO MAYÚSCULAS',
    strtoupper($nombreInvertido) => 'TODO MAYÚSCULAS (invertido)',
    
    // Minúsculas
    strtolower($nombreOriginal) => 'todo minúsculas',
    strtolower($nombreInvertido) => 'todo minúsculas (invertido)',
    
    // Título (Primera letra mayúscula)
    ucwords(strtolower($nombreOriginal)) => 'Título Case',
    ucwords(strtolower($nombreInvertido)) => 'Título Case (invertido)',
    
    // Mixto aleatorio
    $nombreOriginal => 'Original DB',
    $nombreInvertido => 'Invertido',
    
    // Con espacios múltiples
    str_replace(' ', '  ', $nombreOriginal) => 'Con espacios dobles',
    '  ' . $nombreOriginal . '  ' => 'Con espacios al inicio y fin',
    
    // Solo apellido (búsqueda parcial si aplica)
    explode(' ', $nombreOriginal)[0] => 'Solo primer apellido (puede fallar)',
];

$passed = 0;
$failed = 0;
$warnings = 0;

echo "=== Probando diferentes formatos de nombre ===\n\n";

foreach ($testCases as $input => $descripcion) {
    $result = findUserByName($input);
    
    if ($result && $result->id === $usuario->id) {
        $status = '✅';
        $passed++;
        $mensaje = 'Encontrado';
    } elseif ($result) {
        $status = '⚠️';
        $warnings++;
        $mensaje = "Encontró otro usuario (ID: {$result->id})";
    } else {
        $status = '❌';
        $failed++;
        $mensaje = 'No encontrado';
    }
    
    echo sprintf(
        "%s %-30s | Input: '%s'\n   → %s\n\n",
        $status,
        $descripcion,
        $input,
        $mensaje
    );
}

echo "\n=== Resumen ===\n";
echo "Total: " . ($passed + $failed + $warnings) . "\n";
echo "✅ Correctos: $passed\n";
echo "⚠️  Advertencias: $warnings\n";
echo "❌ Fallidos: $failed\n";

if ($failed === 0 && $warnings === 0) {
    echo "\n🎉 Todos los formatos de nombre funcionan correctamente!\n";
} elseif ($failed === 0) {
    echo "\n✓ No hay errores, pero hay advertencias que revisar.\n";
} else {
    echo "\n⚠️  Algunos formatos fallaron. Revisar implementación.\n";
}

// Test adicional: Verificar que la búsqueda es case-insensitive en SQL
echo "\n=== Verificación de Case-Insensitive en SQL ===\n";
$nombreMayusculas = strtoupper($nombreOriginal);
$nombreMinusculas = strtolower($nombreOriginal);

$result1 = findUserByName($nombreMayusculas);
$result2 = findUserByName($nombreMinusculas);

if ($result1 && $result2 && $result1->id === $result2->id) {
    echo "✅ La búsqueda es correctamente case-insensitive\n";
    echo "   MAYÚSCULAS → Usuario ID: {$result1->id}\n";
    echo "   minúsculas → Usuario ID: {$result2->id}\n";
} else {
    echo "❌ La búsqueda NO es case-insensitive correctamente\n";
}

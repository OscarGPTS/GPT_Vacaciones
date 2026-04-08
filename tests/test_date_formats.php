<?php

require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

echo "=== Test de Formatos de Fecha ===\n\n";

// Simular el método parseDate
function parseDate($value): ?string
{
    if (empty($value)) {
        return null;
    }

    try {
        // Si es un número (Excel date serial)
        if (is_numeric($value)) {
            // En ambiente de test sin PhpSpreadsheet, solo retornar mensaje
            if (!class_exists('\PhpOffice\PhpSpreadsheet\Shared\Date')) {
                echo "   ⏭️  Omitido (PhpSpreadsheet no disponible en test)\n";
                return null;
            }
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            return $date->format('Y-m-d');
        }

        // Convertir a string y limpiar espacios
        $value = trim((string)$value);

        // Intentar formato dd/mm/yyyy
        if (preg_match('/^(\d{2})[\\/](\d{2})[\\/](\d{4})$/', $value, $matches)) {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

        // Intentar formato dd-mm-yyyy
        if (preg_match('/^(\d{2})[-](\d{2})[-](\d{4})$/', $value, $matches)) {
            return Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        }

        // Intentar formato ISO yyyy-mm-dd
        if (preg_match('/^(\d{4})[-](\d{2})[-](\d{2})$/', $value)) {
            return Carbon::parse($value)->format('Y-m-d');
        }

        // Último intento con Carbon::parse (acepta muchos formatos)
        return Carbon::parse($value)->format('Y-m-d');
    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
        return null;
    }
}

// Tests
$testCases = [
    // Formato DD/MM/YYYY (Recomendado para usuarios mexicanos)
    '08/08/2024' => '2024-08-08',
    '15/01/2023' => '2023-01-15',
    '31/12/2025' => '2025-12-31',
    
    // Formato DD-MM-YYYY (Alternativo)
    '08-08-2024' => '2024-08-08',
    '15-01-2023' => '2023-01-15',
    '31-12-2025' => '2025-12-31',
    
    // Formato ISO YYYY-MM-DD
    '2024-08-08' => '2024-08-08',
    '2023-01-15' => '2023-01-15',
    '2025-12-31' => '2025-12-31',
    
    // Excel serial number (ejemplo: 45505 = 2024-08-08)
    45505 => '2024-08-08',
    
    // Casos especiales
    '1/1/2024' => '2024-01-01', // Día y mes sin ceros
    '01/01/2024' => '2024-01-01', // Con ceros
];

$passed = 0;
$failed = 0;

foreach ($testCases as $input => $expected) {
    $result = parseDate($input);
    $status = $result === $expected ? '✅' : '❌';
    
    if ($result === $expected) {
        $passed++;
    } else {
        $failed++;
    }
    
    echo sprintf(
        "%s Input: %-15s => Esperado: %s, Obtenido: %s\n",
        $status,
        is_numeric($input) ? "Excel($input)" : "'$input'",
        $expected,
        $result ?? 'NULL'
    );
}

echo "\n=== Resumen ===\n";
echo "Total: " . ($passed + $failed) . "\n";
echo "✅ Pasaron: $passed\n";
echo "❌ Fallaron: $failed\n";

if ($failed === 0) {
    echo "\n🎉 Todos los formatos de fecha funcionan correctamente!\n";
} else {
    echo "\n⚠️  Algunos formatos fallaron, revisar implementación.\n";
}

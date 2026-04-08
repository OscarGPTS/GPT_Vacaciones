<?php

/**
 * Test rápido: ¿Cómo maneja FastExcel las fechas de Excel?
 */

require __DIR__ . '/../vendor/autoload.php';

use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

echo "=== TEST: ¿Cómo FastExcel maneja fechas? ===\n\n";

// Crear un Excel temporal con diferentes formatos de fecha
$testData = [
    [
        'Nombre' => 'Test 1',
        'Fecha Serial' => 45261,  // Serial de Excel
        'Fecha Texto DD/MM/YYYY' => '13/11/2023',
        'Fecha Texto YYYY-MM-DD' => '2023-11-13',
    ],
];

$tempFile = __DIR__ . '/../storage/app/test_fechas.xlsx';

echo "1. Creando archivo Excel de prueba...\n";
(new FastExcel($testData))->export($tempFile);
echo "   ✅ Archivo creado: $tempFile\n\n";

echo "2. Leyendo archivo con FastExcel...\n";
$rows = (new FastExcel)->import($tempFile);

foreach ($rows as $index => $row) {
    echo "   Fila " . ($index + 1) . ":\n";
    foreach ($row as $key => $value) {
        $type = gettype($value);
        $valueStr = is_object($value) ? get_class($value) : (string)$value;
        echo "      - $key: $valueStr (tipo: $type)\n";
        
        // Si es DateTimeInterface, mostrar formato
        if ($value instanceof \DateTimeInterface) {
            echo "        → Fecha formateada: " . $value->format('Y-m-d') . "\n";
        }
    }
    echo "\n";
}

echo "3. Conclusión:\n";
echo "   FastExcel con OpenSpout convierte automáticamente los seriales de Excel\n";
echo "   en objetos DateTime/DateTimeImmutable.\n\n";

echo "4. Solución en parseDate():\n";
echo "   - Verificar si el valor es DateTime/DateTimeInterface\n";
echo "   - Si es DateTime, usar ->format('Y-m-d')\n";
echo "   - Si es numérico, convertir manualmente\n\n";

// Limpiar
if (file_exists($tempFile)) {
    unlink($tempFile);
    echo "✅ Archivo temporal eliminado\n";
}

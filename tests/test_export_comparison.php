<?php
/**
 * TEST: GENERAR EXCEL REAL Y COMPARAR CON IMAGEN
 */

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\BorderStyle;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;

echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST: GENERAR EXCEL Y COMPARAR CON IMAGEN                               ║\n";
echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";

try {
    $currentYear = date('Y');
    $previousYear = $currentYear - 1;
    $nextYear = $currentYear + 1;

    // Crear spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // A1: GPT SERVICES
    $sheet->setCellValue('A1', 'GPT SERVICES');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    
    // A2: VACACIONES 2026
    $sheet->setCellValue('A2', 'VACACIONES ' . $currentYear);
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);

    // Fila 4: Headers con colores
    $headers = [
        'B4' => ['text' => 'No.', 'color' => 'B4D7FF'],
        'C4' => ['text' => 'NOMBRE', 'color' => 'B4D7FF'],
        'D4' => ['text' => '', 'color' => 'FFFFFF'],
        'E4' => ['text' => '', 'color' => 'FFFFFF'],
        'F4' => ['text' => '', 'color' => 'FFFFFF'],
        'G4' => ['text' => '', 'color' => 'FFFFFF'],
        'H4' => ['text' => '', 'color' => 'FFFFFF'],
        'I4' => ['text' => '', 'color' => 'FFFFFF'],
        'J4' => ['text' => "Saldo Pendiente\nPeriodo\n{$previousYear}-{$currentYear}", 'color' => 'B4D7FF'],
        'K4' => ['text' => "Fecha de\nAniversario", 'color' => '0066FF'],
        'L4' => ['text' => 'Antigüedad', 'color' => 'B4D7FF'],
        'M4' => ['text' => "Días De vacaciones\nCorrespondientes\nPeriodo", 'color' => 'D9D9D9'],
        'N4' => ['text' => "Días disfrutados\nantes de la fecha de\nAniversario", 'color' => 'CBE5CB'],
        'O4' => ['text' => "Días\nDisfrutados\nperiodo\n{$currentYear}-{$nextYear}", 'color' => 'B4D7FF'],
        'P4' => ['text' => "Días disfrutados\ndespues de\nfecha de\naniversario", 'color' => 'F4C7C3'],
        'Q4' => ['text' => "Saldo\nPendiente\nPeriodo\n{$currentYear}-{$nextYear}", 'color' => 'B4D7FF'],
    ];

    foreach ($headers as $cell => $header) {
        $sheet->setCellValue($cell, $header['text']);
        $sheet->getStyle($cell)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => $header['color'] === '0066FF' ? 'FFFFFF' : '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $header['color']],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
    }

    $sheet->getRowDimension(4)->setRowHeight(60);

    // Ocultar columnas D-I
    foreach (range('D', 'I') as $col) {
        $sheet->getColumnDimension($col)->setVisible(false);
    }

    // Obtener usuarios ordenados por ID
    $employees = User::with(['job.departamento', 'jefe'])
        ->whereHas('job')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

    echo "📊 PRIMEROS 20 REGISTROS GENERADOS:\n";
    echo "════════════════════════════════════════════════════════════════════════════════════════\n\n";
    echo str_pad("ID", 5) . str_pad("NOMBRE", 40) . str_pad("Saldo Ant", 12) . str_pad("F.Aniv", 12) . str_pad("Antig", 8) . str_pad("Días Cor", 10) . str_pad("Antes", 8) . str_pad("Disf", 8) . str_pad("Desp", 8) . str_pad("Saldo", 8) . "\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";

    $row = 5;
    $count = 0;
    $usuariosConPeriodoAlternativo = 0;
    
    foreach ($employees as $employee) {
        $periods = VacationsAvailable::where('users_id', $employee->id)
            ->orderBy('date_end', 'desc')
            ->get();

        $periodoActual = $periods->filter(function($period) use ($currentYear) {
            $endYear = \Carbon\Carbon::parse($period->date_end)->year;
            return $endYear == $currentYear;
        })->first();
        
        // Si no hay período actual, usar el más reciente disponible
        $usarPeriodoAlternativo = false;
        if (!$periodoActual && $periods->isNotEmpty()) {
            $periodoActual = $periods->first(); // El más reciente (ya ordenado desc)
            $usarPeriodoAlternativo = true;
        }
        
        $periodoAnterior = $periods->filter(function($period) use ($currentYear) {
            $endYear = \Carbon\Carbon::parse($period->date_end)->year;
            return $endYear == ($currentYear - 1);
        })->first();

        // B: No.
        $sheet->setCellValue("B{$row}", $employee->id);
        
        // C: NOMBRE
        $nombreCompleto = mb_strtoupper(trim($employee->last_name . ' ' . $employee->first_name), 'UTF-8');
        $sheet->setCellValue("C{$row}", $nombreCompleto);
        
        // J: Saldo pendiente anterior
        $saldoAnterior = $periodoAnterior ? $periodoAnterior->days_availables : 0;
        $sheet->setCellValue("J{$row}", number_format($saldoAnterior, 2, '.', ''));
        
        // K: Fecha aniversario
        $fechaAniversario = '';
        if ($periodoActual) {
            $fechaAniversario = \Carbon\Carbon::parse($periodoActual->date_end)->format('d-M-y');
            $sheet->setCellValue("K{$row}", $fechaAniversario);
            
            // Si se usa período alternativo, marcar en amarillo
            if ($usarPeriodoAlternativo) {
                $sheet->getStyle("K{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFF00'], // Amarillo
                    ],
                ]);
            }
        }
        
        // L: Antigüedad (años en la empresa al end_date del período)
        $antiguedad = 0;
        if ($employee->admission && $periodoActual) {
            $fechaReferencia = \Carbon\Carbon::parse($periodoActual->date_end);
            $antiguedad = \Carbon\Carbon::parse($employee->admission)->diffInYears($fechaReferencia);
            $sheet->setCellValue("L{$row}", $antiguedad);
        } else {
            $sheet->setCellValue("L{$row}", 0);
        }
        
        // M: Días correspondientes
        $diasCorrespondientes = $periodoAnterior ? $periodoAnterior->days_total_period : 0;
        $sheet->setCellValue("M{$row}", number_format($diasCorrespondientes, 2, '.', ''));
        
        // N: Días antes aniversario
        $diasAntesAniv = $periodoActual ? ($periodoActual->days_enjoyed_before_anniversary ?? 0) : 0;
        $sheet->setCellValue("N{$row}", number_format($diasAntesAniv, 2, '.', ''));
        
        // Q: Saldo actual
        $saldoActual = $periodoActual ? $periodoActual->days_availables : 0;
        $sheet->setCellValue("Q{$row}", number_format($saldoActual, 2, '.', ''));
        
        // O: Días disfrutados (CALCULADO: Total - Saldo)
        $totalPeriodo = $periodoActual ? $periodoActual->days_total_period : 0;
        $diasDisfrutadosCalculado = max(0, $totalPeriodo - $saldoActual);
        $sheet->setCellValue("O{$row}", number_format($diasDisfrutadosCalculado, 2, '.', ''));
        
        // P: Días después aniversario
        $diasDespuesAniv = $periodoActual ? ($periodoActual->days_enjoyed_after_anniversary ?? 0) : 0;
        $sheet->setCellValue("P{$row}", number_format($diasDespuesAniv, 2, '.', ''));

        // Contar usuarios con período alternativo
        if ($usarPeriodoAlternativo) {
            $usuariosConPeriodoAlternativo++;
        }

        // Mostrar primeros 20 en consola
        if ($count < 20) {
            echo str_pad($employee->id, 5);
            echo str_pad(substr($nombreCompleto, 0, 38), 40);
            echo str_pad(number_format($saldoAnterior, 0), 12);
            echo str_pad($fechaAniversario, 12);
            if ($usarPeriodoAlternativo) {
                echo " ⚠ "; // Indicador de período alternativo
            } else {
                echo "   ";
            }
            echo str_pad($antiguedad, 8);
            echo str_pad(number_format($diasCorrespondientes, 0), 10);
            echo str_pad(number_format($diasAntesAniv, 0), 8);
            echo str_pad(number_format($diasDisfrutadosCalculado, 0), 8);
            echo str_pad(number_format($diasDespuesAniv, 0), 8);
            echo str_pad(number_format($saldoActual, 0), 8);
            echo "\n";
        }

        $row++;
        $count++;
    }

    // Aplicar bordes a todas las celdas de datos
    $lastRow = $row - 1;
    if ($lastRow >= 5) {
        $sheet->getStyle("B5:C{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle("J5:Q{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
    }

    // Ajustar ancho de columnas
    $sheet->getColumnDimension('B')->setWidth(8);
    $sheet->getColumnDimension('C')->setWidth(35);
    foreach (range('J', 'Q') as $col) {
        $sheet->getColumnDimension($col)->setWidth(15);
    }

    // Guardar archivo
    $fileName = 'Vacaciones GPT Services ' . $currentYear . ' test.xlsx';
    $filePath = storage_path('app/temp/' . $fileName);
    
    if (!file_exists(storage_path('app/temp'))) {
        mkdir(storage_path('app/temp'), 0755, true);
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    echo "\n╔════════════════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                            ✅ EXCEL GENERADO                                       ║\n";
    echo "╚════════════════════════════════════════════════════════════════════════════════════╝\n\n";
    
    echo "📁 Archivo guardado en: {$filePath}\n";
    echo "📊 Total de registros: " . ($row - 5) . "\n";
    echo "⚠️  Usuarios con período alternativo (amarillo): {$usuariosConPeriodoAlternativo}\n\n";

    echo "🔍 COMPARACIÓN CON IMAGEN:\n";
    echo "────────────────────────────────────────────────────────────────────────────────────────\n";
    echo "Verifica que coincidan:\n";
    echo "  ✓ ID 13: ALCÁNTARA BAUTISTA BENJAMÍN\n";
    echo "  ✓ ID 14: BECERRA YEBRA JESÚS\n";
    echo "  ✓ ID 18: LÓPEZ ARREOLA ANA LILIA\n";
    echo "  ✓ Ordenamiento por ID ascendente\n";
    echo "  ✓ Nombres en MAYÚSCULAS con apellidos primero\n";
    echo "  ✓ Columnas D-I ocultas\n";
    echo "  ✓ Datos numéricos en columnas J-Q\n";
    echo "  ✓ Fecha de aniversario en AMARILLO cuando se usa período alternativo\n\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}

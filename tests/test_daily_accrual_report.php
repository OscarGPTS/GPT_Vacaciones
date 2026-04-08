<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\VacationsAvailable;
use Carbon\Carbon;

$today = Carbon::create(2026, 3, 30);
$sampleSize = 12;

$rows = VacationsAvailable::with('user:id,first_name,last_name')
    ->where('is_historical', false)
    ->where('status', 'actual')
    ->whereDate('date_start', '<=', $today->toDateString())
    ->whereDate('date_end', '>=', $today->toDateString())
    ->whereNotNull('days_total_period')
    ->orderBy('users_id')
    ->limit($sampleSize)
    ->get();

echo "=== REPORTE ACUMULACION DIARIA ===\n";
echo "Fecha de validacion: " . $today->format('Y-m-d') . "\n";
echo "Muestra: " . $rows->count() . " usuarios\n\n";

echo str_pad('UID', 6)
    . str_pad('Nombre', 32)
    . str_pad('Inicio', 12)
    . str_pad('Fin', 12)
    . str_pad('Total', 10)
    . str_pad('Esperado', 10)
    . str_pad('Obtenido', 10)
    . str_pad('Diff', 8)
    . "Estado\n";

echo str_repeat('-', 100) . "\n";

$ok = 0;
$fail = 0;

foreach ($rows as $r) {
    $start = Carbon::parse($r->date_start);
    $end = Carbon::parse($r->date_end);
    $endCalculation = $today->lte($end) ? $today : $end;

    $daysWorked = $start->diffInDays($endCalculation) + 1;
    $daysInYear = $start->isLeapYear() ? 366 : 365;

    $total = (float) $r->days_total_period;
    $expected = round(min(($total * $daysWorked) / $daysInYear, $total), 2);
    $obtained = round((float) $r->days_availables, 2);
    $diff = round($obtained - $expected, 2);

    $status = abs($diff) <= 0.01 ? 'OK' : 'REVISAR';
    if ($status === 'OK') {
        $ok++;
    } else {
        $fail++;
    }

    $name = trim(($r->user->first_name ?? '') . ' ' . ($r->user->last_name ?? ''));

    echo str_pad((string) $r->users_id, 6)
        . str_pad(substr($name, 0, 30), 32)
        . str_pad($start->format('Y-m-d'), 12)
        . str_pad($end->format('Y-m-d'), 12)
        . str_pad(number_format($total, 2), 10)
        . str_pad(number_format($expected, 2), 10)
        . str_pad(number_format($obtained, 2), 10)
        . str_pad(number_format($diff, 2), 8)
        . $status
        . "\n";
}

echo "\nResumen:\n";
echo "- OK: {$ok}\n";
echo "- REVISAR: {$fail}\n";

echo "\nValidacion de tope (obtenido > total):\n";
$violations = $rows->filter(function ($r) {
    return (float) $r->days_availables > (float) $r->days_total_period;
})->count();

echo "- Violaciones en muestra: {$violations}\n";

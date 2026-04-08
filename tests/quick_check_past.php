<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\VacationsAvailable;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$past = VacationsAvailable::where('date_end', '<', '2026-04-01')
    ->where('is_historical', false)
    ->get();

echo "Períodos pasados totales: " . $past->count() . "\n";
echo "Con days_calculated = 0: " . $past->where('days_calculated', 0)->count() . "\n";
echo "Con days_calculated = NULL: " . $past->whereNull('days_calculated')->count() . "\n";
echo "Con days_calculated > 0: " . $past->where('days_calculated', '>', 0)->count() . "\n";

// Mostrar algunos ejemplos
$conCero = $past->where('days_calculated', 0)->take(3);
if ($conCero->count() > 0) {
    echo "\nEjemplos con 0:\n";
    foreach ($conCero as $p) {
        echo "  - Período {$p->period} | days_calculated = {$p->days_calculated}\n";
    }
}

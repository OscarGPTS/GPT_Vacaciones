<?php

/**
 * Verifica que la optimización del reporte de vacaciones no rompe nada.
 *
 * Compara la salida del flujo NUEVO (eager loading + cómputo en memoria) contra
 * la salida del flujo VIEJO (recargando usuarios por separado y volviendo a hacer
 * todas las queries originales).
 *
 * Reporta:
 *  - Cantidad de queries en cada flujo.
 *  - Diferencias por usuario en days_entitled / days_taken / days_remaining /
 *    has_expiring_periods / has_expired_periods / count(allVacationPeriods) /
 *    count(vacationPeriods) / oldest_active_period_cutoff_date.
 *
 * Uso desde la raíz del proyecto:
 *   php scripts/verify_vacation_report_optimization.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use App\Services\VacationCalculatorService;
use Illuminate\Support\Facades\DB;

/**
 * Computa la misma estructura que VacationReport::employeesData() pero con la
 * lógica ANTERIOR (sin eager loading), una query por usuario por concepto.
 */
function computeOldFlow(int $currentYear): array
{
    $calculator = app(VacationCalculatorService::class);

    $employees = User::with(['job.departamento', 'requestVacations', 'jefe'])
        ->whereHas('job')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

    return $employees->map(function ($employee) use ($calculator, $currentYear) {
        // forzar a NO usar la relación cargada para emular flujo viejo
        $employee->unsetRelation('vacationsAvailable');
        $vacationData = $calculator->getAvailableDaysForUser($employee);

        $daysTaken = RequestVacations::where('user_id', $employee->id)
            ->where('human_resources_status', 'Aprobada')
            ->whereHas('requestDays', function ($q) use ($currentYear) {
                $q->whereYear('start', $currentYear);
            })
            ->with('requestDays')
            ->get()
            ->sum(function ($r) use ($currentYear) {
                return $r->requestDays->filter(fn($d) => date('Y', strtotime($d->start)) == $currentYear)->count();
            });

        $vacationPeriods = RequestVacations::where('user_id', $employee->id)
            ->where('human_resources_status', 'Aprobada')
            ->whereHas('requestDays', function ($q) use ($currentYear) {
                $q->whereYear('start', $currentYear);
            })
            ->with('requestDays')
            ->get()
            ->map(function ($r) use ($currentYear) {
                $days = $r->requestDays
                    ->filter(fn($d) => date('Y', strtotime($d->start)) == $currentYear)
                    ->sortBy('start');
                if ($days->count() === 0) return null;
                return [
                    'start' => $days->first()->start,
                    'end' => $days->last()->start,
                    'days_count' => $days->count(),
                    'type' => $r->type_request,
                ];
            })->filter()->values();

        $allVacationPeriods = VacationsAvailable::where('users_id', $employee->id)
            ->orderBy('date_end', 'desc')
            ->get();

        $today = \Carbon\Carbon::today();
        $oldestActivePeriod = $allVacationPeriods
            ->filter(function ($period) use ($today) {
                $cutoffDate = !empty($period->cutoff_date)
                    ? \Carbon\Carbon::parse($period->cutoff_date)->endOfDay()
                    : \Carbon\Carbon::parse($period->date_end)->addMonths(15)->endOfDay();
                $isExpired = $today->gt($cutoffDate)
                    || $period->is_historical
                    || (isset($period->status) && $period->status === 'vencido');
                return !$isExpired;
            })
            ->sortBy('date_end')
            ->first();

        $oldestCutoff = null;
        if ($oldestActivePeriod) {
            $oldestCutoff = !empty($oldestActivePeriod->cutoff_date)
                ? \Carbon\Carbon::parse($oldestActivePeriod->cutoff_date)->format('Y-m-d')
                : \Carbon\Carbon::parse($oldestActivePeriod->date_end)->addMonths(15)->format('Y-m-d');
        }

        // hasExpiringPeriods (vieja: query)
        $hasExpiring = false;
        $threeMonthsFromNow = $today->copy()->addMonths(3);
        $periodsForExpiring = VacationsAvailable::where('users_id', $employee->id)
            ->where('is_historical', false)
            ->get();
        foreach ($periodsForExpiring as $p) {
            $expDate = \Carbon\Carbon::parse($p->date_end)->addMonths(15);
            $isExp = $today->gt($expDate) || $p->is_historical || (isset($p->status) && $p->status === 'vencido');
            $rem = round($p->days_availables - $p->days_enjoyed);
            if (!$isExp && $expDate->lte($threeMonthsFromNow) && $rem > 0) { $hasExpiring = true; break; }
        }

        // hasExpiredPeriods (vieja: query)
        $hasExpired = false;
        foreach ($periodsForExpiring as $p) {
            $expDate = \Carbon\Carbon::parse($p->date_end)->addMonths(15);
            $isExp = $today->gt($expDate) || $p->is_historical || (isset($p->status) && $p->status === 'vencido');
            $rem = round($p->days_availables - $p->days_enjoyed);
            if ($isExp && $rem > 0) { $hasExpired = true; break; }
        }

        return [
            'id' => $employee->id,
            'days_entitled' => $vacationData['total_available'],
            'days_taken' => $daysTaken,
            'days_remaining' => $vacationData['total_remaining'],
            'all_periods_count' => $allVacationPeriods->count(),
            'vacation_periods_count' => $vacationPeriods->count(),
            'has_expiring' => $hasExpiring,
            'has_expired' => $hasExpired,
            'oldest_cutoff' => $oldestCutoff,
        ];
    })->keyBy('id')->all();
}

/**
 * Computa la misma estructura usando el flujo NUEVO (eager loading) — replica
 * exactamente VacationReport::employeesData() pero sin la paginación.
 */
function computeNewFlow(int $currentYear): array
{
    $calculator = app(VacationCalculatorService::class);

    $employees = User::with([
            'job.departamento',
            'jefe',
            'vacationsAvailable',
            'requestVacations' => function ($q) use ($currentYear) {
                $q->where('human_resources_status', 'Aprobada')
                  ->whereHas('requestDays', function ($qq) use ($currentYear) {
                      $qq->whereYear('start', $currentYear);
                  });
            },
            'requestVacations.requestDays' => function ($q) use ($currentYear) {
                $q->whereYear('start', $currentYear);
            },
        ])
        ->whereHas('job')
        ->where('active', 1)
        ->orderBy('id')
        ->get();

    return $employees->map(function ($employee) use ($calculator, $currentYear) {
        $vacationData = $calculator->getAvailableDaysForUser($employee);

        $daysTaken = 0;
        $vacationPeriods = collect();
        foreach ($employee->requestVacations as $r) {
            $days = $r->requestDays
                ->filter(fn($d) => date('Y', strtotime($d->start)) == $currentYear)
                ->sortBy('start');
            if ($days->count() === 0) continue;
            $daysTaken += $days->count();
            $vacationPeriods->push([
                'start' => $days->first()->start,
                'end' => $days->last()->start,
                'days_count' => $days->count(),
                'type' => $r->type_request,
            ]);
        }

        $allVacationPeriods = $employee->vacationsAvailable
            ->sortByDesc(fn($p) => $p->date_end ? $p->date_end->getTimestamp() : 0)
            ->values();

        $today = \Carbon\Carbon::today();
        $oldestActivePeriod = $allVacationPeriods
            ->filter(function ($period) use ($today) {
                $cutoffDate = !empty($period->cutoff_date)
                    ? \Carbon\Carbon::parse($period->cutoff_date)->endOfDay()
                    : \Carbon\Carbon::parse($period->date_end)->addMonths(15)->endOfDay();
                $isExpired = $today->gt($cutoffDate)
                    || $period->is_historical
                    || (isset($period->status) && $period->status === 'vencido');
                return !$isExpired;
            })
            ->sortBy('date_end')
            ->first();

        $oldestCutoff = null;
        if ($oldestActivePeriod) {
            $oldestCutoff = !empty($oldestActivePeriod->cutoff_date)
                ? \Carbon\Carbon::parse($oldestActivePeriod->cutoff_date)->format('Y-m-d')
                : \Carbon\Carbon::parse($oldestActivePeriod->date_end)->addMonths(15)->format('Y-m-d');
        }

        // hasExpiring/Expired usando la relación cargada
        $hasExpiring = false;
        $hasExpired = false;
        $threeMonthsFromNow = $today->copy()->addMonths(3);
        foreach ($employee->vacationsAvailable->filter(fn($p) => $p->is_historical == false) as $p) {
            $expDate = \Carbon\Carbon::parse($p->date_end)->addMonths(15);
            $isExp = $today->gt($expDate) || $p->is_historical || (isset($p->status) && $p->status === 'vencido');
            $rem = round($p->days_availables - $p->days_enjoyed);
            if (!$isExp && $expDate->lte($threeMonthsFromNow) && $rem > 0) $hasExpiring = true;
            if ($isExp && $rem > 0) $hasExpired = true;
        }

        return [
            'id' => $employee->id,
            'days_entitled' => $vacationData['total_available'],
            'days_taken' => $daysTaken,
            'days_remaining' => $vacationData['total_remaining'],
            'all_periods_count' => $allVacationPeriods->count(),
            'vacation_periods_count' => $vacationPeriods->count(),
            'has_expiring' => $hasExpiring,
            'has_expired' => $hasExpired,
            'oldest_cutoff' => $oldestCutoff,
        ];
    })->keyBy('id')->all();
}

$currentYear = (int) date('Y');

echo "=== Verificación de optimización del reporte de vacaciones ===\n";
echo "Año actual: $currentYear\n\n";

// Logueamos en TODAS las conexiones (vacations_availables y otros viven en mysql_vacations).
$connections = ['mysql', 'mysql_vacations'];
$counts = ['old' => 0, 'new' => 0];
$phase = 'old';
foreach ($connections as $name) {
    DB::connection($name)->listen(function ($query) use (&$counts, &$phase) {
        $counts[$phase]++;
    });
}

// FLUJO VIEJO
$phase = 'old';
$t0 = microtime(true);
$oldResults = computeOldFlow($currentYear);
$oldTime = microtime(true) - $t0;
$oldQueries = $counts['old'];

// FLUJO NUEVO
$phase = 'new';
$t0 = microtime(true);
$newResults = computeNewFlow($currentYear);
$newTime = microtime(true) - $t0;
$newQueries = $counts['new'];

echo sprintf("FLUJO VIEJO:  %d empleados | %d queries | %.3fs\n", count($oldResults), $oldQueries, $oldTime);
echo sprintf("FLUJO NUEVO:  %d empleados | %d queries | %.3fs\n", count($newResults), $newQueries, $newTime);
echo sprintf("Reducción:    %d → %d queries (%.1fx menos)\n\n",
    $oldQueries,
    $newQueries,
    $oldQueries > 0 ? $oldQueries / max(1, $newQueries) : 0
);

// COMPARACIÓN
$mismatched = [];
foreach ($oldResults as $id => $oldData) {
    if (!isset($newResults[$id])) {
        $mismatched[$id] = ['reason' => 'usuario faltante en flujo nuevo'];
        continue;
    }
    $newData = $newResults[$id];

    $diffs = [];
    foreach (['days_entitled', 'days_taken', 'days_remaining',
              'all_periods_count', 'vacation_periods_count',
              'has_expiring', 'has_expired', 'oldest_cutoff'] as $field) {
        if ($oldData[$field] != $newData[$field]) {
            $diffs[$field] = ['old' => $oldData[$field], 'new' => $newData[$field]];
        }
    }
    if (!empty($diffs)) {
        $mismatched[$id] = $diffs;
    }
}

if (empty($mismatched)) {
    echo "✓ Sin diferencias entre flujo viejo y nuevo en " . count($oldResults) . " empleados.\n";
} else {
    echo "✗ DIFERENCIAS encontradas en " . count($mismatched) . " empleados:\n";
    foreach ($mismatched as $id => $diff) {
        echo "  Usuario $id: " . json_encode($diff, JSON_UNESCAPED_UNICODE) . "\n";
    }
}

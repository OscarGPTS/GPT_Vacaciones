<?php
/**
 * Test cross-database separation (rh ↔ rh_vacations)
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\VacationsAvailable;
use App\Models\RequestVacations;
use App\Models\VacationPerYear;
use App\Models\NoWorkingDays;
use App\Models\SystemLog;
use App\Models\DirectionApprover;
use App\Models\ManagerApprover;
use App\Models\RequestApproved;
use App\Models\RequestRejected;

echo "========================================\n";
echo "  CROSS-DATABASE SEPARATION TEST\n";
echo "========================================\n\n";

// 1. Test connections
echo "1. TESTING MODEL CONNECTIONS\n";
echo str_repeat('-', 40) . "\n";
$models = [
    'User' => new User(),
    'VacationsAvailable' => new VacationsAvailable(),
    'RequestVacations' => new RequestVacations(),
    'VacationPerYear' => new VacationPerYear(),
    'NoWorkingDays' => new NoWorkingDays(),
    'SystemLog' => new SystemLog(),
    'DirectionApprover' => new DirectionApprover(),
    'ManagerApprover' => new ManagerApprover(),
    'RequestApproved' => new RequestApproved(),
    'RequestRejected' => new RequestRejected(),
];

foreach ($models as $name => $model) {
    $conn = $model->getConnectionName();
    $expected = ($name === 'User') ? 'mysql' : 'mysql_vacations';
    $status = ($conn === $expected) ? '✓' : '✗';
    echo "  {$status} {$name}: {$conn} (expected: {$expected})\n";
}

// 2. Test basic queries
echo "\n2. TESTING BASIC QUERIES\n";
echo str_repeat('-', 40) . "\n";
try {
    $userCount = User::count();
    echo "  ✓ User::count() = {$userCount}\n";
} catch (\Exception $e) {
    echo "  ✗ User::count() FAILED: {$e->getMessage()}\n";
}

try {
    $vaCount = VacationsAvailable::count();
    echo "  ✓ VacationsAvailable::count() = {$vaCount}\n";
} catch (\Exception $e) {
    echo "  ✗ VacationsAvailable::count() FAILED: {$e->getMessage()}\n";
}

try {
    $reqCount = RequestVacations::count();
    echo "  ✓ RequestVacations::count() = {$reqCount}\n";
} catch (\Exception $e) {
    echo "  ✗ RequestVacations::count() FAILED: {$e->getMessage()}\n";
}

try {
    $vpyCount = VacationPerYear::count();
    echo "  ✓ VacationPerYear::count() = {$vpyCount}\n";
} catch (\Exception $e) {
    echo "  ✗ VacationPerYear::count() FAILED: {$e->getMessage()}\n";
}

// 3. Test cross-DB relationships (BelongsTo - separate queries)
echo "\n3. TESTING CROSS-DB RELATIONSHIPS (with/BelongsTo)\n";
echo str_repeat('-', 40) . "\n";

try {
    $user = User::first();
    if ($user) {
        $vacCount = $user->vacationsAvailable()->count();
        echo "  ✓ User->vacationsAvailable()->count() = {$vacCount}\n";
    } else {
        echo "  - No users found (skip)\n";
    }
} catch (\Exception $e) {
    echo "  ✗ User->vacationsAvailable() FAILED: {$e->getMessage()}\n";
}

try {
    $va = VacationsAvailable::first();
    if ($va) {
        $userName = $va->user->first_name ?? 'N/A';
        echo "  ✓ VacationsAvailable->user = {$userName}\n";
    } else {
        echo "  - No VacationsAvailable records (skip)\n";
    }
} catch (\Exception $e) {
    echo "  ✗ VacationsAvailable->user FAILED: {$e->getMessage()}\n";
}

// 4. Test cross-DB whereHas (subqueries - needs views)
echo "\n4. TESTING CROSS-DB whereHas (CRITICAL)\n";
echo str_repeat('-', 40) . "\n";

// User -> whereHas('requestVacations') : main DB -> vacation DB
try {
    $count = User::whereHas('requestVacations')->count();
    echo "  ✓ User::whereHas('requestVacations') = {$count}\n";
} catch (\Exception $e) {
    echo "  ✗ User::whereHas('requestVacations') FAILED: {$e->getMessage()}\n";
}

// RequestVacations -> whereHas('user') : vacation DB -> main DB
try {
    $count = RequestVacations::whereHas('user')->count();
    echo "  ✓ RequestVacations::whereHas('user') = {$count}\n";
} catch (\Exception $e) {
    echo "  ✗ RequestVacations::whereHas('user') FAILED: {$e->getMessage()}\n";
}

// 5. Test cross-DB eager loading
echo "\n5. TESTING CROSS-DB EAGER LOADING\n";
echo str_repeat('-', 40) . "\n";

try {
    $requests = RequestVacations::with('user', 'directManager')->limit(5)->get();
    echo "  ✓ RequestVacations::with('user','directManager') loaded {$requests->count()} records\n";
} catch (\Exception $e) {
    echo "  ✗ RequestVacations::with('user') FAILED: {$e->getMessage()}\n";
}

try {
    $users = User::with('vacationsAvailable')->limit(5)->get();
    echo "  ✓ User::with('vacationsAvailable') loaded {$users->count()} records\n";
} catch (\Exception $e) {
    echo "  ✗ User::with('vacationsAvailable') FAILED: {$e->getMessage()}\n";
}

// 6. Test DB::connection direct queries
echo "\n6. TESTING DB::connection() DIRECT QUERIES\n";
echo str_repeat('-', 40) . "\n";

try {
    $count = DB::connection('mysql_vacations')->table('vacations_availables')->count();
    echo "  ✓ DB::connection('mysql_vacations')->table('vacations_availables') = {$count}\n";
} catch (\Exception $e) {
    echo "  ✗ DB::connection('mysql_vacations') FAILED: {$e->getMessage()}\n";
}

try {
    $count = DB::connection('mysql')->table('users')->count();
    echo "  ✓ DB::connection('mysql')->table('users') = {$count}\n";
} catch (\Exception $e) {
    echo "  ✗ DB::connection('mysql') FAILED: {$e->getMessage()}\n";
}

echo "\n========================================\n";
echo "  ALL TESTS COMPLETED\n";
echo "========================================\n";

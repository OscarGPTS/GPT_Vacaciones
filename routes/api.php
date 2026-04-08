<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rrhh\PuestoController;
use App\Http\Controllers\Rrhh\EmpleadoAniversarioController;
use App\Http\Controllers\Rrhh\EmpleadoController;
use App\Http\Controllers\Api\AutoApprovalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('empleados/aniversario', [EmpleadoAniversarioController::class, 'existeAniversario']);
    
    // Rutas para aprobaciones automáticas de vacaciones
    Route::prefix('vacations/auto-approvals')->group(function () {
        Route::post('process', [AutoApprovalController::class, 'processAutoApprovals']);
        Route::get('stats', [AutoApprovalController::class, 'getStats']);
        Route::get('dry-run', [AutoApprovalController::class, 'dryRun']);
        Route::post('hr/enable', [AutoApprovalController::class, 'enableHRAutoApprovals']);
        Route::post('hr/disable', [AutoApprovalController::class, 'disableHRAutoApprovals']);
    });
});

Route::get('puestos/areas', [PuestoController::class, 'areas'])->name('api.puestos.areas');
Route::get('puestos/departamentos', [PuestoController::class, 'departamentos'])->name('api.puestos.departamentos');

Route::get('avatar/{id}', [EmpleadoController::class, 'getAvatar'])
    ->name('avatar.show');

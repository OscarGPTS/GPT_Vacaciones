<?php

use App\Models\Job;
use App\Models\Area;
use App\Models\User;
use App\Models\Departamento;
use App\Models\PersonalData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\Vacaciones\VacacionesCotroller;
use App\Http\Controllers\VacacionesController;
use App\Livewire\PruebaComponent;
use App\Livewire\VacacionesDireccion;
use App\Livewire\VacacionesJefeDirecto;
use App\Livewire\VacationCalendar;
use App\Livewire\VacationImport;

// Redirigir la página de inicio a vacaciones si está autenticado
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('vacaciones.index');
    }
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login/google', [LoginController::class, 'redirectToProvider'])->name('login.redirect');
Route::get('/login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('login.pruebas');

Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware(['auth'])->group(function () {
    // Redirigir /home a vacaciones
    Route::get('/home', function () {
        return redirect()->route('vacaciones.index');
    })->name('home');

    // Rutas del módulo de vacaciones simplificado
    Route::prefix('vacaciones')->name('vacaciones.')->group(function () {
        Route::get('/', [VacacionesController::class, 'index'])->name('index');
        Route::get('/create', [VacacionesController::class, 'create'])->name('create');
        Route::post('/store', [VacacionesController::class, 'store'])->name('store');
        Route::post('/ajax', [VacacionesController::class, 'ajax'])->name('ajax');
        Route::post('/get-user-restrictions', [VacacionesController::class, 'getUserRestrictions'])->name('get-user-restrictions');
        Route::post('/check-day-period', [VacacionesController::class, 'checkDayPeriod'])->name('check-day-period');

        // Rutas para aprobaciones
        Route::get('/aprobar', VacacionesJefeDirecto::class)->name('aprobar');
        Route::post('/aprobar/{id}', [RequestController::class, 'approveRejectManager'])->name('aprobar.action'); // Legacy - NO USAR
        
        // Rutas para Dirección
        Route::get('/direccion', VacacionesDireccion::class)->name('direccion');
        
        // Rutas para RH
        Route::get('/rh', [RequestController::class, 'authorizeRequestRH'])->name('rh');
        Route::post('/rh/{id}', [RequestController::class, 'approveRejectRH'])->name('rh.action');
        Route::get('/reporte', [RequestController::class, 'vacationReportLivewire'])->name('reporte');
        Route::get('/importar', VacationImport::class)->name('importar')->middleware('can:ver modulo rrhh');
        Route::get('/calendario', VacationCalendar::class)->name('calendario');
        Route::post('/update-days-enjoyed', [RequestController::class, 'updateDaysEnjoyed'])->name('update-days-enjoyed');
        Route::post('/sync-vacations', [RequestController::class, 'syncVacations'])->name('sync-vacations');
        Route::post('/update-periods', [RequestController::class, 'updatePeriods'])->name('update-periods');
        Route::post('/update-days', [RequestController::class, 'updateDays'])->name('update-days');
        Route::get('/generar-pdf/{id}', [RequestController::class, 'generateVacationPdf'])->name('generar-pdf');
    });

});


Route::get('download-file/{id}', [MediaController::class, 'download'])->name('download.file');

// Rutas de cada modulo
@include_once('rrhh.php');
@include_once('perfil.php');
if (config('app.env') === 'local') {
    // @include_once('pruebas.php');
    // @include_once('routes_pruebas.php'); // Comentado por closures que no permiten route:cache
}


Route::get('pruebas',PruebaComponent::class);

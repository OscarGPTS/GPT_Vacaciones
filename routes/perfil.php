<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Perfil\CvController;
use App\Http\Controllers\Perfil\ProfileController;
use App\Http\Controllers\Perfil\FirmaController;
use App\Livewire\Empleados\PersonalDataComponent;
use App\Livewire\RequisicionCurso\CreateComponent;
use App\Livewire\RequisicionCurso\RevisarComponent;
use App\Livewire\RequisicionCurso\AutorizarComponent;

use App\Http\Controllers\Rrhh\RequisicionCursoController;
use App\Livewire\RequisicionCurso\RevisarGerenteComponent;
use App\Http\Controllers\Perfil\RequisicionPersonalController;
use App\Http\Controllers\Perfil\RequisicionPersonal\RevisarController;
use App\Http\Controllers\Perfil\RequisicionPersonal\AutorizarController;
use App\Http\Controllers\Perfil\RequisicionPersonal\SolicitarController;
use App\Http\Controllers\Perfil\RequisicionCurso\RevisarController as RevisarCursoController;
use App\Http\Controllers\Perfil\RequisicionCurso\SolicitarController as SolicitarCursoController;

Route::middleware(['auth'])->group(function () {

    Route::get('perfil', [ProfileController::class, 'show'])
        ->name('perfil.show');

    Route::post('perfil/foto', [ProfileController::class, 'updatePhoto'])
        ->name('perfil.foto');

    // Firma digital del usuario
    Route::post('perfil/firma', [FirmaController::class, 'store'])->name('perfil.firma.store');
    Route::delete('perfil/firma', [FirmaController::class, 'destroy'])->name('perfil.firma.destroy');

    Route::get('perfil/informacion-personal', PersonalDataComponent::class)
    ->name('perfil.informacion_personal');

    Route::get('perfil/requisiciones-personal', [SolicitarController::class, 'index'])
        ->name('perfil.requisiciones.personal.index');

    Route::get('perfil/requisiciones-personal/crear', [SolicitarController::class, 'create'])
        ->name('perfil.requisiciones.personal.create');
    Route::get('perfil/requisiciones-personal/ver/{id}', [SolicitarController::class, 'show'])
        ->name('perfil.requisiciones.personal.show');

    Route::get('perfil/cv/ver', [CvController::class, 'show'])
        ->name('perfil.cv.show');
    Route::get('perfil/cv/pdf', [CvController::class, 'pdf'])
        ->name('perfil.cv.pdf');
});
Route::middleware(['auth', 'can:editar otros cvs'])->group(function () {
    Route::get('perfil/cv/otros/pdf/{id}', [CvController::class, 'pdfOtros'])
        ->name('perfil.cv.otros.pdf');
    Route::get('perfil/cv/editar-otros', [CvController::class, 'indexOtros'])
        ->name('perfil.cv.editar.otros');
    Route::get('perfil/cv/editar-otros/{id}', [CvController::class, 'showOtros'])
        ->name('perfil.cv.show.otros');
});

Route::middleware(['auth', 'can:requisicion personal revisar'])->group(function () {
    Route::get('perfil/requisiciones-personal/revisar', [RevisarController::class, 'index'])
        ->name('perfil.requisiciones.personal.revisar.index');
    Route::get('perfil/requisiciones-personal/revisar/{id}', [RevisarController::class, 'show'])
        ->name('perfil.requisiciones.personal.revisar.show');
});
Route::middleware(['auth', 'can:requisicion personal autorizar'])->group(function () {
    Route::get('perfil/requisiciones-personal/autorizar', [AutorizarController::class, 'index'])
        ->name('perfil.requisiciones.personal.autorizar.index');
    Route::get('perfil/requisiciones-personal/autorizar/{id}', [AutorizarController::class, 'show'])
        ->name('perfil.requisiciones.personal.autorizar.show');
});
// Requisiciones para cursos o capacitacion
Route::middleware(['auth','can:ver modulo rrhh'])->group(function () {

    Route::get('requisiciones-curso/historial/ver/{id}/cerrar', [RequisicionCursoController::class, 'cerrar'])
        ->name('rrhh.requisiciones.curso.cerrar');

    Route::get('requisiciones-curso/historial/ver/{id}/pdf', [RequisicionCursoController::class, 'pdf'])
        ->name('rrhh.requisiciones.curso.pdf');

    Route::get('requisiciones-curso/historial/ver/{id}', [RequisicionCursoController::class, 'show'])
        ->name('rrhh.requisiciones.curso.show');


    Route::get('requisiciones-curso/historial', [RequisicionCursoController::class, 'index'])
        ->name('rrhh.requisiciones.curso.historial');
});

Route::middleware(['auth','can:requisicion curso autorizar'])->group(function () {
    Route::get('requisiciones-curso/autorizar/{id}', AutorizarComponent::class)
    ->name('dg.requisiciones.curso.show');
Route::get('requisiciones-curso/autorizar', [RevisarCursoController::class, 'indexDg'])
    ->name('dg.requisiciones.curso.index');
});
Route::middleware(['auth'])->group(function () {

    // rutas para revisar
    Route::get('requisiciones-curso/revisar/{id}', RevisarComponent::class)
        ->name('revisar.requisiciones.curso.show');
    Route::get('requisiciones-curso/revisar', [RevisarCursoController::class, 'index'])
        ->name('jefe.requisiciones.curso.index');


    Route::get('requisiciones-curso/revisar-gerente/{id}', RevisarGerenteComponent::class)
        ->name('revisar_gerente.requisiciones.curso.show');
    Route::get('requisiciones-curso/revisar-gerente', [RevisarCursoController::class, 'indexGerente'])
        ->name('gerente.requisiciones.curso.indexGerente');


    // rutas para solicitante
    Route::get('requisiciones-curso/crear', CreateComponent::class)
        ->name('requisiciones.curso.create');
    Route::get('requisiciones-curso', [SolicitarCursoController::class, 'index'])
        ->name('requisiciones.curso.index');

    Route::get('requisiciones-curso/{id}', [SolicitarCursoController::class, 'show'])
        ->name('requisiciones.curso.show');
});


Route::get('public/cv/{id}', [CvController::class, 'showCvPublic'])
    ->name('perfil.public.show.cv');

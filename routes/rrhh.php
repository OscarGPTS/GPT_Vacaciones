<?php

use App\Livewire\AreaComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\DepartamentoComponent;
use App\Http\Controllers\Perfil\CvController;
use App\Livewire\Empleados\FotoComponent;
use App\Http\Controllers\Rrhh\PuestoController;
use App\Http\Controllers\Rrhh\EmpleadoController;
use App\Http\Controllers\Rrhh\OrganigramaController;
use App\Livewire\Empleados\PersonalDataComponent;
use App\Http\Controllers\Rrhh\RequisicionPersonalController;
use App\Livewire\Empleados\CheckDocumentoComponent;


Route::get('empleados/{empleado}/credencial', [EmpleadoController::class, 'credencial'])
    ->name('empleados.credencial')
    ->middleware(['auth', 'can:ver modulo rrhh']);
Route::get('empleados/{empleado}/aniversario', [EmpleadoController::class, 'aniversario'])
    ->name('empleados.aniversario')
    ->middleware(['auth', 'can:ver modulo rrhh']);
Route::get('empleados/excel', [EmpleadoController::class, 'excel'])
    ->name('empleados.excel')
    ->middleware(['auth', 'can:ver modulo rrhh']);

Route::get('empleados/{user}/foto', FotoComponent::class)
    ->name('empleados.foto')
    ->middleware(['auth', 'can:ver modulo rrhh']);

Route::get('empleados/cv/editar/{id}', [EmpleadoController::class, 'editCv'])
    ->name('empleados.cv.editar')
    ->middleware(['auth', 'can:ver modulo rrhh']);

Route::get('empleados/cv/pdf/{id}', [EmpleadoController::class, 'pdfCv'])
    ->name('empleados.cv.otros.pdf')
    ->middleware(['auth', 'can:ver modulo rrhh']);
Route::get('empleados/cv/certificado/pdf/{id}', [EmpleadoController::class, 'certificadoPDF'])
    ->name('empleados.cv.certificado.pdf')
    ->middleware(['auth', 'can:ver modulo rrhh']);

Route::get('empleados/sincronizar-informacion/{empleado}', [EmpleadoController::class, 'sincronizar'])
    ->name('empleados.sincronizar')->middleware('role:super-admin')
    ->middleware(['auth', 'can:ver modulo rrhh']);

Route::get('empleados/informacion-personal/{id}', PersonalDataComponent::class)
    ->name('empleados.informacion_personal')
    ->middleware(['auth', 'can:ver modulo rrhh']);

Route::get('empleados', [EmpleadoController::class, 'index'])
    ->name('empleados.index')
    ->middleware(['auth', 'can:list colaborador']);

Route::get('empleados/crear', [EmpleadoController::class, 'create'])
    ->name('empleados.create')
    ->middleware(['auth', 'can:create colaborador']);

Route::get('empleados/{id}/editar', [EmpleadoController::class, 'edit'])
    ->name('empleados.edit')
    ->middleware(['auth', 'can:edit colaborador']);

Route::get('empleados/{id}', [EmpleadoController::class, 'show'])
    ->name('empleados.show')
    ->middleware(['auth', 'can:show colaborador']);

Route::get('empleados/documentos/{id}', CheckDocumentoComponent::class)
    ->name('empleados.documentos')
    ->middleware(['auth', 'can:show check documentos']);

Route::get('empleados/documentos/check/excel', [EmpleadoController::class, 'DocumentosdCheckExcel'])
    ->name('empleados.documentos.check.excel')
    ->middleware(['auth', 'can:show check documentos']);

Route::get('empleados/documentos/check/pdf/{id}', [EmpleadoController::class, 'DocumentosdCheckPDF'])
    ->name('empleados.documentos.check.pdf')
    ->middleware(['auth', 'can:show check documentos']);


// Rutas del organigrama
Route::get('organigrama', [OrganigramaController::class, 'index'])->name('organigrama.index');
Route::get('organigrama/data', [OrganigramaController::class, 'index_data'])->name('organigrama.data');
Route::get('organigrama/getEmployees', [OrganigramaController::class, 'getEmployees'])->name('organigrama.getEmployees');
Route::get('organigrama/getEmployeesByDepartment/{department}', [OrganigramaController::class, 'getEmployeesByDepartment'])->name('organigrama.getEmployeesByDepartment');
Route::get('organigrama/getEmployeesByOrganization/{organization}', [OrganigramaController::class, 'getEmployeesByOrganization'])->name('organigrama.getEmployeesByOrganization');
Route::get('organigrama/proxy-image', [OrganigramaController::class, 'proxyImage'])->name('organigrama.proxyImage');

Route::middleware(['auth', 'can:ver modulo rrhh'])->group(function () {
    Route::get('puestos', [PuestoController::class, 'index'])
        ->name('puestos.index');
    Route::get('puestos/{puesto}/pdf', [PuestoController::class, 'pdf'])
        ->name('puestos.pdf');
    Route::get('puestos/{puesto}', [PuestoController::class, 'show'])
        ->name('puestos.show');

    Route::get('puestos/{puesto}/puesto', [PuestoController::class, 'puesto'])
        ->name('puestos.puesto');
    Route::post('puestos/{puesto}/puesto', [PuestoController::class, 'puestoGuardar'])
        ->name('puesto.puesto.guardar');

    // Route::resource('puestos', PuestoController::class);

    Route::get('areas', AreaComponent::class)
        ->name('areas');
    Route::get('departamentos', DepartamentoComponent::class)
        ->name('departamentos');



    Route::get('requisiciones/personal', [RequisicionPersonalController::class, 'index'])
        ->name('rrhh.requisiciones.personal.index');

    Route::get('requisiciones/personal/{id}', [RequisicionPersonalController::class, 'show'])
        ->name('rrhh.requisiciones.personal.show');
    Route::get('requisiciones/personal/pdf/{id}', [RequisicionPersonalController::class, 'pdf'])
        ->name('rrhh.requisiciones.personal.pdf');

    Route::post('requisiciones/personal/finalizar/{id}', [RequisicionPersonalController::class, 'finalizar'])
        ->name('rrhh.requisiciones.personal.finalizar');
    Route::post('requisiciones/personal/notificar/{id}', [RequisicionPersonalController::class, 'notificar'])
        ->name('rrhh.requisiciones.personal.notificar');
});

// Rutas de Administración - Solo super-admin (verificación en el controlador)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Rrhh\AdminController::class, 'index'])->name('admin.index');
    Route::get('users-data', [App\Http\Controllers\Rrhh\AdminController::class, 'getUsersData'])->name('admin.users-data');
    Route::get('user/{id}/roles-permissions', [App\Http\Controllers\Rrhh\AdminController::class, 'getUserRolesAndPermissions'])->name('admin.user-roles-permissions');
    Route::post('assign-role', [App\Http\Controllers\Rrhh\AdminController::class, 'assignRole'])->name('admin.assign-role');
    Route::post('remove-role', [App\Http\Controllers\Rrhh\AdminController::class, 'removeRole'])->name('admin.remove-role');
    Route::post('assign-permission', [App\Http\Controllers\Rrhh\AdminController::class, 'assignPermission'])->name('admin.assign-permission');
    Route::post('remove-permission', [App\Http\Controllers\Rrhh\AdminController::class, 'removePermission'])->name('admin.remove-permission');
    Route::post('create-role', [App\Http\Controllers\Rrhh\AdminController::class, 'createRole'])->name('admin.create-role');
    Route::post('delete-role', [App\Http\Controllers\Rrhh\AdminController::class, 'deleteRole'])->name('admin.delete-role');
    Route::post('assign-permission-to-role', [App\Http\Controllers\Rrhh\AdminController::class, 'assignPermissionToRole'])->name('admin.assign-permission-to-role');
    Route::post('remove-permission-from-role', [App\Http\Controllers\Rrhh\AdminController::class, 'removePermissionFromRole'])->name('admin.remove-permission-from-role');
    Route::post('create-permission', [App\Http\Controllers\Rrhh\AdminController::class, 'createPermission'])->name('admin.create-permission');
    Route::post('delete-permission', [App\Http\Controllers\Rrhh\AdminController::class, 'deletePermission'])->name('admin.delete-permission');
    
    // Gestión de Aprobadores de Dirección
    Route::prefix('direction-approvers')->name('admin.direction-approvers.')->group(function() {
        Route::get('/', [App\Http\Controllers\Admin\DirectionApproversController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\DirectionApproversController::class, 'store'])->name('store');
        Route::post('{id}/toggle', [App\Http\Controllers\Admin\DirectionApproversController::class, 'toggle'])->name('toggle');
        Route::delete('{id}', [App\Http\Controllers\Admin\DirectionApproversController::class, 'destroy'])->name('destroy');
        Route::get('user/{userId}/departments', [App\Http\Controllers\Admin\DirectionApproversController::class, 'getUserDepartments'])->name('user-departments');
        Route::put('{bossId}', [App\Http\Controllers\Admin\DirectionApproversController::class, 'update'])->name('update');
        Route::delete('{bossId}/all', [App\Http\Controllers\Admin\DirectionApproversController::class, 'destroyAll'])->name('destroy-all');
    });

    // Gestión de Jefes Directos Personalizados
    Route::prefix('manager-approvers')->name('admin.manager-approvers.')->group(function() {
        Route::get('/', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'store'])->name('store');
        Route::post('{id}/toggle', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'toggle'])->name('toggle');
        Route::delete('{bossId}', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'destroy'])->name('destroy');
        Route::get('user/{userId}/departments', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'getUserDepartments'])->name('user-departments');
        Route::put('{bossId}', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'update'])->name('update');
        Route::delete('{bossId}/all', [App\Http\Controllers\Admin\AdminManagerApproversController::class, 'destroyAll'])->name('destroy-all');
    });

    // Gestión de Permisos de Delegación
    Route::prefix('delegation-permissions')->name('admin.delegation-permissions.')->group(function() {
        Route::get('/', [App\Http\Controllers\Admin\DelegationPermissionsController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\DelegationPermissionsController::class, 'store'])->name('store');
        Route::post('{id}/toggle', [App\Http\Controllers\Admin\DelegationPermissionsController::class, 'toggle'])->name('toggle');
        Route::delete('{id}', [App\Http\Controllers\Admin\DelegationPermissionsController::class, 'destroy'])->name('destroy');
    });

    // Prueba de Envío de Correo
    Route::get('test-email', [App\Http\Controllers\TestEmailController::class, 'index'])->name('admin.test-email');
    Route::post('test-email/send', [App\Http\Controllers\TestEmailController::class, 'send'])->name('admin.test-email.send');

    // Optimización del Sistema
    Route::get('optimize', [App\Http\Controllers\OptimizeController::class, 'index'])->name('admin.optimize');
    Route::post('optimize/execute', [App\Http\Controllers\OptimizeController::class, 'executeCommand'])->name('admin.optimize.execute');
    Route::post('optimize/all', [App\Http\Controllers\OptimizeController::class, 'optimizeAll'])->name('admin.optimize.all');
    Route::get('optimize/system-info', [App\Http\Controllers\OptimizeController::class, 'systemInfo'])->name('admin.optimize.system-info');
});

Route::get('birthday/{id}', [EmpleadoController::class, 'birthdayShow'])
    ->name('birthday.show');

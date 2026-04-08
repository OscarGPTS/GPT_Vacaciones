<?php

use App\Models\Job;
use App\Models\Area;
use App\Models\User;
use App\Mail\Aniversario;
use App\Models\RazonSocial;
use Illuminate\Support\Str;
use App\Models\Departamento;

use App\Models\PersonalData;
use App\Livewire\TestComponent;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RequisicionCurso;
use Illuminate\Support\Facades\DB;
use App\Models\RequisicionPersonal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Services\Perfil\RqCursoService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\MediaLibrary\Support\MediaStream;
use App\Http\Controllers\Login\LoginController;

function actualizarUsers($empleados)
{

    $puestos = Job::all();

    try {
        DB::beginTransaction();
        foreach ($empleados as $empleado) {
            $empresa = 4;

            if ($empleado['RAZÓN SOCIAL'] == 'TECH ENERGY CONTROL') {
                $empresa = 1;
            }
            if ($empleado['RAZÓN SOCIAL'] == 'GPT INGENIERIA') {
                $empresa = 2;
            }
            if ($empleado['RAZÓN SOCIAL'] == 'ESQUEMA') {
                $empresa = 3;
            }

            $job = $puestos->firstWhere('name', trim($empleado['PUESTO ACTUAL']));
            if ($job) {
                $newUser = App\Models\User::create([
                    'id' => $empleado['ID'],
                    'last_name' => $empleado['APELLIDOS'],
                    'first_name' => $empleado['NOMBRE'],
                    'business_name_id' => $empresa,
                    'admission' => $empleado['ADMISIÓN'],
                    'job_id' => $job->id,
                    'boss_id' => empty($empleado['# JEFE INMEDIATO']) ? 199 : $empleado['# JEFE INMEDIATO'],
                    'email' => $empleado['CORREO'],
                    'phone' => $empleado['TELÉFONO'],
                    // 'profile_image' => "http://rrhh.satechenergy.org/storage/avatars/" . $empleado['ID'] . ".jpg",
                    'active' => 1
                ]);

                $newUserPersonal = PersonalData::create([
                    'user_id' => $newUser->id,
                    'birthday' => $empleado['NACIMIENTO'],
                    'curp' => $empleado['CURP'],
                    'rfc' => $empleado['RFC'],
                    'nss' => $empleado['NSS'],
                    'personal_mail' => $empleado['CORREO PESONAL'],
                    'personal_phone' => $empleado['TELEFONO PERSONAL'],
                    'education_level' => 'Sin especificar',
                    'education_level_score' => 0
                ]);
            } else {
                dump('puesto no existe:' . $empleado['PUESTO ACTUAL']);
            }
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        return ($e->getMessage());
    }
}


Route::get('empresa', function () {

    $excel = fastexcel()->import('empleados.xlsx');

    $excel = $excel->unique('PUESTO ACTUAL');
    $excel = $excel->map(function ($item) {
        return collect($item)->only(['ÁREA', 'DEPARTAMENTO', 'PUESTO ACTUAL']);
    });
    $areas =  ($excel->groupBy('ÁREA'));

    foreach ($areas as $key => $area) {
        $nuevaArea = '';
        try {
            DB::beginTransaction();
            $nuevaArea = Area::updateOrCreate(
                ['name' => $key],
                ['name' => $key]
            );
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
        foreach ($area as $item) {
            try {
                DB::beginTransaction();
                $nuevaArea->departamento()->updateOrCreate(['name' => $item['DEPARTAMENTO']], ['name' => $item['DEPARTAMENTO'], 'area_id' => $nuevaArea->id]);
                DB::commit();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
            }
        }
        foreach ($area as $item) {
            $depto = Departamento::where('name', $item['DEPARTAMENTO'])->first();
            try {
                DB::beginTransaction();
                Job::updateOrCreate(
                    ['name' => trim($item['PUESTO ACTUAL'])],
                    [
                        'name' => trim($item['PUESTO ACTUAL']),
                        'depto_id' => $depto->id
                    ]
                );
                DB::commit();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
            }
        }
    }
});

// Route::get('nuevos',function(){
//     $empleados = fastexcel()->import('empleados.xlsx');
//     actualizarUsers($empleados);
// });

Route::get('id/{id}', function ($id) {
    $user = User::find($id);
    Auth::login($user);
    return redirect()->route('home');
});

Route::get('tablas', function () {
    $databaseName = DB::connection()->getDatabaseName();
    $tables = DB::table('information_schema.tables')
        ->where('table_schema', $databaseName)
        ->pluck('table_name');

    return  $tables->toArray();
});

Route::get('p', function () {
    $medidas = "[ '2\"', '2\"']";
    echo $medidas[0];
});



Route::get('master', function () {
    return view('layouts.admin.master');
});

Route::get('migrar-rq', function () {
    $rqDB = DB::table('st_rh_rq')
        ->select('*')
        // ->whereYear('created', 2023)
        ->get();

    // return json_decode($rqDB,true);
    $puestos = Job::all();
    $status = [
        0 => 'Rechazada',
        1 => 'En aprobación',
        2 => 'En reclutamiento',
        3 => 'Finalizada',
    ];
    $rqs = [];
    foreach (json_decode($rqDB, true) as $rq) {
        $conocimientos = [];
        $competencias = [];
        $actividades = [];
        $conocimientosDB = json_decode($rq['conocimientos'], true);
        $competenciasDB = json_decode($rq['competencias'], true);
        $actividadesDB = json_decode($rq['actividades'], true);
        if (!empty($conocimientosDB)) {
            foreach ($conocimientosDB as $con) {
                array_push($conocimientos, $con['b']);
            }
        }
        if (!empty($competenciasDB)) {
            foreach ($competenciasDB as $con) {
                array_push($competencias, $con['b']);
            }
        }
        if (!empty($actividadesDB)) {
            foreach ($actividadesDB as $con) {
                array_push($actividades, $con['b']);
            }
        }


        if ($rq['motivoRequisicion'] !== 'Nueva creación') {
            $puesto  = Job::where('name', $rq['puestoSolicitado'])->first();
            $user = User::find($rq['employee_id']);
            if ($puesto && $user) {
                $rqs[] =  [
                    "id" => (int) $rq['id'],
                    "tipo_personal" => $rq['tipoDePersonal'],
                    "motivo" => $rq['motivoRequisicion'],
                    "horario" => $rq['horario'],
                    "personas_requeridas" => (int) $rq['personasRequeridas'],
                    "grado_escolar" => $rq['ultimoGradoEstudios'],
                    "experiencia_years" => (int)$rq['anosDeExperiencia'],
                    "trabajo_campo" => $rq['trabajoEnCampo'] ? true : NULL,
                    "trato_clientes" =>  $rq['tratoClientes'] ? true : NULL,
                    "manejo_personal" =>  $rq['manejoPersonal'] ? true : NULL,
                    "licencia_conducir" =>  $rq['licenciaConducir'] ? true : NULL,
                    "licencia_tipo" =>  $rq['tipoLicencia'],
                    "conocimientos" => $conocimientos,
                    "competencias" => $competencias,
                    "actividades" => $actividades,
                    "status" => $status[$rq['estatus']],
                    "puesto_solicitado" => $puesto->id,
                    "puesto_nuevo" => NULL,
                    "solicitante_id" => $rq['employee_id'],
                    "created_at" => $rq['created'],
                    "updated_at" => $rq['created'],
                ];
            } else {
            }
        } else {
            $rqs[] =  [
                "id" => (int) $rq['id'],
                "tipo_personal" => $rq['tipoDePersonal'],
                "motivo" => $rq['motivoRequisicion'],
                "horario" => $rq['horario'],
                "personas_requeridas" => (int) $rq['personasRequeridas'],
                "grado_escolar" => $rq['ultimoGradoEstudios'],
                "experiencia_years" => (int)$rq['anosDeExperiencia'],
                "trabajo_campo" => $rq['trabajoEnCampo'] ? true : NULL,
                "trato_clientes" =>  $rq['tratoClientes'] ? true : NULL,
                "manejo_personal" =>  $rq['manejoPersonal'] ? true : NULL,
                "licencia_conducir" =>  $rq['licenciaConducir'] ? true : NULL,
                "licencia_tipo" =>  $rq['tipoLicencia'],
                "conocimientos" => $conocimientos,
                "competencias" => $competencias,
                "actividades" => $actividades,
                "status" => $status[$rq['estatus']],
                "puesto_solicitado" => null,
                "puesto_nuevo" => $rq['puestoSolicitado'],
                "solicitante_id" => $rq['employee_id'],
                "created_at" => $rq['created'],
                "updated_at" => $rq['created'],
            ];
        }
    }

    // return $rqs;
    try {
        DB::beginTransaction();
        foreach ($rqs as $rq) {
            RequisicionPersonal::create([
                "id" => intval($rq['id']),
                "tipo_personal" => $rq['tipo_personal'],
                "motivo" => $rq['motivo'],
                "horario" => $rq['horario'],
                "personas_requeridas" => $rq['personas_requeridas'],
                "grado_escolar" => $rq['grado_escolar'],
                "experiencia_years" => $rq['experiencia_years'],
                "trabajo_campo" => $rq['trabajo_campo'],
                "trato_clientes" =>  $rq['trato_clientes'],
                "manejo_personal" =>  $rq['manejo_personal'],
                "licencia_conducir" =>  $rq['licencia_conducir'],
                "licencia_tipo" =>  $rq['licencia_tipo'],
                "conocimientos" => $rq['conocimientos'],
                "competencias" => $rq['competencias'],
                "actividades" => $rq['actividades'],
                "status" => $rq['status'],
                "puesto_solicitado" => $rq['puesto_solicitado'],
                "puesto_nuevo" => $rq['puesto_nuevo'],
                "solicitante_id" => $rq['solicitante_id'],
                "created_at" => $rq['created_at'],
                "updated_at" => $rq['updated_at'],
            ]);
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e);
    }
});


Route::get('razon-social', function () {
    $users = User::with('razonSocial')->get();

    $empresas = RazonSocial::all();

    $usersExcel = fastexcel()->import('empleados.xlsx');
    // return $usersExcel;
    foreach ($users as $user) {
        $excel = $usersExcel->firstWhere('ID', $user->id);
        $empresa = $empresas->firstWhere('short_name', trim($excel['RAZÓN SOCIAL']));
        if ($empresa) {
            try {
                DB::beginTransaction();
                $user->business_name_id = $empresa['id'];
                $user->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage());
            }
        } else {
            logger($user->id);
        }
    }
});
Route::get('uuid', function () {
    $users = User::all();
    foreach ($users as $user) {
        $user->uuid = Str::uuid();
        $user->save();
    }
});

Route::get('puestos-migrar', function () {

    // $puestosDes = DB::connection('mysql_gpt_services')->table('st_app_job_description')->get();
    $puestos = Job::all();
    $puestos2 = DB::connection('mysql_gpt_services')->table('st_app_job')->get();
    $coleccion = $puestos->map(function ($item) {
        // Sanitiza el valor 'nombre' eliminando espacios en blanco al final y convirtiéndolo a minúsculas
        $item['name'] = strtolower(trim($item['name']));
        return $item;
    });
    $coleccion2 = $puestos2->map(function ($item) {
        $item = (array) $item;
        // Sanitiza el valor 'nombre' eliminando espacios en blanco al final y convirtiéndolo a minúsculas
        $item['name'] = strtolower(trim($item['name']));
        return $item;
    });

    dump(count($coleccion));
    dump(count($coleccion2));
    $elementosComunes = [];
    $elementosNoComunes = [];
    foreach ($coleccion as $elemento1) {
        foreach ($coleccion2 as $elemento2) {
            if ($elemento1['name'] === $elemento2['name']) {
                $elementosComunes[] = $elemento1;
            }
        }
    }

    dump(count($elementosNoComunes));
    return count($elementosComunes);
});

Route::get('visita', function () {
    $fecha_string = "26 de enero de 2023";

    // Convierte el string a una marca de tiempo (timestamp)
    $timestamp = strtotime($fecha_string);

    // Obtiene el año de la marca de tiempo
    $year = date("Y", $timestamp);

    // Muestra el año
    echo "El año es: " . $year;
    // $pdf = PDF::loadView('borrador')
    //     ->setPaper('A4', 'portrait');
    //     return $pdf->stream();
});

Route::get('nivel', function () {

    obtenerJerarquiaDeJefes();
    return true;
    $user = $this->solicitante;
    $ids = [];
    while ($user) {
        $ids[] = $user->id;
        if ($user->id == 106) {
            break;
        }
        $user = $user->jefe;
    }
});

function obtenerJerarquiaDeJefes($user_id = 1)
{

    // El nivel maximo son 4

    $lista = collect();
    $users = User::where('active', 1)->get();
    foreach ($users as $user) {
        $ids = [];
        while ($user) {
            $ids[] = $user->id;
            if ($user->id == 106) {
                break;
            }
            $user = $user->jefe;
        }
        // dump($ids);
        $lista->push(($ids));
    }
    dump($lista->sort());
}

Route::get('tablalllls', function () {

    // $tablas = DB::select('SHOW TABLES');
    // Convertir el resultado en un array asociativo
    // $tablas = array_map('current', json_decode(json_encode($tablas), true));
    // return ($tablas);

    //array con el nombre de las tablas
    $tablas = [
        "areas",
        // "audits",
        "cv_certificaciones",
        "cv_curso_certificacions",
        "cv_curso_soldadura",
        "cv_experiencias",
        "cv_historial_servicios",
        "departamentos",
        // "failed_jobs",
        "jobs",
        "media",
        // "migrations",
        "model_has_permissions",
        "model_has_roles",
        // "password_resets",
        "pending_transitions",
        "permissions",
        "personal_access_tokens",
        "puesto_conocimientos",
        "razones_sociales",
        "requisicion_curso_user",
        "requisiciones_curso",
        "requisiciones_personal",
        "role_has_permissions",
        "roles",
        "state_histories",
        // "technical_skills",
        "users",
        "users_personal_data"
    ];
    try {
        foreach ($tablas as $tabla) {
            $comando = 'iseed ' . $tabla . ' --force';
            $exitCode = Artisan::call($comando);
            echo '<br>';
            echo $exitCode;
        }
    } catch (\Exception $e) {
        throw $e;
    }
    // php artisan iseed users --force
});


Route::get('historial', function () {
    $rq = RequisicionCurso::find(5);
    $historial = $rq->status()->history()->get();
    foreach ($historial as $h) {
        dump($h->toArray());
    }

    // return($rq->status()->history()->get()->toJson());
});

Route::get('migrar', function () {
    // $tickets = TicketIT::all();
    // $tablas = DB::connection('mysql_migrar')->select('SHOW TABLES');
    // Convertir el resultado en un array asociativo
    // $tablas = array_map('current', json_decode(json_encode($tablas), true));
    // return ($tablas);
    $tablas = [
        "areas",
        "audits",
        "check_documentos",
        "cv_certificaciones",
        "cv_curso_certificacions",
        "cv_curso_soldadura",
        "cv_experiencias",
        "cv_historial_servicios",
        "departamentos",
        "failed_jobs",
        "jobs",
        "media",
        "migrations",
        "model_has_permissions",
        "model_has_roles",
        "password_resets",
        "pending_transitions",
        "permissions",
        "personal_access_tokens",
        "puesto_conocimientos",
        "razones_sociales",
        "requisicion_curso_user",
        "requisiciones_curso",
        "requisiciones_personal",
        "role_has_permissions",
        "roles",
        "state_histories",
        "users",
        "users_personal_data"
    ];
    try {
        DB::beginTransaction();
        foreach ($tablas as $tabla) {
            $comando = 'iseed ' . $tabla . ' --force';
            $exitCode = Artisan::call($comando);
            echo '<br>';
            echo $exitCode;
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        throw ($e);
    }
});


Route::get('excel-personal-data', function () {
    $users = User::with('personalData')->findOrFail(199);
    return $users;
});

Route::get('down', function () {
    // Let's get some media.

});
Route::get('tablas', function () {

    // $tablas = DB::select('SHOW TABLES');
    // //  Convertir el resultado en un array asociativo
    // $tablas = array_map('current', json_decode(json_encode($tablas), true));
    // return ($tablas);

    //array con el nombre de las tablas
    $tablas = [
        "areas",
        "audits",
        "check_documentos",
        "cv_certificaciones",
        "cv_curso_certificacions",
        "cv_curso_soldadura",
        "cv_experiencias",
        "cv_historial_servicios",
        "departamentos",
        "failed_jobs",
        "jobs",
        "media",
        "migrations",
        "model_has_permissions",
        "model_has_roles",
        "password_resets",
        "pending_transitions",
        "permissions",
        "personal_access_tokens",
        "puesto_conocimientos",
        "razones_sociales",
        "requisicion_curso_user",
        "requisiciones_curso",
        "requisiciones_personal",
        "role_has_permissions",
        "roles",
        "state_histories",
        "users",
        "users_personal_data"
    ];
    try {
        foreach ($tablas as $tabla) {
            $comando = 'iseed ' . $tabla . ' --force';
            $exitCode = Artisan::call($comando);
            echo '<br>';
            echo $exitCode;
        }
    } catch (\Exception $e) {
        throw $e;
    }
    // php artisan iseed users --force
});


Route::get('crear-permisos', function () {
    // create permissions

    // Permission::create(['name' => 'sidebar colaborador']);
    // Permission::create(['name' => 'list colaborador']);
    // Permission::create(['name' => 'show colaborador']);
    Permission::create(['name' => 'create colaborador']);
    Permission::create(['name' => 'edit colaborador']);
    // Permission::create(['name' => 'show check documentos']);
    // $user = User::find(12001);
    // $user->givePermissionTo('sidebar colaborador', 'list colaborador','show colaborador','show check documentos');
    // $user->givePermissionTo('edit colaborador');

});


Route::get('view-test', function () {
    return view('prueba');
});
Route::get('component-test', TestComponent::class);
Route::get('info', function () {
    $imagenes = [
        1 =>  asset('aniversario/plantilla-2/numeros/1.png'),
        2 =>  asset('aniversario/plantilla-2/numeros/2.png'),
        3 =>  asset('aniversario/plantilla-2/numeros/3.png'),
        4 =>  asset('aniversario/plantilla-2/numeros/4.png'),
        5 =>  asset('aniversario/plantilla-2/numeros/5.png'),
        6 =>  asset('aniversario/plantilla-2/numeros/6.png'),
        7 =>  asset('aniversario/plantilla-2/numeros/7.png'),
        8 =>  asset('aniversario/plantilla-2/numeros/8.png'),
        9 =>  asset('aniversario/plantilla-2/numeros/9.png'),
        10 =>  asset('aniversario/plantilla-2/numeros/10.png'),
        11 =>  asset(''),
        12 =>  asset(''),
        13 =>  asset(''),
        14 =>  asset(''),
        15 =>  asset(''),
        16 =>  asset(''),
        17 =>  asset(''),
        18 =>  asset(''),
        19 =>  asset(''),
    ];
    $usersAniversario = [];
    $year = date('Y');
    $mes = date("m");
    $dia = date("d");

    $users = User::with(['job', 'job.departamento'])
        ->whereYear('admission', '!=', $year)
        ->whereMonth('admission', $mes)
        ->where('active', 1)
        ->whereDay('admission', $dia)
        ->whereNot('email', '')
        ->get();

    if ($users->isEmpty()) {
        $this->info('sin aniversarios para el dia de hoy');
        return true;
    }
    foreach ($users as $user) {
        $usersAniversario[] = [
            'nombre' => $user->nombre(),
            'avatar' => asset("aniversario/plantilla-2/colaboradores/{$user->id}.png"),
            'email' => $user->email,
            'departamento' => $user->job->departamento->name,
            'numero' => $imagenes[$user->admission->age],
            'cantidad' => $user->admission->age,
        ];
    }


    // logger()->channel('slack')->info('Cron aniversario', [
    //     $usersAniversario
    // ]);

    foreach ($usersAniversario as $empleado) {
        try {
            $avatar = Image::make($empleado['avatar']);
            $avatar->resize(660, 660, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $numero = Image::make($empleado['numero']);
            $numero->resize(530, 530, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img  =  Image::make('aniversario/plantilla-2/template-2.png');
            $img->insert($avatar, '', 135, 304);
            $img->insert($numero, '', 1370, 370);
            $img->text($empleado['nombre'], 1030, 920, function ($font) {
                $font->file('fonts/poppins/Poppins-SemiBold.ttf');
                $font->size(38);
                $font->color('#000000');
            });
            Storage::disk('public')->put('aniversario-tmp.png', $img->encode('png'));
            header('Content-Type: image/png');
            echo $img->encode('png');
            // Mail::to($empleado['email'])
            Mail::to('ahernandezm@gptservices.com')
                ->bcc(['recursoshumanos@gptservices.com', 'ahernandezm@gptservices.com'])
                ->send(new Aniversario());
            $this->info('se envio correo de aniversario');
        } catch (\Exception $e) {
            throw $e;
            $this->error($e->getMessage());
        }
    }
});

Route::get('users-area', function () {
    $areas = Area::all();
    $areas = $areas->unique('name')->pluck('name');
    $users = User::with(['job.Departamento.area',])
        ->where('active', 1)
        ->get();

    $data = [];
    foreach ($users as $user) {
        $data[] = [
            'id' => $user->id,
            'job' => $user->job->name,
            'area' => $user->job->departamento->area->name,
        ];
    }

    // Opción 1: print_r (para depuración)
    $texto = print_r($data, true);
    file_put_contents('debug.txt', $texto);

    // Opción 2: var_export (para código PHP reutilizable)
    $codigo_php = var_export($data, true);
    file_put_contents('array.php', "<?php\n\$data = $codigo_php;");
});

Route::get('users-excel', function () {

    $listado = fastexcel()->import('listado.xlsx');
    $usersGoogle = fastexcel()->import('users_admin.xlsx');
    // dd($listado);
    $data = [];

    foreach ($listado as $user) {
        $exists = $usersGoogle->firstWhere('Usuario', $user['CORREO']);
        if (filled($exists)) {
            // $data[]=[
            //     'Número'=>$linea['Número'],
            //     'Usuario'=>$exists['USUARIO'],
            //     'Plan'=>$linea['Renta'],
            //     'GB'=>$linea['GB'],
            //     'Fecha de vencimiento'=>$linea['Fecha de Vencimiento']->format('m-d-Y'),
            // ];
            // echo "<p style='font-size: 28px;color:green;margin:0;padding:0;font-weight: bold;'>{$user['NOMBRE COMPLETO']}</p>";
            // echo "<p style='font-size: 28px;color:green;margin:0;padding:0 0 0 0;'> {$exists['Nombre']}</p>";
            // echo "<p style='font-size: 28px;color:black;margin:0;padding:0 0 0 0;'> {$user['CORREO']}</p>";
            // echo "<p style='font-size: 28px;color:black;margin:0;padding:0 0 20px 0;'> {$exists['Usuario']}</p>";
        } else {
            echo "<p style='font-size: 28px;color:red;margin:0;padding:0;font-weight: bold;'>{$user['NOMBRE COMPLETO']}</p>";
            echo "<p style='font-size: 28px;color:red;margin:0;padding:0;font-weight: bold;'>{$user['CORREO']}</p>";
            //    echo "<p style='color:red;margin:0;padding:0;font-weight: bold;'>{$user['CORREO']}</p>";
        }
    }
});

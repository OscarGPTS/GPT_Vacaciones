<?php

namespace App\Http\Controllers\Rrhh;

use Exception;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Mail\Aniversario;
use App\Models\RazonSocial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Intervention\Image\Facades\Image;
use App\Services\Rrhh\UserSaveService;
use Spatie\PdfToImage\Pdf as ImgToPDF;
use Illuminate\Support\Facades\Storage;
use App\Services\Sincronizar\UserService;
use Rap2hpoutre\FastExcel\SheetCollection;
use App\Http\Requests\Rrhh\StoreUserRequest;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = User::all();

        $activos = $empleados->where('active', 1);
        $bajas = $empleados->where('active', 0);

        return view('empleados.index')
            ->with([
                'empleados' => $empleados,
                'activos' => $activos,
                'bajas' => $bajas
            ]);
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function show($id)
    {
        $empleado = User::with(['job', 'jefe', 'razonSocial', 'personalData'])->findOrFail($id);

        return view('empleados.show')
            ->with('empleado', $empleado);
    }
    public function foto($id)
    {
        $empleado = User::with(['job', 'jefe', 'razonSocial'])->findOrFail($id);

        return view('empleados.show_foto')
            ->with('empleado', $empleado);
    }

    public function edit($user_id)
    {
        $empleado = User::with(['job', 'jefe', 'razonSocial', 'personalData'])
            ->findOrFail($user_id);

        return view('empleados.update')
            ->with('empleado', $empleado);
    }

    public function credencial($id)
    {
        $empleado = User::with(['job', 'razonSocial', 'personalData'])
            ->findOrFail($id);

        $url = "https://gptservices.com/vcard/" . $empleado->id;


        $fecha = now();
        $vigencia = now()->monthName . ' ' . $fecha->addYears(2)->format('Y');
        $pdf = PDF::loadView('empleados.credencial', compact('empleado', 'url', 'vigencia'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Credencial' . '_' . $empleado->first_name . '_' . $empleado->last_name . '.pdf');
    }
    public function aniversario($id)
    {
        $imagenes = [
            1 =>  asset('aniversario/1.png'),
            2 =>  asset('aniversario/2.png'),
            3 =>  asset('aniversario/3.png'),
            4 =>  asset('aniversario/4.png'),
            5 =>  asset('aniversario/5.png'),
            6 =>  asset('aniversario/6.png'),
            7 =>  asset('aniversario/7.png'),
            8 =>  asset('aniversario/8.png'),
            9 =>  asset('aniversario/9.png'),
            10 =>  asset('aniversario/10.png'),
            11 =>  asset('aniversario/10.png'),
            12 =>  asset('aniversario/10.png'),
            13 =>  asset('aniversario/10.png'),
            14 =>  asset('aniversario/10.png'),
            15 =>  asset('aniversario/10.png'),
        ];
        $empleado = [];
        $user = User::with(['job', 'job.departamento'])
            ->find($id);
        $empleado = [
            'nombre' => $user->nombre(),
            'email' => $user->email,
            'departamento' => $user->job->departamento->name,
            'imagen' => $imagenes[$user->admission->age],
        ];
        $pdf = PDF::loadView('empleados.aniversario_template', compact('empleado'))
            ->setPaper('a0', 'portrait');
        return $pdf->stream('aniversario');
        // return view('empleados.aniversario_template')->with('empleado', $empleado);
    }
    public function sincronizar($empleado_id)
    {
        $empleado = User::with(['job', 'jefe', 'jefe.job', 'razonSocial', 'personalData'])->findOrFail($empleado_id);

        return view('empleados.sincronizar')
            ->with('empleado', $empleado);
    }
    public function excelBajas()
    {
        $users = User::with(['job', 'job.departamento', 'job.departamento.area', 'jefe', 'razonSocial', 'personalData'])
            ->where('active', 2)
            ->get();
        $empleados  = [];
        foreach ($users as $user) {
            $empleados[] =  [
                'ID' => (isset($user->id) && !empty($user->id)) ? $user->id : 'Dato vacío',
                'NOMBRE COMPLETO' => $user->nombre(),
                'APELLIDOS' => (isset($user->last_name) && !empty($user->last_name)) ? $user->last_name : 'Dato vacío',
                'NOMBRE' => (isset($user->first_name) && !empty($user->first_name)) ? $user->first_name : 'Dato vacío',
                'NACIMIENTO' => (isset($user->personalData->birthday) && !empty($user->personalData->birthday)) ? $user->personalData->birthday->format('d-m-Y') : 'Dato vacío',
                'CURP' => (isset($user->personalData->curp) && !empty($user->personalData->curp)) ? $user->personalData->curp : 'Dato vacío',
                'RFC' => (isset($user->personalData->rfc) && !empty($user->personalData->rfc)) ? $user->personalData->rfc : 'Dato vacío',
                'NSS' => (isset($user->personalData->nss) && !empty($user->personalData->nss)) ? $user->personalData->nss : 'Dato vacío',
                'ADMISIÓN' => (isset($user->admission) && !empty($user->admission)) ? $user->admission->format('d/m/Y') : 'Dato vacío',
                'ÁREA' => (isset($user->job->departamento->area->name) && !empty($user->job->departamento->area->name)) ? $user->job->departamento->area->name : 'Dato vacío',
                'DEPARTAMENTO' => (isset($user->job->departamento->name) && !empty($user->job->departamento->name)) ? $user->job->departamento->name : 'Dato vacío',
                'PUESTO ACTUAL' => (isset($user->job->name) && !empty($user->job->name)) ? $user->job->name : 'Dato vacío',
                'RAZÓN SOCIAL' => (isset($user->razonSocial->name) && !empty($user->razonSocial->name)) ? $user->razonSocial->name : 'Dato vacío',
                'CORREO' => (isset($user->email) && !empty($user->email)) ? $user->email : 'Dato vacío',
                'TELÉFONO' => (isset($user->phone) && !empty($user->phone)) ? $user->phone : 'Dato vacío',
                'TELEFONO PERSONAL' => (isset($user->personalData->personal_phone) && !empty($user->personalData->personal_phone)) ? $user->personalData->personal_phone : 'Dato vacío',
                'CORREO PESONAL' => (isset($user->personalData->personal_mail) && !empty($user->personalData->personal_mail)) ? $user->personalData->personal_mail : 'Dato vacío',
                'JEFE INMEDIATO' => (isset($user->jefe) && !empty($user->jefe)) ? $user->jefe->nombre() : 'Dato vacío',
                'ID JEFE INMEDIATO' => (isset($user->jefe->id) && !empty($user->jefe->id)) ? $user->jefe->id : 'Dato vacío',
                'PUESTO JEFE' => (isset($user->jefe->job->name) && !empty($user->jefe->job->name)) ? $user->jefe->job->name : 'Dato vacío',
                'ESCOLARIDAD' => (isset($user->escolaridad) && !empty($user->escolaridad)) ? $user->escolaridad : 'Dato vacío',
                'ESCOLARIADAD NOMBRE' => (isset($user->escolaridad_nombre) && !empty($user->escolaridad_nombre)) ? $user->escolaridad_nombre : 'Dato vacío',
                'CEDULA' => (isset($user->cedula) && !empty($user->cedula)) ? $user->cedula : 'Dato vacío',
                'LIBRETA_MAR' => (isset($user->libreta_mar) && !empty($user->libreta_mar)) ? $user->libreta_mar : 'Dato vacío',
            ];
        }
        return $empleados;
    }
    public function excelActivos()
    {
        $users = User::with(['job', 'job.departamento', 'job.departamento.area', 'jefe', 'razonSocial', 'personalData'])
            ->where('active', 1)
            ->get();

        $empleados  = [];
        foreach ($users as $user) {
            $empleados[] =  [
                'ID' => (isset($user->id) && !empty($user->id)) ? $user->id : '  ',
                'NOMBRE COMPLETO' => $user->nombre(),
                'APELLIDOS' => (isset($user->last_name) && !empty($user->last_name)) ? $user->last_name : '  ',
                'NOMBRE' => (isset($user->first_name) && !empty($user->first_name)) ? $user->first_name : '  ',
                'NACIMIENTO' => (isset($user->personalData->birthday) && !empty($user->personalData->birthday)) ? $user->personalData->birthday->format('d-m-Y') : '  ',
                'CURP' => (isset($user->personalData->curp) && !empty($user->personalData->curp)) ? $user->personalData->curp : '  ',
                'RFC' => (isset($user->personalData->rfc) && !empty($user->personalData->rfc)) ? $user->personalData->rfc : '  ',
                'NSS' => (isset($user->personalData->nss) && !empty($user->personalData->nss)) ? $user->personalData->nss : '  ',
                'ADMISIÓN' => (isset($user->admission) && !empty($user->admission)) ? $user->admission->format('d/m/Y')  : '  ',
                'ÁREA' => (isset($user->job->departamento->area->name) && !empty($user->job->departamento->area->name)) ? $user->job->departamento->area->name : '  ',
                'DEPARTAMENTO' => (isset($user->job->departamento->name) && !empty($user->job->departamento->name)) ? $user->job->departamento->name : '  ',
                'PUESTO ACTUAL' => (isset($user->job->name) && !empty($user->job->name)) ? $user->job->name : '  ',
                'RAZÓN SOCIAL' => (isset($user->razonSocial->name) && !empty($user->razonSocial->name)) ? $user->razonSocial->name : '  ',
                'CORREO' => (isset($user->email) && !empty($user->email)) ? $user->email : '  ',
                'TELÉFONO' => (isset($user->phone) && !empty($user->phone)) ? $user->phone : '  ',
                'TELEFONO PERSONAL' => (isset($user->personalData->personal_phone) && !empty($user->personalData->personal_phone)) ? $user->personalData->personal_phone : '  ',
                'CORREO PESONAL' => (isset($user->personalData->personal_mail) && !empty($user->personalData->personal_mail)) ? $user->personalData->personal_mail : '  ',
                'JEFE INMEDIATO' => (isset($user->jefe) && !empty($user->jefe)) ? $user->jefe->nombre() : '  ',
                'ID JEFE INMEDIATO' => (isset($user->jefe->id) && !empty($user->jefe->id)) ? $user->jefe->id : '  ',
                'PUESTO JEFE' => (isset($user->jefe->job->name) && !empty($user->jefe->job->name)) ? $user->jefe->job->name : '  ',
                'ESCOLARIDAD' => (isset($user->escolaridad) && !empty($user->escolaridad)) ? $user->escolaridad : '  ',
                'ESCOLARIADAD NOMBRE' => (isset($user->escolaridad_nombre) && !empty($user->escolaridad_nombre)) ? $user->escolaridad_nombre : '  ',
                'CEDULA' => (isset($user->cedula) && !empty($user->cedula)) ? $user->cedula : '  ',
                'LIBRETA_MAR' => (isset($user->libreta_mar) && !empty($user->libreta_mar)) ? $user->libreta_mar : '  ',
                'TIPO SANGRE' => (filled($user->personalData->tipo_sangre)) ? $user->personalData->tipo_sangre : '  ',
                'ESTADO CIVIL' => (filled($user->personalData->estado_civil)) ? $user->personalData->estado_civil['tipo'] : '  ',
                'NOMBRE PAREJA' => (isset($user->personalData->estado_civil['nombre_pareja']) && !empty($user->personalData->estado_civil['nombre_pareja'])) ? $user->personalData->estado_civil['nombre_pareja'] : '  ',
                'TELEFONO PAREJA' => (isset($user->personalData->estado_civil['telefono_pareja']) && !empty($user->personalData->estado_civil['telefono_pareja'])) ? $user->personalData->estado_civil['telefono_pareja'] : '  ',
            ];
        }
        return $empleados;
    }

    public function editCv($id)
    {
        $user = User::findOrFail($id);
        return view('empleados.show_cv')
            ->with('user', $user);
    }
    public function pdfCv($id)
    {
        $user = User::with(['cvExperiencia' => fn($query) => $query->orderBy('fecha_inicio', 'desc'), 'cvHistorialServicio' => fn($query) => $query->orderBy('year', 'desc')->orderBy('created_at', 'desc'), 'cvCursoCertificacion', 'cvCursoSoldadura'])
            ->findOrFail($id);

        // return $user;
        $pdf = PDF::loadView('perfil.cv.pdf_template', compact('user'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    public function  birthdayShow(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            return redirect()->route('home');
        }
        $user = User::findOrFail($id);
        return view('empleados.birthday')
            ->with('user', $user);
    }
    public function certificadoPdf($id)
    {
        // $ids =  [22,205,212,157];

        $folio = match($id){
            '270'=> '03/3/25',
            '50'=> '04/2/25',
            '157'=> '05/1/25',
            '205'=> '06/1/25',
            '212'=> '07/1/25',
            default =>''
        };

        $folio = "GPT-CER-ST-{$folio}";

        $ids =  [22];
        $existeId =in_array($id, $ids);
        if($existeId){
            return response()->file(public_path('certificado/'.$id.'.pdf'));
        }
        $user = User::with(['job', 'job.departamento', 'CertificadoCv'])->findOrFail($id);
        // if (!$user->belongsToDepartamento()) {
        //     return redirect()->route('empleados.show', $user->id);
        // }

        // El usuario pertenece al departamento con el ID que le he pasado
        // Validar si ya existe una relacion entre el empleado y cv certificado
        if (!$user->CertificadoCv()->exists()) {
            $user->CertificadoCv()->create([
                'uuid' => Str::uuid()
            ]);
            $user->load(['CertificadoCv']);
        }
        // $qr = 'https://chart.apis.google.com/chart?cht=qr&chs=100x100&chld=L|0&chl=' . route('perfil.public.show.cv', $user->CertificadoCv->uuid, 'JDJ5JDA5JDc5eC5CckpHWFlkU2FLUjcxalVYTHU4ZDIxT3EueVhlM2VFN1Rxdy56M1pqVWYzOXhXa01x');
        $qr = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . route('perfil.public.show.cv', $user->CertificadoCv->uuid, 'JDJ5JDA5JDc5eC5CckpHWFlkU2FLUjcxalVYTHU4ZDIxT3EueVhlM2VFN1Rxdy56M1pqVWYzOXhXa01x');
        $pdf = PDF::loadView('empleados.certificado_template', compact(['user', 'qr','folio']))
            ->setPaper('A4', 'portrait');
        return $pdf->stream();
        return $user->CertificadoCv;
    }

    public function excel()
    {
        $activos = $this->excelActivos();
        $bajas = $this->excelBajas();
        $dataPersonal =  $this->dataPersonal();
        try {
            $time = now()->format('Y-m-d h:i');
            $archivoNombre = 'personal-' . $time . '.xlsx';
            $sheets = new SheetCollection([
                'Activos' => $activos,
                'Estudios' => $dataPersonal['estudios'],
                'Hijos' => $dataPersonal['hijos'],
                'Contactos' => $dataPersonal['contactos'],
                'Alergias' => $dataPersonal['alergias'],
                'Enfermedades' => $dataPersonal['enfermedades'],
                'Bajas' => $bajas
            ]);
            return (new FastExcel($sheets))->download($archivoNombre);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function dataPersonal()
    {
        $estudios = [];
        $hijos = [];
        $contactos = [];
        $alergias = [];
        $enfermedades = [];
        $check = [];
        $users = User::with(['personalData', 'checkDocumento'])->get();
        foreach ($users as $user) {
            if (filled($user->personalData->estudios)) {
                foreach ($user->personalData->estudios as $estudio) {
                    $estudios[] = [
                        'COLABORADOR' => $user->id,
                        'COLABORADOR NOMBRE' => $user->nombre(),
                        'NIVEL EDUCATIVO' => $estudio['nivel'],
                        'CARRERA' => $estudio['carrera'],
                        'TIPO CARRERA' => $estudio['tipo_carrera'],
                        'TITULO' => $estudio['titulo'],
                        'CEDULA' => $estudio['cedula'],
                    ];
                }
            }
            if (filled($user->personalData->hijo)) {
                foreach ($user->personalData->hijo as $hijo) {
                    $hijos[] = [
                        'COLABORADOR' => $user->id,
                        'COLABORADOR NOMBRE' => $user->nombre(),
                        'NOMBRE' => $hijo['nombre'],
                        'FECHA NACIMIENTO' => $hijo['fecha_nacimiento'],
                    ];
                }
            }
            if (filled($user->personalData->contacto_emergencia)) {
                foreach ($user->personalData->contacto_emergencia as $contacto) {
                    $contactos[] = [
                        'COLABORADOR' => $user->id,
                        'COLABORADOR NOMBRE' => $user->nombre(),
                        'NOMBRE DEL CONTACTO' => $contacto['nombre'],
                        'TELEFONO' => $contacto['tel'],
                        'PARENTESCO' => $contacto['parentesco'],
                    ];
                }
            }
            if (filled($user->personalData->alergias)) {
                foreach ($user->personalData->alergias as $alergia) {
                    $alergias[] = [
                        'COLABORADOR' => $user->id,
                        'COLABORADOR NOMBRE' => $user->nombre(),
                        'TIPO' => $alergia,
                    ];
                }
            }
            if (filled($user->personalData->enfermedad)) {
                foreach ($user->personalData->enfermedad as $enfermedad) {
                    $enfermedades[] = [
                        'COLABORADOR' => $user->id,
                        'COLABORADOR NOMBRE' => $user->nombre(),
                        'TIPO' => $enfermedad['tipo'],
                        'TRATAMIENTO' => $enfermedad['tratamiento'],
                    ];
                }
            }
            if (filled($user->checkDocumento)) {
                if (auth()->user()->hasRole('super-admin')) {
                    $check[] = [
                        'Colaborador' => $user->id,
                        'Colaborador nombre' => $user->nombre(),
                        'Estatus' => $this->avance($user->checkDocumento),
                        'Acta De Nacimiento' => $user->checkDocumento->acta_nacimiento ? 'SI' : 'N0',
                        'Antecedentes Clínicos' => $user->checkDocumento->antecedentes_clinicos ? 'SI' : 'NO',
                        'Carta Compromiso Código De Ética' => $user->checkDocumento->carta_compromiso_codigo_etica ? 'SI' : 'NO',
                        'Carta Oferta' => $user->checkDocumento->carta_oferta ? 'SI' : 'NO',
                        'Cartas De Recomendación' => $user->checkDocumento->cartas_recomendacion ? 'SI' : 'NO',
                        'Certificado Medico' => $user->checkDocumento->certificado_medico ? 'SI' : 'NO',
                        'Código De Ética Y Conducta' => $user->checkDocumento->codigo_etica_conducta ? 'SI' : 'NO',
                        'Comprobante De Banco' => $user->checkDocumento->comprobante_banco ? 'SI' : 'NO',
                        'Comprobante De Domicilio (No Mayor A Tres Meses)' => $user->checkDocumento->comprobante_domicilio ? 'SI' : 'NO',
                        'Comprobante De Estudios (Ultimo)' => $user->checkDocumento->comprobante_estudios ? 'SI' : 'NO',
                        'Constancia De Situacion Fiscal' => $user->checkDocumento->constancia_situacion_fiscal ? 'SI' : 'NO',
                        'Cuestionario Anticorrupción' => $user->checkDocumento->cuestionario_anticorrupcion ? 'SI' : 'NO',
                        'Curp' => $user->checkDocumento->curp ? 'SI' : 'NO',
                        'Cv / Solicitud De Empleo' => $user->checkDocumento->cv_solicitud_empleo ? 'SI' : 'NO',
                        'Evalución De Entrevista' => $user->checkDocumento->evalucion_entrevista ? 'SI' : 'NO',
                        'Formato De Aptitud' => $user->checkDocumento->formato_aptitud ? 'SI' : 'NO',
                        'Identificacion Oficial' => $user->checkDocumento->identificacion_oficial ? 'SI' : 'NO',
                        'Kit Contratación' => $user->checkDocumento->kit_contratacion ? 'SI' : 'NO',
                        'Numero De Seguro Social' => $user->checkDocumento->numero_seguro_social ? 'SI' : 'NO',
                        'Reglamento Interno De Trabajo Firmado' => $user->checkDocumento->reglamento_interno_trabajo_firmado ? 'SI' : 'NO',
                        'Evaluacion De Desempeño' => (isset($user->checkDocumento->opcionales['evaluacion_desempeno']) ?  $user->checkDocumento->opcionales['evaluacion_desempeno'] : ''),
                        'Evalución Periodo De Prueba (90 Días)' => (isset($user->checkDocumento->opcionales['evalucion_periodo_prueba_90_dias']) ?  $user->checkDocumento->opcionales['evalucion_periodo_prueba_90_dias'] : ''),
                        'Convenios Especiales o Promociones' => (isset($user->checkDocumento->opcionales['convenios_especiales_promociones']) ?  $user->checkDocumento->opcionales['convenios_especiales_promociones'] : ''),
                        'Solicitud De Vacaciones' => (isset($user->checkDocumento->opcionales['solicitud_vacaciones']) ?  $user->checkDocumento->opcionales['solicitud_vacaciones'] : ''),
                        'Permisos (Pago Tiempo Por Tiempo)' => (isset($user->checkDocumento->opcionales['permisos_pago_tiempo_por_tiempo']) ?  $user->checkDocumento->opcionales['permisos_pago_tiempo_por_tiempo'] : ''),
                        'Incapacidades' => (isset($user->checkDocumento->opcionales['incapacidades']) ?  $user->checkDocumento->opcionales['incapacidades'] : ''),
                        'Capacitación' => (isset($user->checkDocumento->opcionales['capacitacion']) ?  $user->checkDocumento->opcionales['capacitacion'] : ''),
                        'Otros Documentos (Bonos, Finiquitos, Etc…)' => (isset($user->checkDocumento->opcionales['otros_documentos']) ?  $user->checkDocumento->opcionales['otros_documentos'] : ''),
                        'Acta De Matrimonio' => (isset($user->checkDocumento->opcionales['acta_matrimonio']) ?  $user->checkDocumento->opcionales['acta_matrimonio'] : ''),
                        'Acta De Nacimiento De Esposa E Hijos' => (isset($user->checkDocumento->opcionales['acta_nacimiento_esposa_hijos']) ?  $user->checkDocumento->opcionales['acta_nacimiento_esposa_hijos'] : ''),
                        'Aviso De Retención De Infonavit' => (isset($user->checkDocumento->opcionales['aviso_retencion_infonavit']) ?  $user->checkDocumento->opcionales['aviso_retencion_infonavit'] : ''),
                        'Aviso De Retención Fonacot' => (isset($user->checkDocumento->opcionales['aviso_retencion_fonacot']) ?  $user->checkDocumento->opcionales['aviso_retencion_fonacot'] : ''),
                        'Actualizacion De Datos (Último)' => (isset($user->checkDocumento->opcionales['actualizacion_datos_último']) ?  $user->checkDocumento->opcionales['actualizacion_datos_último'] : ''),
                    ];
                } else {
                    $check[] = [
                        'Colaborador' => $user->id,
                        'Colaborador nombre' => $user->nombre(),
                        'Estatus' => $this->avance($user->checkDocumento),
                    ];
                }
            }
        }
        return [
            'estudios' => $estudios,
            'hijos' => $hijos,
            'contactos' => $contactos,
            'alergias' => $alergias,
            'enfermedades' => $enfermedades,
            'check' => $check
        ];
    }
    public function dataUser($id)
    {
        $estudios = [];
        $hijos = [];
        $contactos = [];
        $alergias = [];
        $enfermedades = [];
        $check = [];
        $user = User::with(['personalData', 'checkDocumento'])->findOrFail($id);
        if (filled($user->checkDocumento)) {
            $check = [
                'Colaborador' => $user->id,
                'Colaborador nombre' => $user->nombre(),
                'Fecha ingreso' => $user->admission->format('Y-m-d'),
                'Estatus' => $this->avance($user->checkDocumento),
                'Acta de nacimiento' => $user->checkDocumento->acta_nacimiento ? 'SI' : 'N0',
                'Antecedentes clínicos' => $user->checkDocumento->antecedentes_clinicos ? 'SI' : 'NO',
                'Carta compromiso código de ética' => $user->checkDocumento->carta_compromiso_codigo_etica ? 'SI' : 'NO',
                'Carta oferta' => $user->checkDocumento->carta_oferta ? 'SI' : 'NO',
                'Cartas de recomendación' => $user->checkDocumento->cartas_recomendacion ? 'SI' : 'NO',
                'Certificado médico' => $user->checkDocumento->certificado_medico ? 'SI' : 'NO',
                'Código de ética y conducta' => $user->checkDocumento->codigo_etica_conducta ? 'SI' : 'NO',
                'Comprobante de banco' => $user->checkDocumento->comprobante_banco ? 'SI' : 'NO',
                'Comprobante de domicilio (no mayor a tres meses)' => $user->checkDocumento->comprobante_domicilio ? 'SI' : 'NO',
                'Comprobante de estudios (último)' => $user->checkDocumento->comprobante_estudios ? 'SI' : 'NO',
                'Constancia de situación fiscal' => $user->checkDocumento->constancia_situacion_fiscal ? 'SI' : 'NO',
                'Cuestionario anticorrupción' => $user->checkDocumento->cuestionario_anticorrupcion ? 'SI' : 'NO',
                'CURP' => $user->checkDocumento->curp ? 'SI' : 'NO',
                'CV / solicitud de empleo' => $user->checkDocumento->cv_solicitud_empleo ? 'SI' : 'NO',
                'Evaluación de entrevista' => $user->checkDocumento->evalucion_entrevista ? 'SI' : 'NO',
                'Formato de aptitud' => $user->checkDocumento->formato_aptitud ? 'SI' : 'NO',
                'Identificación oficial' => $user->checkDocumento->identificacion_oficial ? 'SI' : 'NO',
                'Kit contratación' => $user->checkDocumento->kit_contratacion ? 'SI' : 'NO',
                'Número de seguro social' => $user->checkDocumento->numero_seguro_social ? 'SI' : 'NO',
                'Reglamento interno de trabajo firmado' => $user->checkDocumento->reglamento_interno_trabajo_firmado ? 'SI' : 'NO',
                'Evaluación de desempeño' => (isset($user->checkDocumento->opcionales['evaluacion_desempeno']) ?  $user->checkDocumento->opcionales['evaluacion_desempeno'] : ''),
                'Evaluación del período de prueba (90 días)' => (isset($user->checkDocumento->opcionales['evalucion_periodo_prueba_90_dias']) ?  $user->checkDocumento->opcionales['evalucion_periodo_prueba_90_dias'] : ''),
                'Convenios especiales o promociones' => (isset($user->checkDocumento->opcionales['convenios_especiales_promociones']) ?  $user->checkDocumento->opcionales['convenios_especiales_promociones'] : ''),
                'Solicitud de vacaciones' => (isset($user->checkDocumento->opcionales['solicitud_vacaciones']) ?  $user->checkDocumento->opcionales['solicitud_vacaciones'] : ''),
                'Permisos (pago tiempo por tiempo)' => (isset($user->checkDocumento->opcionales['permisos_pago_tiempo_por_tiempo']) ?  $user->checkDocumento->opcionales['permisos_pago_tiempo_por_tiempo'] : ''),
                'Incapacidades' => (isset($user->checkDocumento->opcionales['incapacidades']) ?  $user->checkDocumento->opcionales['incapacidades'] : ''),
                'Capacitación' => (isset($user->checkDocumento->opcionales['capacitacion']) ?  $user->checkDocumento->opcionales['capacitacion'] : ''),
                'Otros documentos (bonos, finiquitos, etc.)' => (isset($user->checkDocumento->opcionales['otros_documentos']) ?  $user->checkDocumento->opcionales['otros_documentos'] : ''),
                'Acta de matrimonio' => (isset($user->checkDocumento->opcionales['acta_matrimonio']) ?  $user->checkDocumento->opcionales['acta_matrimonio'] : ''),
                'Acta de nacimiento de esposa e hijos' => (isset($user->checkDocumento->opcionales['acta_nacimiento_esposa_hijos']) ?  $user->checkDocumento->opcionales['acta_nacimiento_esposa_hijos'] : ''),
                'Aviso de retención de Infonavit' => (isset($user->checkDocumento->opcionales['aviso_retencion_infonavit']) ?  $user->checkDocumento->opcionales['aviso_retencion_infonavit'] : ''),
                'Aviso de retención FONACOT' => (isset($user->checkDocumento->opcionales['aviso_retencion_fonacot']) ?  $user->checkDocumento->opcionales['aviso_retencion_fonacot'] : ''),
                'Actualización de datos (último)' => (isset($user->checkDocumento->opcionales['actualizacion_datos_último']) ?  $user->checkDocumento->opcionales['actualizacion_datos_último'] : ''),
            ];
        }
        return $check;
    }
    public function DocumentosdCheckExcel()
    {
        try {
            $time = now()->format('Y-m-d h:i');
            $archivoNombre = 'documentos-check-' . $time . '.xlsx';
            $dataPersonal =  $this->dataPersonal();
            return (new FastExcel($dataPersonal['check']))->download($archivoNombre);
        } catch (\Exception $e) {
            throw $e;
            logger()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function avance($documento)
    {
        $admisionVieja = '';
        $fechaAComparar = Carbon::parse('2020-1-01'); //las personas que hayan ingresado antes de enero 2020
        $fechaAComparar2 = Carbon::parse('2022-1-01'); //las personas que hayan ingresado antes de enero 2022
        $user = User::with(['job', 'checkDocumento'])->findOrFail($documento['user_id']);
        $admision = $user->admission;


        if ($admision->lt($fechaAComparar)) {
            $admisionVieja = 'antes de enero 2020';
        }

        if ($admision->lt($fechaAComparar2) && $admision->isAfter($fechaAComparar)) {
            $admisionVieja = 'antes de enero 2022';
        }
        $data = [
            'acta_nacimiento' => $documento['acta_nacimiento'],
            'antecedentes_clinicos' => $admisionVieja == 'antes de enero 2020' ? false : $documento['antecedentes_clinicos'],
            'carta_compromiso_codigo_etica' => $documento['carta_compromiso_codigo_etica'],
            'carta_oferta' => $admisionVieja == 'antes de enero 2020' ? false : $documento['carta_oferta'],
            'cartas_recomendacion' => $admisionVieja == 'antes de enero 2020' ? false : $documento['cartas_recomendacion'],
            'certificado_medico' => $documento['certificado_medico'],
            'codigo_etica_conducta' => $documento['codigo_etica_conducta'],
            'comprobante_banco' => $documento['comprobante_banco'],
            'comprobante_domicilio' => $documento['comprobante_domicilio'],
            'comprobante_estudios' => $documento['comprobante_estudios'],
            'constancia_situacion_fiscal' => $documento['constancia_situacion_fiscal'],
            'cuestionario_anticorrupcion' => $documento['cuestionario_anticorrupcion'],
            'curp' => $documento['curp'],
            'cv_solicitud_empleo' => $documento['cv_solicitud_empleo'],
            'evalucion_entrevista' => $admisionVieja == 'antes de enero 2020' || $admisionVieja == 'antes de enero 2022' ? false : $documento['evalucion_entrevista'],
            'formato_aptitud' => $admisionVieja == 'antes de enero 2020' ? false : $documento['formato_aptitud'],
            'identificacion_oficial' => $documento['identificacion_oficial'],
            'kit_contratacion' => $documento['kit_contratacion'],
            'numero_seguro_social' => $documento['numero_seguro_social'],
            'reglamento_interno_trabajo_firmado' => $documento['reglamento_interno_trabajo_firmado'],
        ];
        $contadorTrue = 0;
        foreach ($data as $key => $value) {
            if ($value == 1) {
                $contadorTrue++;
            }
        }

        if ($admisionVieja == 'antes de enero 2020') {
            return (string)$contadorTrue == 0 ? 0 : number_format(($contadorTrue / 15) * 100, 2, '.', '') . '%';
        } elseif ($admisionVieja == 'antes de enero 2022') {
            return (string) $contadorTrue == 0 ? 0 :  number_format(($contadorTrue / 19) * 100, 2, '.', '') . '%';
        } else {
            return (string) $contadorTrue == 0 ? 0 :  number_format(($contadorTrue / 20) * 100, 2, '.', '') . '%';
        }
        // return (string)($contadorTrue == 0 ? 0 : ($contadorTrue / 20) * 100) . '%';
    }

    public function DocumentosdCheckPDF($id)
    {
        $user = User::with(['personalData', 'checkDocumento'])
            ->findOrFail($id);
        $check = $this->dataUser($id);
        if (filled($check)) {
            $pdf = PDF::loadView('empleados.check_documento_pdf', compact('user', 'check'))
                ->setPaper('A4', 'portrait');
            return $pdf->stream();
        } else {
            flash()->addWarning('No se encontraron datos para el usuario', 'Check Documentos');
            return redirect()->route('empleados.documentos', $id);
        }
    }
}

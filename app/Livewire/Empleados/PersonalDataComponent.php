<?php

namespace App\Livewire\Empleados;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use App\Models\PersonalData;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\Support\MediaStream;
use App\Mail\Notificacion\CambiosPersonalData;

class PersonalDataComponent extends Component
{
    use WithFileUploads;
    use Actions;

    public $opciones = [];
    public $user, $personalData;
    public $opcion = 1;
    public $comprobanteDomicilio, $comprobanteDomicilioCollect;
    public $estadoCivil = ['tipo' => '', 'nombre_pareja' => '', 'telefono_pareja' => ''];
    public $hijos, $hijoModal, $hijo = ['nombre' => '', 'fecha_nacimiento' => ''];
    public $contactos = [], $contacto = ['nombre' => '', 'tel' => '', 'parentesco' => ''], $contactoModal;
    public $constanciaFiscalCollect, $constanciaFiscal;
    public $cursosCollect, $cursoPDF, $cursoNombre;
    public $estudiosDB, $comprobanteEstudiosCollect, $comprobanteEstudio, $nivelEducativo, $nombreCarrera, $tipoCarrera, $titulo, $cedula, $cedulaPDF, $cedulaCollect;
    public $alergiaCollect, $alergiaModal, $tipoAlergia;
    public $tipoSangre;
    public $enfermedadCollect, $enfermedadModal, $enfermedad = ['tipo' => '', 'tratamiento' => ''];
    public $identificacionOficial, $fechaVigencia, $identificacionOficialCollect;
    public $curp, $curpCollect;
    public $pasaporte, $pasaporteCollect;
    public $visa, $visaCollect;


    protected $messages = [
        'comprobanteDomicilio.required' => 'El PDF es requerido',
        'comprobanteDomicilio.mimes' => 'El archivo debe ser PDF',
        'comprobanteDomicilio.max' => 'El archivo debe ser menor a 1MB',
        'estadoCivil.tipo.required' => 'El tipo de estado civil es requerido',
        'estadoCivil.nombre_pareja.required_if' => 'El nombre de la pareja es requerido',
        'estadoCivil.telefono_pareja.required_if' => 'El telefono de la pareja es requerido',

        'hijo.nombre.required' => 'El nombre del hijo es requerido',
        'hijo.fecha_nacimiento.required' => 'La fecha de nacimiento del hijo es requerida',

        'constanciaFiscal.required' => 'El PDF es requerido',
        'constanciaFiscal.mimes' => 'El archivo debe ser PDF',
        'constanciaFiscal.max' => 'El archivo debe ser menor a 1MB',

        'cursoPDF.required' => 'El PDF es requerido',
        'cursoPDF.mimes' => 'El archivo debe ser PDF',
        'cursoPDF.max' => 'El archivo debe ser menor a 1MB',
        'cursoNombre.required' => 'El nombre del curso es requerido',

        'comprobanteEstudio.required' => 'El PDF es requerido',
        'comprobanteEstudio.mimes' => 'El archivo debe ser PDF',
        'comprobanteEstudio.max' => 'El archivo debe ser menor a 1MB',
        'nivelEducativo.required' => 'El nivel educativo es requerido',
        'nombreCarrera.required_if' => 'El nombre de la carrera es requerido',
        'titulo.required_if' => 'El titulo es requerido',
        'cedula.required_if' => 'La cedula es requerida',
        'cedulaPDF.required_if' => 'El PDF es requerido',

        'tipoAlergia.required' => 'El tipo de alergia es requerido',

        'tipoSangre.required' => 'El tipo de sangre es requerido',

        'enfermedad.tipo.required' => 'El tipo de enfermedad es requerido',
        'enfermedad.tratamiento.required' => 'El tratamiento de la enfermedad es requerido',

        'identificacionOficial.required' => 'El PDF es requerido',
        'identificacionOficial.mimes' => 'El archivo debe ser PDF',
        'identificacionOficial.max' => 'El archivo debe ser menor a 1MB',
        'fechaVigencia.required' => 'La vigencia es requerida',

        'curp.required' => 'El PDF es requerido',
        'curp.mimes' => 'El archivo debe ser PDF',
        'curp.max' => 'El archivo debe ser menor a 1MB',
        'pasaporte.required' => 'El PDF es requerido',
        'pasaporte.mimes' => 'El archivo debe ser PDF',
        'pasaporte.max' => 'El archivo debe ser menor a 1MB',
        'visa.required' => 'El PDF es requerido',
        'visa.mimes' => 'El archivo debe ser PDF',
        'visa.max' => 'El archivo debe ser menor a 1MB',
    ];
    public function mount($id = null)
    {
        if (filled($id)) {
            $this->personalData = PersonalData::where('user_id', $id)->first();
        } else {
            $this->personalData = PersonalData::where('user_id', auth()->user()->id)->first();
        }

        $this->estudiosDB = $this->personalData->estudios;
        if (filled($this->personalData->estado_civil)) {
            $this->estadoCivil = $this->personalData->estado_civil;
        }
        if (filled($this->personalData->estado_civil)) {
            $this->estadoCivil = $this->personalData->estado_civil;
        }
        if (filled($this->personalData->hijo)) {
            $this->hijos = $this->personalData->hijo;
        }
        if (filled($this->personalData->contacto_emergencia)) {
            $this->contactos = $this->personalData->contacto_emergencia;
        }
        $this->comprobanteDomicilioCollect = $this->personalData->getMedia('comprobante_domicilio');
        if (filled($this->comprobanteDomicilioCollect)) {
            $this->comprobanteDomicilioCollect = $this->comprobanteDomicilioCollect->sortByDesc('created_at')->values()->all();
        }

        $this->constanciaFiscalCollect = $this->personalData->getMedia('constancia_fiscal');
        if (filled($this->constanciaFiscalCollect)) {
            $this->constanciaFiscalCollect = $this->constanciaFiscalCollect->sortByDesc('created_at')->values()->all();
        }
        $this->cursosCollect = $this->personalData->getMedia('cursos_externos');
        if (filled($this->cursosCollect)) {
            $this->cursosCollect = $this->cursosCollect->sortByDesc('created_at')->values()->all();
        }
        $this->comprobanteEstudiosCollect = $this->personalData->getMedia('comprobante_estudios');
        if (filled($this->comprobanteEstudiosCollect)) {
            $this->comprobanteEstudiosCollect = $this->comprobanteEstudiosCollect->sortByDesc('created_at')->values()->all();
        }
        $this->cedulaCollect = $this->personalData->getMedia('cedula');
        if (filled($this->cedulaCollect)) {
            $this->cedulaCollect = $this->cedulaCollect->sortByDesc('created_at')->values()->all();
        }
        if (filled($this->personalData->alergias)) {
            $this->alergiaCollect = $this->personalData->alergias;
        }
        if (filled($this->personalData->enfermedad)) {
            $this->enfermedadCollect = $this->personalData->enfermedad;
        }
        $this->identificacionOficialCollect = $this->personalData->getMedia('identificacion_oficial');
        if (filled($this->identificacionOficialCollect)) {
            $this->identificacionOficialCollect = $this->identificacionOficialCollect->sortByDesc('created_at')->values()->all();
        }
        $this->curpCollect = $this->personalData->getMedia('curp');
        if (filled($this->curpCollect)) {
            $this->curpCollect = $this->curpCollect->sortByDesc('created_at')->values()->all();
        }
        $this->pasaporteCollect = $this->personalData->getMedia('pasaporte');
        if (filled($this->pasaporteCollect)) {
            $this->pasaporteCollect = $this->pasaporteCollect->sortByDesc('created_at')->values()->all();
        }
        $this->visaCollect = $this->personalData->getMedia('visa');
        if (filled($this->visaCollect)) {
            $this->visaCollect = $this->visaCollect->sortByDesc('created_at')->values()->all();
        }

        $this->opciones = [
            ['name' => 'Estado civil', 'id' => 1],
            ['name' => 'Hijos', 'id' => 2],
            ['name' => 'Comprobante de domicilio', 'id' => 3],
            ['name' => 'Contacto de emergencia', 'id' => 4],
            ['name' => 'Constancia situación fiscal', 'id' => 5],
            ['name' => 'Cursos externos', 'id' => 6],
            ['name' => 'Comprobante de estudios', 'id' => 7],
            ['name' => 'Alergias', 'id' => 8],
            ['name' => 'Tipo de sangre', 'id' => 9],
            ['name' => 'Enfermedades', 'id' => 10],
            ['name' => 'Identificación oficial', 'id' => 11],
            ['name' => 'CURP', 'id' => 12],
            ['name' => 'Pasaporte', 'id' => 13],
            ['name' => 'Visa', 'id' => 14],
        ];
    }
    public function render()
    {
        return view('livewire.empleados.personal-data-component');
    }

    public function guardarComprobanteDomicilio()
    {
        $this->validate([
            'comprobanteDomicilio' => 'required|max:550'
        ]);
        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->comprobanteDomicilio->getRealPath())
                ->usingFileName('Comprobante de domicilio_' . Str::random(10) . '.pdf')
                ->usingName('Comprobante de domicilio_' . Str::random(10))
                ->toMediaCollection('comprobante_domicilio');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Comprobante de domicilio guardado',
                    $description = 'Se ha guardado el comprobante de domicilio con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Comprobante de domicilio',
                $description = 'Ha ocurrido un error al guardar el comprobante de domicilio'
            );
            throw ($e);
        }
    }

    public function guardarEstadoCivil()
    {
        $this->validate([
            'estadoCivil.tipo' => 'required',
            'estadoCivil.nombre_pareja' => 'required_if:estadoCivil.tipo,Casado,Unión libre|max:200',
            'estadoCivil.telefono_pareja' => 'required_if:estadoCivil.tipo,Casado,Unión libre|max:30',
        ]);
        if ($this->estadoCivil['tipo'] == 'Soltero') {
            $this->estadoCivil['nombre_pareja'] = '';
            $this->estadoCivil['telefono_pareja'] = '';
        }
        try {
            DB::beginTransaction();
            $this->personalData->estado_civil = $this->estadoCivil;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Estado civil guardado',
                    $description = 'Se ha guardado el estado civil con éxito.'
                );
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Comprobante de domicilio',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
    public function guardarHijo()
    {
        $this->validate([
            'hijo.nombre' => 'required',
            'hijo.fecha_nacimiento' => 'required',
        ]);
        $this->hijos[] = $this->hijo;
        try {
            DB::beginTransaction();
            $this->personalData->hijo = $this->hijos;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->hijoModal = false;
                $this->hijo = ['nombre' => '', 'fecha_nacimiento' => ''];
                $this->notification()->success(
                    $title = 'Hijo guardado',
                    $description = 'Se ha guardado el hijo con éxito.'
                );
                $this->mount($this->personalData->user_id);
                $this->dispatch('update-hijos');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Hijo',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
    public function guardarContacto()
    {
        $this->validate([
            'contacto.nombre' => 'required',
            'contacto.tel' => 'required',
            'contacto.parentesco' => 'required',
        ]);
        $this->contactos[] = $this->contacto;
        try {
            DB::beginTransaction();
            $this->personalData->contacto_emergencia = $this->contactos;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->contactoModal = false;
                $this->contacto = ['nombre' => '', 'tel' => '', 'parentesco' => ''];
                $this->notification()->success(
                    $title = 'Contacto guardado',
                    $description = 'Se ha guardado el contacto con éxito.'
                );
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Contactos',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }


    public function guardarConstanciaFiscal()
    {

        $this->validate([
            'constanciaFiscal' => 'required|mimes:pdf|max:550'
        ]);
        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->constanciaFiscal->getRealPath())
                ->usingFileName('Constancia de situacion fiscal_' . Str::random(10) . '.pdf')
                ->usingName('Constancia de situacion fiscal_' . Str::random(10))
                ->toMediaCollection('constancia_fiscal');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Constancia de situacion fiscal',
                    $description = 'Se ha guardado la constanciacon éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('constanciaFiscal');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Constancia de situacion fiscal',
                $description = 'Ha ocurrido un error al guardar el archivo'
            );
            throw ($e);
        }
    }
    public function guardarCurso()
    {
        $this->validate([
            'cursoPDF' => 'required|mimes:pdf|max:550',
            'cursoNombre' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->cursoPDF->getRealPath())
                ->usingFileName($this->cursoNombre . '_' . Str::random(10) . '.pdf')
                ->usingName($this->cursoNombre)
                ->toMediaCollection('cursos_externos');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Cursos externos',
                    $description = 'Se ha guardado el PDF de cursos externos con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('cursoPDF', 'cursoNombre');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Cursos externos',
                $description = 'Ha ocurrido un error al guardar el archivo'
            );
            throw ($e);
        }
    }
    public function guardarComprobanteEstudio()
    {
        $this->validate([
            'comprobanteEstudio' => 'required|mimes:pdf|max:550',
            'nivelEducativo' => 'required',
            'nombreCarrera' => 'required_if:nivelEducativo,Superior,Maestria',
            'tipoCarrera' => 'required_if:nivelEducativo,Superior',
            'titulo' => 'required_if:nivelEducativo,Superior,Maestria',
            'cedula' => 'required_if:nivelEducativo,Superior,Maestria',
            'cedulaPDF' => 'required_if:cedula,Si',
        ]);

        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->comprobanteEstudio->getRealPath())
                ->usingFileName($this->nivelEducativo . '_' . Str::random(10) . '.pdf')
                ->usingName($this->nivelEducativo . '_' . Str::random(10))
                ->toMediaCollection('comprobante_estudios');

            $addEstudios = [];
            if ($this->nivelEducativo == 'Superior' || $this->nivelEducativo == 'Maestria') {
                $addEstudios = [
                    'id' => Str::random(8),
                    'nivel' => $this->nivelEducativo,
                    'tipo_carrera' => ($this->nivelEducativo == 'Superior') ? $this->tipoCarrera : '',
                    'carrera' => $this->nombreCarrera,
                    'titulo' => $this->titulo,
                    'cedula' => $this->cedula
                ];
                $estudiosCollect = $this->personalData->estudios;
                $estudiosCollect[] = $addEstudios;
                $this->personalData->estudios = $estudiosCollect;
                $this->personalData->save();
            }
            DB::afterCommit(function () use ($addEstudios) {
                if ($this->cedula == 'Si') {
                    $this->personalData
                        ->addMedia($this->cedulaPDF->getRealPath())
                        ->withCustomProperties(['id' => $addEstudios['id']])
                        ->usingFileName('cedula_' . Str::random(10) . '.pdf')
                        ->usingName('cedula_' . Str::random(10))
                        ->toMediaCollection('cedula');

                    $this->dispatch('resetFilePond');
                }
                $this->notification()->success(
                    $title = 'Comprobantes de estudios',
                    $description = 'Se ha guardado el PDF del comprobante de estudios con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('comprobanteEstudio', 'nivelEducativo', 'tipoCarrera', 'nombreCarrera', 'titulo', 'cedula', 'cedulaPDF');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Comprobantes de estudios',
                $description = 'Ha ocurrido un error al guardar el archivo'
            );
            throw ($e);
        }
    }
    public function guardarAlergia()
    {
        $this->validate([
            'tipoAlergia' => 'required',
        ]);
        $this->alergiaCollect[] = $this->tipoAlergia;
        try {
            DB::beginTransaction();
            $this->personalData->alergias = $this->alergiaCollect;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->alergiaModal = false;
                $this->reset('tipoAlergia');
                $this->notification()->success(
                    $title = 'Alergia guardada',
                    $description = 'Se ha guardado la alergia con éxito.'
                );
                $this->mount($this->personalData->user_id);
                // $this->dispatch('update-alergias');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Alergias',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }

    public function guardarTipoSangre()
    {
        $this->validate([
            'tipoSangre' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $this->personalData->tipo_sangre = $this->tipoSangre;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->reset('tipoSangre');
                $this->notification()->success(
                    $title = 'Tipo de sangre guardada',
                    $description = 'Se ha guardado el tipo de sangre con éxito.'
                );
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Tipo de sangre',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }

    public function guardarEnfermedad()
    {
        $this->validate([
            'enfermedad.tipo' => 'required',
            'enfermedad.tratamiento' => 'required',
        ]);
        $this->enfermedadCollect[] = $this->enfermedad;
        try {
            DB::beginTransaction();
            $this->personalData->enfermedad = $this->enfermedadCollect;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->enfermedadModal = false;
                $this->enfermedad = ['tipo' => '', 'tratamiento' => ''];
                $this->notification()->success(
                    $title = 'Enfermedades',
                    $description = 'Se ha guardado la enfermedad con éxito.'
                );
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Enfermedades',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
    public function guardarIdentificacionOficial()
    {
        $this->validate([
            'identificacionOficial' => 'required|mimes:pdf|max:550',
            'fechaVigencia' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->identificacionOficial->getRealPath())
                ->usingFileName('Identificacion oficial_' . Str::random(10) . '.pdf')
                ->usingName('Identificacion oficial_' . Str::random(10) . '.pdf')
                ->withCustomProperties(['fecha_vigencia' => $this->fechaVigencia])
                ->toMediaCollection('identificacion_oficial');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Identificación oficial',
                    $description = 'Se ha guardado el PDF de la identificacion oficial con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('fechaVigencia');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Identificación oficial',
                $description = 'Ha ocurrido un error al guardar el archivo'
            );
            throw ($e);
        }
    }
    public function downloadFiles()
    {
        $downloads = $this->personalData->getMedia('*');
        return MediaStream::create("documentos_{$this->personalData->user_id}.zip")->addMedia($downloads);
    }

    public function notificacion($cambios)
    {
        $data = [
            'collaborador' => $this->personalData->user->nombre(),
            'cambios' => $cambios,
            'url' => route('empleados.informacion_personal', $this->personalData->user_id)
        ];
        return Mail::send(new CambiosPersonalData($data));
    }
    public function guardarCurp()
    {
        $this->validate([
            'curp' => 'required|mimes:pdf|max:550'
        ]);
        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->curp->getRealPath())
                ->usingFileName('CURP_' . Str::random(10) . '.pdf')
                ->usingName('CURP_' . Str::random(10))
                ->toMediaCollection('curp');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'CURP guardado',
                    $description = 'Se ha guardado el CURP con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('curp');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'CURP',
                $description = 'Ha ocurrido un error al guardar el CURP'
            );
            throw ($e);
        }
    }
    public function guardarPasaporte()
    {
        $this->validate([
            'pasaporte' => 'required|mimes:pdf|max:550'
        ]);
        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->pasaporte->getRealPath())
                ->usingFileName('pasaporte_' . Str::random(10) . '.pdf')
                ->usingName('pasaporte_' . Str::random(10))
                ->toMediaCollection('pasaporte');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Pasaporte guardado',
                    $description = 'Se ha guardado el pasaporte con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('pasaporte');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'CURP',
                $description = 'Ha ocurrido un error al guardar el CURP'
            );
            throw ($e);
        }
    }
    public function guardarVisa()
    {
        $this->validate([
            'visa' => 'required|mimes:pdf|max:550'
        ]);
        try {
            DB::beginTransaction();
            $this->personalData
                ->addMedia($this->visa->getRealPath())
                ->usingFileName('visa_' . Str::random(10) . '.pdf')
                ->usingName('visa_' . Str::random(10))
                ->toMediaCollection('visa');

            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Visa guardado',
                    $description = 'Se ha guardado el Vvsa con éxito.'
                );
                $this->dispatch('resetFilePond');
                $this->reset('visa');
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'CURP',
                $description = 'Ha ocurrido un error al guardar el CURP'
            );
            throw ($e);
        }
    }

    public function deleteHijo($index)
    {
        unset($this->hijos[$index]);
        $this->hijos = array_values($this->hijos);
        try {
            DB::beginTransaction();
            $this->personalData->hijo = $this->hijos;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Hijo guardado',
                    $description = 'Se ha eliminado el hijo con éxito.'
                );
                $this->mount($this->personalData->user_id);
                $this->dispatch('update-hijos');
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Hijo',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }

    public function deleteContacto($index)
    {
        unset($this->contactos[$index]);
        $this->contactos = array_values($this->contactos);
        try {
            DB::beginTransaction();
            $this->personalData->contacto_emergencia = $this->contactos;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Contactos',
                    $description = 'Se ha eliminado el contacto con éxito.'
                );
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Hijo',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
    public function deleteAlergia($index)
    {
        unset($this->alergiaCollect[$index]);
        $this->alergiaCollect = array_values($this->alergiaCollect);
        try {
            DB::beginTransaction();
            $this->personalData->alergias = $this->alergiaCollect;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Alergias',
                    $description = 'Se ha eliminado la alergia con éxito.'
                );
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Hijo',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
    public function deleteEnfermedad($index)
    {
        unset($this->enfermedadCollect[$index]);
        $this->enfermedadCollect = array_values($this->enfermedadCollect);
        try {
            DB::beginTransaction();
            $this->personalData->enfermedad = $this->enfermedadCollect;
            $this->personalData->save();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Enfermedades',
                    $description = 'Se ha eliminado la enfermedad con éxito.'
                );
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Hijo',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
    public function deleteFile($collectionName, $fileIndex)
    {
        try {
            DB::beginTransaction();
            if ($collectionName == 'comprobante_domicilio') {
                $this->comprobanteDomicilioCollect[$fileIndex]->delete();
                // $this->comprobanteDomicilioCollect = array_values($this->comprobanteDomicilioCollect);
            }
            if ($collectionName == 'constancia_fiscal') {
                $this->constanciaFiscalCollect[$fileIndex]->delete();
            }
            if ($collectionName == 'cursos_externos') {
                $this->cursosCollect[$fileIndex]->delete();
            }
            if ($collectionName == 'comprobante_estudios') {
                $this->comprobanteEstudiosCollect[$fileIndex]->delete();
            }
            // if ($collectionName == 'cedula') {
            //     $this->constanciaFiscalCollect[$fileIndex]->delete();
            // }
            if ($collectionName == 'identificacion_oficial') {
                $this->identificacionOficialCollect[$fileIndex]->delete();
            }
            if ($collectionName == 'curp') {
                $this->curpCollect[$fileIndex]->delete();
            }
            if ($collectionName == 'pasaporte') {
                $this->pasaporteCollect[$fileIndex]->delete();
            }
            if ($collectionName == 'visa') {
                $this->visaCollect[$fileIndex]->delete();
            }
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Documento',
                    $description = 'Se ha eliminado el documento con éxito.'
                );
                $this->mount($this->personalData->user_id);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Hijo',
                $description = 'Ha ocurrido un error al guardar la informacion'
            );
            throw ($e);
        }
    }
}

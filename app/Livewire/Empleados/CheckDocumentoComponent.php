<?php

namespace App\Livewire\Empleados;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class CheckDocumentoComponent extends Component
{
    use Actions;
    public $user;
    public $documento = [];
    public $opcionales = [];
    public $admisionVieja;
    public function mount($id)
    {
        $fechaAComparar = Carbon::parse('2020-1-01'); //las personas que hayan ingresado antes de junio 2018
        $fechaAComparar2 = Carbon::parse('2022-1-01'); //las personas que hayan ingresado antes de enero 2022
        $this->user = User::with(['job', 'checkDocumento'])->findOrFail($id);
        $admision = $this->user->admission;


        if ($admision->lt($fechaAComparar)) {
            $this->admisionVieja = 'antes de enero 2020';
        }

        if ($admision->lt($fechaAComparar2) && $admision->isAfter($fechaAComparar)) {
            $this->admisionVieja = 'antes de enero 2022';
        }

        if (blank($this->user->checkDocumento)) {
            $this->documento = [
                'acta_nacimiento' => false,
                'antecedentes_clinicos' => false,
                'carta_compromiso_codigo_etica' => false,
                'carta_oferta' => false,
                'cartas_recomendacion' => false,
                'certificado_medico' => false,
                'codigo_etica_conducta' => false,
                'comprobante_banco' => false,
                'comprobante_domicilio' => false,
                'comprobante_estudios' => false,
                'constancia_situacion_fiscal' => false,
                'cuestionario_anticorrupcion' => false,
                'curp' => false,
                'cv_solicitud_empleo' => false,
                'evalucion_entrevista' => false,
                'formato_aptitud' => false,
                'identificacion_oficial' => false,
                'kit_contratacion' => false,
                'numero_seguro_social' => false,
                'reglamento_interno_trabajo_firmado' => false,
            ];
        } else {
            $this->documento = [
                'acta_nacimiento' => $this->user->checkDocumento['acta_nacimiento'],
                'antecedentes_clinicos' => $this->admisionVieja == 'antes de enero 2020' ? false : $this->user->checkDocumento['antecedentes_clinicos'],
                'carta_compromiso_codigo_etica' => $this->user->checkDocumento['carta_compromiso_codigo_etica'],
                'carta_oferta' => $this->admisionVieja == 'antes de enero 2020' ? false : $this->user->checkDocumento['carta_oferta'],
                'cartas_recomendacion' => $this->admisionVieja == 'antes de enero 2020' ? false : $this->user->checkDocumento['cartas_recomendacion'],
                'certificado_medico' => $this->user->checkDocumento['certificado_medico'],
                'codigo_etica_conducta' => $this->user->checkDocumento['codigo_etica_conducta'],
                'comprobante_banco' => $this->user->checkDocumento['comprobante_banco'],
                'comprobante_domicilio' => $this->user->checkDocumento['comprobante_domicilio'],
                'comprobante_estudios' => $this->user->checkDocumento['comprobante_estudios'],
                'constancia_situacion_fiscal' => $this->user->checkDocumento['constancia_situacion_fiscal'],
                'cuestionario_anticorrupcion' => $this->user->checkDocumento['cuestionario_anticorrupcion'],
                'curp' => $this->user->checkDocumento['curp'],
                'cv_solicitud_empleo' => $this->user->checkDocumento['cv_solicitud_empleo'],
                'evalucion_entrevista' => $this->admisionVieja == 'antes de enero 2020' || $this->admisionVieja == 'antes de enero 2022' ? false : $this->user->checkDocumento['evalucion_entrevista'],
                'formato_aptitud' => $this->admisionVieja == 'antes de enero 2020' ? false : $this->user->checkDocumento['formato_aptitud'],
                'identificacion_oficial' => $this->user->checkDocumento['identificacion_oficial'],
                'kit_contratacion' => $this->user->checkDocumento['kit_contratacion'],
                'numero_seguro_social' => $this->user->checkDocumento['numero_seguro_social'],
                'reglamento_interno_trabajo_firmado' => $this->user->checkDocumento['reglamento_interno_trabajo_firmado'],
            ];
        }
        if (isset($this->user->checkDocumento['opcionales']) && !blank($this->user->checkDocumento['opcionales'])) {
            $this->opcionales = [
                'evaluacion_desempeno' => $this->user->checkDocumento['opcionales']['evaluacion_desempeno'],
                'evalucion_periodo_prueba_90_dias' => $this->user->checkDocumento['opcionales']['evalucion_periodo_prueba_90_dias'],
                'convenios_especiales_promociones' => $this->user->checkDocumento['opcionales']['convenios_especiales_promociones'],
                'solicitud_vacaciones' => $this->user->checkDocumento['opcionales']['solicitud_vacaciones'],
                'permisos_pago_tiempo_por_tiempo' => $this->user->checkDocumento['opcionales']['permisos_pago_tiempo_por_tiempo'],
                'incapacidades' => $this->user->checkDocumento['opcionales']['incapacidades'],
                'capacitacion' => $this->user->checkDocumento['opcionales']['capacitacion'],
                'otros_documentos' => $this->user->checkDocumento['opcionales']['otros_documentos'],
                'acta_matrimonio' => $this->user->checkDocumento['opcionales']['acta_matrimonio'],
                'acta_nacimiento_esposa_hijos' => $this->user->checkDocumento['opcionales']['acta_nacimiento_esposa_hijos'],
                'aviso_retencion_infonavit' => $this->user->checkDocumento['opcionales']['aviso_retencion_infonavit'],
                'aviso_retencion_fonacot' => $this->user->checkDocumento['opcionales']['aviso_retencion_fonacot'],
                'actualizacion_datos_último' => $this->user->checkDocumento['opcionales']['actualizacion_datos_último'],
            ];
        } else {
            $this->opcionales = [
                'evaluacion_desempeno' => '',
                'evalucion_periodo_prueba_90_dias' => '',
                'convenios_especiales_promociones' => '',
                'solicitud_vacaciones' => '',
                'permisos_pago_tiempo_por_tiempo' => '',
                'incapacidades' => '',
                'capacitacion' => '',
                'otros_documentos' => '',
                'acta_matrimonio' => '',
                'acta_nacimiento_esposa_hijos' => '',
                'aviso_retencion_infonavit' => '',
                'aviso_retencion_fonacot' => '',
                'actualizacion_datos_último' => '',
            ];
        }
    }
    protected $rules = [
        'documento.acta_nacimiento' => 'required',
        'documento.antecedentes_clinicos' => 'required',
        'documento.carta_compromiso_codigo_etica' => 'required',
        'documento.carta_oferta' => 'required',
        'documento.cartas_recomendacion' => 'required',
        'documento.certificado_medico' => 'required',
        'documento.codigo_etica_conducta' => 'required',
        'documento.comprobante_banco' => 'required',
        'documento.comprobante_domicilio' => 'required',
        'documento.comprobante_estudios' => 'required',
        'documento.constancia_situacion_fiscal' => 'required',
        'documento.cuestionario_anticorrupcion' => 'required',
        'documento.curp' => 'required',
        'documento.cv_solicitud_empleo' => 'required',
        'documento.evalucion_entrevista' => 'required',
        'documento.formato_aptitud' => 'required',
        'documento.identificacion_oficial' => 'required',
        'documento.kit_contratacion' => 'required',
        'documento.numero_seguro_social' => 'required',
        'documento.reglamento_interno_trabajo_firmado' => 'required',
        "opcionales.capacitacion" => "nullable",
        "opcionales.incapacidades" => "nullable",
        "opcionales.acta_matrimonio" => "nullable",
        "opcionales.otros_documentos" => "nullable",
        "opcionales.evaluacion_desempeno" => "nullable",
        "opcionales.solicitud_vacaciones" => "nullable",
        "opcionales.aviso_retencion_fonacot" => "nullable",
        "opcionales.aviso_retencion_infonavit" => "nullable",
        "opcionales.actualizacion_datos_último" => "nullable",
        "opcionales.acta_nacimiento_esposa_hijos" => "nullable",
        "opcionales.permisos_pago_tiempo_por_tiempo" => "nullable",
        "opcionales.convenios_especiales_promociones" => "nullable",
        "opcionales.evalucion_periodo_prueba_90_dias" => "nullable",
    ];
    public function render()
    {
        return view('livewire.empleados.check-documento-component');
    }

    public function guardar()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->user->checkDocumento()->updateOrCreate(
                [
                    'user_id' => $this->user->id,
                ],
                $this->documento
            );
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Check Documento',
                    $description = 'Información guardada con éxito'
                );
                $this->user->load(['checkDocumento']);
            });
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Check Documento',
                $description = 'Ocurrio un error al guardar la información'
            );
        }
    }
    public function guardarOpcionales()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->user->checkDocumento['opcionales'] = $this->opcionales;
            $this->user->checkDocumento->save();
            DB::commit();
            DB::afterCommit(function () {
                $this->notification()->success(
                    $title = 'Check Documento',
                    $description = 'Información guardada con éxito'
                );
                $this->user->load(['checkDocumento']);
            });
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Check Documento',
                $description = 'Ocurrio un error al guardar la información'
            );
        }
    }

    #[Computed]
    public function avance()
    {
        $contadorTrue = 0;
        foreach ($this->documento as $key => $value) {
            if ($value == 1) {
                $contadorTrue++;
            }
        }
        if ($this->admisionVieja == 'antes de enero 2020') {

            return $contadorTrue == 0 ? 0 : number_format(($contadorTrue / 15) * 100, 2, '.', '');
        } elseif ($this->admisionVieja == 'antes de enero 2022') {
            return $contadorTrue == 0 ? 0 :  number_format(($contadorTrue / 19) * 100, 2, '.', '');
        } else {
            return $contadorTrue == 0 ? 0 :  number_format(($contadorTrue / 20) * 100, 2, '.', '');
        }
    }
}

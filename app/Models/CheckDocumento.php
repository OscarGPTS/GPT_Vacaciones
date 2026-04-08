<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckDocumento extends Model
{
    use HasFactory;
    use Userstamps;

    protected $table = 'check_documentos';

    protected $fillable = [
        'acta_nacimiento',
        'antecedentes_clinicos',
        'carta_compromiso_codigo_etica',
        'carta_oferta',
        'cartas_recomendacion',
        'certificado_medico',
        'codigo_etica_conducta',
        'comprobante_banco',
        'comprobante_domicilio',
        'comprobante_estudios',
        'constancia_situacion_fiscal',
        'cuestionario_anticorrupcion',
        'curp',
        'cv_solicitud_empleo',
        'evalucion_entrevista',
        'formato_aptitud',
        'identificacion_oficial',
        'kit_contratacion',
        'numero_seguro_social',
        'reglamento_interno_trabajo_firmado',
        'opcionales',
        'user_id',
    ];
    protected $casts =
    [
        'acta_nacimiento' => 'boolean',
        'antecedentes_clinicos' => 'boolean',
        'carta_compromiso_codigo_etica' => 'boolean',
        'carta_oferta' => 'boolean',
        'cartas_recomendacion' => 'boolean',
        'certificado_medico' => 'boolean',
        'codigo_etica_conducta' => 'boolean',
        'comprobante_banco' => 'boolean',
        'comprobante_domicilio' => 'boolean',
        'comprobante_estudios' => 'boolean',
        'constancia_situacion_fiscal' => 'boolean',
        'cuestionario_anticorrupcion' => 'boolean',
        'curp' => 'boolean',
        'cv_solicitud_empleo' => 'boolean',
        'evalucion_entrevista' => 'boolean',
        'formato_aptitud' => 'boolean',
        'identificacion_oficial' => 'boolean',
        'kit_contratacion' => 'boolean',
        'numero_seguro_social' => 'boolean',
        'reglamento_interno_trabajo_firmado' => 'boolean',
        'opcionales' => 'array',
    ];
}

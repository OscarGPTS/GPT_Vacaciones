<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalData extends Model implements HasMedia, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use Userstamps;
    use InteractsWithMedia;

    protected $table = 'users_personal_data';

    protected $fillable = [
        'birthday',
        'curp',
        'rfc',
        'nss',
        'personal_mail',
        'personal_phone',
        'estado_civil',
        'estudios',
        'hijo',
        'contacto_emergencia',
        'alergias',
        'tipo_sangre',
        'enfermedad',
    ];

    protected $casts = [
        'birthday' => 'datetime:Y-m-d',
        'estado_civil' => 'array',
        'hijo' => 'array',
        'contacto_emergencia' => 'array',
        'alergias' => 'array',
        'tipo_sangre' => 'array',
        'enfermedad' => 'array',
        'estudios' => 'array'
    ];
    protected $auditInclude = [
        'birthday',
        'curp',
        'rfc',
        'nss',
        'personal_mail',
        'personal_phone',
        'estado_civil',
        'estudios',
        'hijo',
        'contacto_emergencia',
        'alergias',
        'tipo_sangre',
        'enfermedad'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('comprobante_domicilio');
        $this->addMediaCollection('constancia_fiscal');
        $this->addMediaCollection('cursos_externos');
        $this->addMediaCollection('comprobante_estudios');
        $this->addMediaCollection('cedula');
        $this->addMediaCollection('identificacion_oficial');
        $this->addMediaCollection('curp');
        $this->addMediaCollection('pasaporte');
        $this->addMediaCollection('visa');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

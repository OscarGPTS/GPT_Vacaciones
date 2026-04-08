<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Job extends Model implements  HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use HasJsonRelationships;

    protected $table = 'jobs';

    protected $fillable = [
        'name',
        'objetivo',
        'funciones',
        'clasificacion',
        'relaciones_internas',
        'relaciones_externas',
        'personal_cargo',
        'plan_contingencia',
        'desarrollo',
        'ambiente',
        'requisitos',
        'responsabilidad',
        'responsabilidad_sgi',
        'depto_id'
    ];

    protected $casts = [
        'responsabilidad' => 'array',
        'funciones' => 'array',
        'relaciones_internas' => 'array',
        'relaciones_externas' => 'array',
        'personal_cargo' => 'array',
        'plan_contingencia' => 'array',
        'desarrollo' => 'array',
        'ambiente' => 'array',
        'requisitos' => 'array',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => ucfirst($value),
            set: fn ($value) => trim($value),
        );
    }
    public function departamento()
    {
        return $this->BelongsTo(Departamento::class, 'depto_id');
    }


    // Relaciones entre los demas modelos
    public function conocimiento()
    {
        return $this->hasMany(PuestoConocimiento::class,'job_id');
    }

    public function empleados()
    {
        return $this->hasMany(User::class, 'job_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('firma-elaboro-descriptivo-puesto')
            ->singleFile();

        $this
            ->addMediaCollection('firma-reviso-descriptivo-puesto')
            ->singleFile();
        $this
            ->addMediaCollection('firma-autorizo-descriptivo-puesto')
            ->singleFile();

        $this->addMediaConversion('thumb')
            ->performOnCollections('firma-elaboro-descriptivo-puesto', 'firma-reviso-descriptivo-puesto', 'firma-autorizo-descriptivo-puesto')
            ->width(368)
            ->height(232);
    }
}


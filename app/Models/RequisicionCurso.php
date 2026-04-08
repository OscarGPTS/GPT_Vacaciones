<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\StateMachines\RequisicionCursoStateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RequisicionCurso extends Model implements HasMedia
{
    use InteractsWithMedia, HasStateMachines, HasFactory;
    protected $table = 'requisiciones_curso';
    protected $fillable = [
        'nombre',
        'tipo_capacitacion',
        'justificacion',
        'motivo',
        'beneficio',
        'comentarios',
        'status'
    ];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cotizacion')
            ->singleFile();
        $this->addMediaCollection('temario')
            ->singleFile();
    }
    public $stateMachines = [
        'status' => RequisicionCursoStateMachine::class
    ];


    public function participantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('rol');
    }

    public function cotizacion()
    {
        return  $this->getMedia('cotizacion')->first();
    }
    public function temario()
    {
        return  $this->getMedia('temario')->first();
    }
}

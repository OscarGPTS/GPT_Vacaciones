<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\StateMachines\RequisicionPersonalStateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;

class RequisicionPersonal extends Model
{
    Use HasStateMachines;
    use HasFactory;

    protected $table = 'requisiciones_personal';

    protected $fillable = [
        'tipo_personal',
        'motivo',
        'horario',
        'personas_requeridas',
        'grado_escolar',
        'experiencia_years',
        'trabajo_campo',
        'trato_clientes',
        'manejo_personal',
        'licencia_conducir',
        'licencia_tipo',
        'conocimientos',
        'competencias',
        'actividades',
        'status',
        'puesto_solicitado',
        'puesto_nuevo',
        'solicitante_id',
    ];

    protected $casts = [
        'trabajo_campo' => 'boolean',
        'trato_clientes' => 'boolean',
        'manejo_personal' => 'boolean',
        'licencia_conducir' => 'boolean',
        'conocimientos' => 'array',
        'competencias' => 'array',
        'actividades' => 'array'
    ];
    public $stateMachines = [
        'status' => RequisicionPersonalStateMachine::class
    ];

    public function folio()
    {
        return str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }
    public function puesto()
    {
        return $this->belongsTo(Job::class, 'puesto_solicitado');
    }
}

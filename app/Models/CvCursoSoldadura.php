<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvCursoSoldadura extends Model
{
    use HasFactory;
    protected $table = 'cv_curso_soldadura';
    protected $fillable = [
        'nombre',
        'proceso',
        'wps',
        'desde',
        'hasta',
        'user_id'
    ];
}

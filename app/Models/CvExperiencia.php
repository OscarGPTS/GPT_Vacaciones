<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvExperiencia extends Model
{
    use HasFactory;

    protected $table = 'cv_experiencias';
    protected $fillable = [
        'fecha_inicio',
        'fecha_final',
        'actualmente_laborando',
        'puesto',
    ];
}

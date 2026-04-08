<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvHistorialServicio extends Model
{
    use HasFactory;

    protected $table = 'cv_historial_servicios';
    protected $fillable = [
        'cliente',
        'year',
        'ubicacion',
        'tipo_servicio',
        'cabezal',
        'ramal',
        'clase',
        'servicio',
        'alcance',
        'diametro',
        'mes',
        'user_id',
    ];
}

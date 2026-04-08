<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvCursoCertificacion extends Model
{
    use HasFactory;
    protected $table = 'cv_curso_certificacions';
    protected $fillable =[
        'nombre',
        'tipo',
        'year',
        'user_id'
    ];

}

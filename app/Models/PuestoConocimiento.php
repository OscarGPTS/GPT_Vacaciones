<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoConocimiento extends Model
{
    use HasFactory;

    protected $table = 'puesto_conocimientos';

    protected $fillable = ['descripcion','job_id'];
}

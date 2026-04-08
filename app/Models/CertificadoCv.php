<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificadoCv extends Model
{
    use HasFactory;
    protected $table = 'cv_certificaciones';
    protected $fillable = [
        'uuid',
        'alcance'
    ];
}

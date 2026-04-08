<?php

namespace App\Models\Satech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RazonSocial extends Model
{
    use HasFactory;
    protected $connection = 'mysql_satech';
    protected $table = 'razones_sociales';
}

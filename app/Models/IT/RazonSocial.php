<?php

namespace App\Models\IT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RazonSocial extends Model
{
    use HasFactory;
    protected $connection = 'mysql_it_satechenergy';
    protected $table = 'razones_sociales';
}

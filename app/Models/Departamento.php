<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departamento extends Model
{
    use HasFactory;


    protected $table = 'departamentos';

    protected $fillable = [
        'name',
        'area_id'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'depto_id');
    }

}

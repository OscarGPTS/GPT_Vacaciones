<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoWorkingDays extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';
    protected $table = 'no_working_days';

    protected $fillable = [
        'id',
        'day',
        'reason'
    ];

    public $timestamps = false;
}

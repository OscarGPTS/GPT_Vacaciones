<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomOrgchart extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';
    protected $table = 'custom_orgcharts';

    protected $fillable = [
        'title',
        'description',
        'nodes',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'nodes'     => 'array',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

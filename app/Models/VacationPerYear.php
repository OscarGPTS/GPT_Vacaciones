<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationPerYear extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';
    protected $table = 'vacation_per_years';

    public $timestamps = false;

    protected $fillable = [
        'year',
        'days',
    ];

    protected $casts = [
        'year' => 'integer',
        'days' => 'integer',
    ];

    /**
     * Get vacation days for a specific year.
     */
    public static function getDaysForYear(int $year): int
    {
        return static::where('year', $year)->value('days') ?? 0;
    }

    /**
     * Set vacation days for a specific year.
     */
    public static function setDaysForYear(int $year, int $days): VacationPerYear
    {
        return static::updateOrCreate(
            ['year' => $year],
            ['days' => $days]
        );
    }
}
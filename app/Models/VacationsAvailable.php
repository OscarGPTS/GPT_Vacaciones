<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationsAvailable extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';

    protected $fillable = [
        'period',
        // 'days_total_period', // ❌ ELIMINADO - usar $vacation->vacationPerYear->days
        'days_availables',
        'days_calculated',
        // 'dv', // ❌ ELIMINADO - campo deprecado de días adicionales RH
        'days_enjoyed',
        'days_enjoyed_before_anniversary',
        'days_enjoyed_after_anniversary',
        'days_reserved',
        'date_start',
        'date_end',
        'cutoff_date',
        'is_historical',
        'status',
        'users_id',
    ];

    protected $casts = [
        // 'days_total_period' => 'decimal:2', // ❌ ELIMINADO - usar relación
        'days_availables' => 'decimal:2',
        'days_calculated' => 'decimal:2',
        'period' => 'integer',
        // 'dv' => 'integer', // ❌ ELIMINADO - campo deprecado
        'days_enjoyed' => 'integer',
        'days_enjoyed_before_anniversary' => 'decimal:2',
        'days_enjoyed_after_anniversary' => 'decimal:2',
        'days_reserved' => 'decimal:2',
        'date_start' => 'date',
        'date_end' => 'date',
        'cutoff_date' => 'date',
        'is_historical' => 'boolean',
    ];

    /**
     * Get the user that owns the vacation available record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relación con catálogo de días por año (LFT México)
     * Obtiene los días que corresponden según el año de antigüedad
     * 
     * IMPORTANTE: Esta relación centraliza la norma mexicana.
     * El campo `days_total_period` es redundante y puede eliminarse
     * en una futura migración, usando en su lugar:
     * $vacation->vacationPerYear->days
     */
    public function vacationPerYear(): BelongsTo
    {
        return $this->belongsTo(VacationPerYear::class, 'period', 'year');
    }

    /**
     * Accessor: Obtiene días totales del período desde la relación
     * (alternativa a days_total_period que ya fue eliminado)
     */
    public function getTotalDaysFromCatalogAttribute(): int
    {
        return $this->vacationPerYear?->days ?? 0;
    }

    /**
     * Obtiene la base correcta de días disponibles.
     *
     * Si `days_calculated` tiene un valor mayor a cero, se prioriza porque
     * representa el cálculo automático del sistema. Si viene en 0 o NULL
     * (caso frecuente en períodos importados de años anteriores), se usa
     * `days_availables` como respaldo.
     */
    public function getEffectiveAvailableDaysAttribute(): float
    {
        $daysCalculated = $this->days_calculated !== null
            ? (float) $this->days_calculated
            : null;

        if ($daysCalculated !== null && $daysCalculated > 0) {
            return $daysCalculated;
        }

        return (float) ($this->days_availables ?? 0);
    }

    /**
     * Saldo disponible visible para solicitudes.
     *
     * En el formulario de vacaciones y en las cards de selección, la fuente
     * principal debe ser `days_availables`. Solo se descuenta `days_reserved`
     * para evitar sobre-reservas en solicitudes pendientes.
     */
    public function getAvailableBalanceAttribute(): float
    {
        return round(
            (float) ($this->days_availables ?? 0)
            - (float) ($this->days_reserved ?? 0),
            2
        );
    }

    /**
     * Get the period options.
     */
    public static function getPeriodOptions(): array
    {
        return [
            1 => 'Período 1',
            2 => 'Período 2',
            3 => 'Período 3',
        ];
    }

    /**
     * Get the period name.
     */
    public function getPeriodNameAttribute(): string
    {
        return self::getPeriodOptions()[$this->period] ?? 'Desconocido';
    }
}
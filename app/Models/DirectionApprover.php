<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectionApprover extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';

    protected $fillable = [
        'boss_id',
        'employee_id',
        'departamento_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who is the approver (the boss).
     * Cross-database relationship: mysql_vacations → mysql
     */
    public function boss(): BelongsTo
    {
        return $this->belongsTo(User::class, 'boss_id');
    }

    /**
     * Get the user who is the approver (alias for boss).
     */
    public function user(): BelongsTo
    {
        return $this->boss();
    }

    /**
     * Get the department that this approver can approve.
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Get the employee that this approver is assigned to.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Scope para obtener solo aprobadores activos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Obtener todos los departamentos que un usuario puede aprobar.
     */
    public static function getDepartmentsForUser($bossId)
    {
        return static::where('boss_id', $bossId)
            ->where('is_active', true)
            ->pluck('departamento_id')
            ->unique()
            ->toArray();
    }

    /**
     * Verificar si un usuario puede aprobar solicitudes de un departamento.
     */
    public static function canApprove($bossId, $departamentoId)
    {
        return static::where('boss_id', $bossId)
            ->where('departamento_id', $departamentoId)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Obtener todos los usuarios que pueden aprobar un departamento específico.
     */
    public static function getApproversForDepartment($departamentoId)
    {
        return static::where('departamento_id', $departamentoId)
            ->where('is_active', true)
            ->with('boss')
            ->get()
            ->pluck('boss')
            ->unique('id');
    }

    /**
     * Obtener el aprobador de dirección asignado para un empleado específico.
     * Busca directamente por employee_id.
     * 
     * @param int $employeeId ID del empleado
     * @return int|null ID del aprobador asignado
     */
    public static function getDirectionApproverForUser($employeeId)
    {
        $approver = static::where('employee_id', $employeeId)
            ->where('is_active', true)
            ->first();

        return $approver ? $approver->boss_id : null;
    }

    /**
     * Obtener el aprobador para el departamento (método legacy, mantiene compatibilidad).
     * NOTA: Con la nueva implementación, se recomienda usar getDirectionApproverForUser directamente.
     * 
     * @param int $departamentoId ID del departamento
     * @return int|null ID del primer aprobador activo encontrado
     */
    public static function getDirectionApproverForDepartment($departamentoId)
    {
        $approver = static::where('departamento_id', $departamentoId)
            ->where('is_active', true)
            ->first();

        return $approver ? $approver->boss_id : null;
    }
}

<?php

namespace App\Models;

use App\Traits\TrimSpacesTrait;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Import the new models for relationships
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use App\Models\RequestApproved;
use App\Models\RequestRejected;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use TrimSpacesTrait;

    protected $table = 'users';
    protected $connection = 'mysql';
    public $incrementing = false;

    // protected $with = ['personalData'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'uuid',
        'last_name',
        'first_name',
        'business_name_id',
        'admission',
        'job_id',
        'boss_id',
        'email',
        'phone',
        'profile_image',
        'cloudinary_public_id',
        'libreta_mar',
        'escolaridad',  
        'escolaridad_nombre',
        'cedula',
        'active',
    ];

    protected $casts = [
        'admission' => 'datetime:Y-m-d',
    ];

    public function nombre()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function cvFormatoTipo()
    {
        if ($this->job->departamento->id == 10 || $this->job->departamento->id == 11) {
            return 1;
        } elseif ($this->job->departamento->id == 5 || $this->job->departamento->id == 6) {
            return 2;
        } else {
            return 'sin formato';
        }
    }
    public function showHistorialServicios()
    {
        if ($this->job->departamento->id == 5 || $this->job->departamento->id == 6 || $this->job->departamento->id == 10 || $this->job->departamento->id == 11) {
            return true;
        }
    }

    // Relaciones
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function razonSocial()
    {
        return $this->belongsTo(RazonSocial::class, 'business_name_id');
    }

    public function jefe()
    {
        return $this->belongsTo(User::class, 'boss_id');
    }

    public function subordinados()
    {
        return $this->hasMany(User::class, 'boss_id');
    }

    public function firma()
    {
        return $this->hasOne(Firma::class, 'id');
    }

    public function personalData()
    {
        return $this->hasOne(PersonalData::class, 'user_id');
    }
    public function checkDocumento()
    {
        return $this->hasOne(CheckDocumento::class, 'user_id');
    }
    public function cvExperiencia()
    {
        return $this->hasMany(CvExperiencia::class);
    }
    public function CertificadoCv()
    {
        return $this->hasOne(CertificadoCv::class);
    }
    public function cvCursoCertificacion()
    {
        return $this->hasMany(CvCursoCertificacion::class);
    }
    public function cvCursoSoldadura()
    {
        return $this->hasMany(CvCursoSoldadura::class);
    }
    public function cvHistorialServicio()
    {
        return $this->hasMany(CvHistorialServicio::class);
    }

    public function belongsToDepartamento()
    {
        $departamentoId = 6;   // El ID del departamento que deseas verificar
        // Obtenemos el departamento del usuario a través de la relación
        $userDepartamentoId = $this->job->departamento->id;

        // Comparamos el ID del departamento del usuario con el ID proporcionado
        return $userDepartamentoId === $departamentoId;
    }

    public function requestDone()
    {
        return $this->hasMany(RequestVacations::class, 'user_id');
    }

    public function requestVacations()
    {
        return $this->hasMany(RequestVacations::class, 'user_id');
    }

    public function jefeDirecto()
    {
        return $this->hasOne(User::class, 'id', 'jefe_directo_id');
    }

    public function requestToAuth()
    {
        return $this->hasMany(RequestVacations::class, 'direct_manager_id');
    }

    public function vacationsAvailable()
    {
        return $this->hasMany(VacationsAvailable::class, 'users_id');
    }

    public function approvedRequests()
    {
        return $this->hasMany(RequestApproved::class, 'users_id');
    }

    public function rejectedRequests()
    {
        return $this->hasMany(RequestRejected::class, 'users_id');
    }

    /**
     * Departamentos que este usuario puede aprobar como dirección.
     */
    public function directionApprovals()
    {
        return $this->hasMany(DirectionApprover::class, 'user_id');
    }

    /**
     * Obtener departamentos que puede aprobar (solo activos).
     */
    public function getApprovableDepartmentsAttribute()
    {
        return $this->directionApprovals()
            ->where('is_active', true)
            ->with('departamento')
            ->get()
            ->pluck('departamento');
    }

    /**
     * Verificar si el usuario puede aprobar solicitudes de dirección.
     */
    public function canApproveAsDirection()
    {
        // Puede aprobar si tiene el job_id 60 O si tiene departamentos asignados
        return $this->job_id == 60 || $this->directionApprovals()->where('is_active', true)->exists();
    }

}

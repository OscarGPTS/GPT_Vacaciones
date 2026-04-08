<?php

namespace App\Models\Satech;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $connection = 'mysql_satech';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'last_name',
        'first_name',
        'admission',
        'boss_id',
        'email',
        'phone',
        'profile_image',
        'area',
        'depto',
        'puesto',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function nombre()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function razonSocial()
    {
        return $this->belongsTo(RazonSocial::class, 'business_name_id');
    }
}

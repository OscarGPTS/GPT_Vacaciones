<?php

namespace App\Models\IT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $connection = 'mysql_it_satechenergy';
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
        'business_name_id',
        'admission',
        'boss_id',
        'email',
        'phone',
        'profile_image',
        'area',
        'depto',
        'puesto',
        'active'
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
        return "{$this->last_name} {$this->first_name}";
    }
    public function razonSocial()
    {
        return $this->belongsTo(RazonSocial::class, 'business_name_id');
    }
}

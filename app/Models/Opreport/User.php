<?php

namespace App\Models\Opreport;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $connection = 'mysql_opreports';
    protected $table = 'employee';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'lastName',
        'firstName',
        'birthday',
        'curp',
        'rfc',
        'nss',
        'bloodType',
        'admission',
        'area',
        'depto',
        'job',
        'pseudo',
        'business',
        'email',
        'phone',
        'profile_img',
        'empStatus'
    ];




    public function nombre()
    {
        return "{$this->firstName} {$this->lastName}";
    }
}

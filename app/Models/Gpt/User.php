<?php

namespace App\Models\Gpt;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $connection = 'mysql_gpt_services';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'email',
        'cel_1',
        'cel_2',
        'puesto',
        'empresa',
        'profile_img'
    ];




    public function nombre()
    {
        return "{$this->nombre} {$this->apellido}";
    }


}

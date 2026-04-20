<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSignature extends Model
{
    protected $connection = 'mysql_vacations';
    protected $table      = 'user_signatures';

    protected $fillable = [
        'user_id',
        'signature_url',
    ];

    /**
     * Devuelve el registro de firma para un usuario dado, o null si no existe.
     */
    public static function forUser(int $userId): ?self
    {
        return static::where('user_id', $userId)->first();
    }

    /**
     * Indica si un usuario ya tiene firma registrada.
     */
    public static function userHasSignature(int $userId): bool
    {
        return static::where('user_id', $userId)->exists();
    }
}

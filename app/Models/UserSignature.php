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
        'terms_accepted_at',
    ];

    protected $casts = [
        'terms_accepted_at' => 'datetime',
    ];

    /**
     * Devuelve el registro de firma (con signature_url) para un usuario, o null si no existe.
     */
    public static function forUser(int $userId): ?self
    {
        return static::where('user_id', $userId)->whereNotNull('signature_url')->first();
    }

    /**
     * Indica si un usuario ya tiene firma registrada.
     */
    public static function userHasSignature(int $userId): bool
    {
        return static::where('user_id', $userId)->whereNotNull('signature_url')->exists();
    }

    /**
     * Indica si el usuario ya aceptó los términos y condiciones.
     */
    public static function hasAcceptedTerms(int $userId): bool
    {
        return static::where('user_id', $userId)->whereNotNull('terms_accepted_at')->exists();
    }

    /**
     * Registra la aceptación de términos del usuario (crea el registro si no existe).
     */
    public static function acceptTerms(int $userId): void
    {
        static::updateOrCreate(
            ['user_id' => $userId],
            ['terms_accepted_at' => now()]
        );
    }
}

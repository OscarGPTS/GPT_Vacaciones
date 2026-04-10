<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelegationPermission extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';

    protected $fillable = [
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who has delegation permission.
     * Cross-database relationship: mysql_vacations → mysql
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for active permissions only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if a user has active delegation permission.
     */
    public static function hasPermission(int $userId): bool
    {
        return static::where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
    }
}

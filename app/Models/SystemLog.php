<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';

    protected $fillable = [
        'user_id',
        'created_by',
        'level',
        'type',
        'message',
        'context',
        'status',
        'resolved_at',
        'resolved_by',
        'resolution_notes',
    ];

    protected $casts = [
        'context' => 'array',
        'resolved_at' => 'datetime',
    ];

    /**
     * Usuario afectado por el error
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Usuario que creó/detectó el log
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuario que resolvió el error
     */
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeErrors($query)
    {
        return $query->where('level', 'error');
    }

    public function scopeWarnings($query)
    {
        return $query->where('level', 'warning');
    }

    /**
     * Helpers estáticos para crear logs fácilmente
     */
    public static function logError($type, $message, $userId = null, $context = null)
    {
        return self::create([
            'user_id' => $userId,
            'created_by' => auth()->id(),
            'level' => 'error',
            'type' => $type,
            'message' => $message,
            'context' => $context,
            'status' => 'pending',
        ]);
    }

    public static function logWarning($type, $message, $userId = null, $context = null)
    {
        return self::create([
            'user_id' => $userId,
            'created_by' => auth()->id(),
            'level' => 'warning',
            'type' => $type,
            'message' => $message,
            'context' => $context,
            'status' => 'pending',
        ]);
    }

    public static function logInfo($type, $message, $userId = null, $context = null)
    {
        return self::create([
            'user_id' => $userId,
            'created_by' => auth()->id(),
            'level' => 'info',
            'type' => $type,
            'message' => $message,
            'context' => $context,
            'status' => 'resolved', // Info logs se marcan como resueltos automáticamente
        ]);
    }

    /**
     * Marcar como resuelto
     */
    public function markAsResolved($notes = null)
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
            'resolution_notes' => $notes,
        ]);
    }

    /**
     * Marcar como ignorado
     */
    public function markAsIgnored($notes = null)
    {
        $this->update([
            'status' => 'ignored',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
            'resolution_notes' => $notes,
        ]);
    }
}


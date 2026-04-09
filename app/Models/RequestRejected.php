<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestRejected extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';
    protected $table = 'request_rejected';

    protected $fillable = [
        'title',
        'start',
        'end',
        'users_id',
        'requests_id',
    ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    /**
     * Get the user that owns the rejected request.
     * Cross-database relationship: mysql_vacations → mysql
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the original request.
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class, 'requests_id');
    }
}
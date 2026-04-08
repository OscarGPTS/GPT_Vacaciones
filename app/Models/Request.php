<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reveal_id',
        'type_request',
        'payment',
        'start',
        'end',
        'opcion',
        'reason',
        'doc_permiso',
        'direct_manager_id',
        'direct_manager_status',
        'human_resources_status',
        'visible',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'visible' => 'boolean',
    ];

    /**
     * Get the user that owns the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the direct manager for the request.
     */
    public function directManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'direct_manager_id');
    }

    /**
     * Get the approved requests for this request.
     */
    public function approvedRequests(): HasMany
    {
        return $this->hasMany(RequestApproved::class, 'requests_id');
    }

    /**
     * Get the rejected requests for this request.
     */
    public function rejectedRequests(): HasMany
    {
        return $this->hasMany(RequestRejected::class, 'requests_id');
    }
}
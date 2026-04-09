<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestVacations extends Model
{
    use HasFactory;

    protected $connection = 'mysql_vacations';
    public $table = 'requests';

    protected $fillable = [
        'user_id',
        'created_by_user_id',
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
        'direction_approbation_id',
        'direction_approbation_status',
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
     * Cross-database relationship: mysql_vacations → mysql
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
     * Get the direction approver for the request.
     */
    public function directionApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'direction_approbation_id');
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

    /**
     * Get the days selected for this request.
     */
    public function requestDays(): HasMany
    {
        return $this->hasMany(RequestApproved::class, 'requests_id');
    }

    /**
     * Get the user responsible for covering duties.
     * Cross-database relationship: mysql_vacations → mysql
     */
    public function reveal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reveal_id');
    }

    /**
     * Get the user who created this request (on behalf of another).
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Get the vacation period information for this request.
     * Returns null if no period is specified or if period info is not found.
     */
    public function getVacationPeriodAttribute()
    {
        if (empty($this->opcion)) {
            return null;
        }

        // Parse the opcion field (format: "period|date_start")
        $parts = explode('|', $this->opcion);
        if (count($parts) !== 2) {
            return null;
        }

        list($periodNumber, $dateStart) = $parts;

        // Find the vacation period
        $vacationPeriod = VacationsAvailable::where('users_id', $this->user_id)
            ->where('period', $periodNumber)
            ->where('date_start', $dateStart)
            ->first();

        return $vacationPeriod;
    }
}
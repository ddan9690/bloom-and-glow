<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'service_ids',
        'client_name',
        'client_phone',
        'preferred_date',
        'preferred_time',
        'original_date',
        'original_time',
        'location_type',
        'location_details',
        'status',
        'status_updated_by',
        'client_notes',
        'admin_notes',
    ];

    protected $casts = [
        'service_ids' => 'array',
        'preferred_date' => 'date',
        'original_date' => 'date',
    ];

    /**
     * Get the single service associated with the booking (via service_id).
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * The services that belong to the booking (fallback to single service if pivot table is missing).
     */
    public function services()
    {
        // If you are using service_ids JSON array or single service_id when pivot table is absent:
        if ($this->service_ids && is_array($this->service_ids)) {
            return Service::whereIn('id', $this->service_ids)->get();
        }
        
        return $this->hasMany(Service::class, 'id', 'service_id');
    }

    /**
     * Get the user who updated the status.
     */
    public function statusUpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'status_updated_by');
    }

    /**
     * Alias for statusUpdatedBy to match relationship calls.
     */
    public function statusUpdater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'status_updated_by');
    }
}
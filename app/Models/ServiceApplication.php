<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceApplication extends Model
{
    protected $fillable = [
        'user_id',
        'application_number',
        'service_type',
        'status',
        'data',
        'remarks',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function getServiceNameAttribute(): string
    {
        return match($this->service_type) {
            'learning-license' => 'Learning License',
            'driving-license' => 'Driving License',
            'vehicle-registration' => 'Vehicle Registration',
            default => ucwords(str_replace('-', ' ', $this->service_type)),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'approved' => 'green',
            'rejected' => 'red',
            'processing' => 'blue',
            default => 'yellow',
        };
    }
}

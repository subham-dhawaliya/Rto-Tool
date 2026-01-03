<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'booking_number',
        'service_type',
        'application_number',
        'rto_office',
        'appointment_date',
        'time_slot',
        'status',
        'remarks',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getServiceNameAttribute(): string
    {
        return match($this->service_type) {
            'll_test' => 'Learning License Test',
            'dl_test' => 'Driving Test',
            'vehicle_inspection' => 'Vehicle Inspection',
            'document_verification' => 'Document Verification',
            'fitness_test' => 'Fitness Test',
            default => 'Other Services',
        };
    }
}

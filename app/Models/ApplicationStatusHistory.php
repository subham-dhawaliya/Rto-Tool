<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatusHistory extends Model
{
    protected $table = 'application_status_history';

    protected $fillable = [
        'service_application_id',
        'status',
        'remarks',
        'updated_by',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(ServiceApplication::class, 'service_application_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Application Submitted',
            'document_verification' => 'Document Verification',
            'processing' => 'Under Processing',
            'slot_allotted' => 'Test Slot Allotted',
            'test_passed' => 'Test Passed',
            'test_failed' => 'Test Failed',
            'approved' => 'Application Approved',
            'rejected' => 'Application Rejected',
            'dispatched' => 'Document Dispatched',
            default => ucfirst($this->status),
        };
    }
}

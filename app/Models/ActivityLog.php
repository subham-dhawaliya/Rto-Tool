<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action_type',
        'target_type',
        'target_id',
        'action_details',
        'ip_address',
    ];
    
    protected $casts = [
        'action_details' => 'array',
    ];
    
    /**
     * Get the admin who performed this action
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    /**
     * Get the target model (polymorphic)
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}

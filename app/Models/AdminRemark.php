<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminRemark extends Model
{
    protected $fillable = [
        'application_id',
        'admin_id',
        'remark',
        'visibility',
    ];
    
    /**
     * Get the application this remark belongs to
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(ServiceApplication::class, 'application_id');
    }
    
    /**
     * Get the admin who created this remark
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    /**
     * Check if remark is public
     */
    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }
}

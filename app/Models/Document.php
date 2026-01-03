<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'service_application_id',
        'document_type',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'status',
        'rejection_reason',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(ServiceApplication::class, 'service_application_id');
    }

    public function getDocumentNameAttribute(): string
    {
        return match($this->document_type) {
            'aadhaar_doc' => 'Aadhaar Card',
            'address_proof' => 'Address Proof',
            'photo' => 'Passport Photo',
            'signature' => 'Signature',
            'medical_cert' => 'Medical Certificate (Form 1A)',
            'll_copy' => 'Learning License',
            'age_proof' => 'Age/DOB Proof',
            'id_proof' => 'ID Proof',
            'sale_invoice' => 'Sale Invoice',
            'insurance_doc' => 'Insurance Certificate',
            'puc_doc' => 'PUC Certificate',
            'form_20' => 'Form 20 (Sale Certificate)',
            default => ucwords(str_replace('_', ' ', $this->document_type)),
        };
    }
}

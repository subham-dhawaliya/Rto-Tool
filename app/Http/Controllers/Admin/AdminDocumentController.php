<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentVerification;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDocumentController extends Controller
{
    /**
     * Verify or reject a document
     */
    public function verify(Request $request, Document $document)
    {
        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);
        
        DB::transaction(function() use ($document, $validated) {
            DocumentVerification::updateOrCreate(
                ['document_id' => $document->id],
                [
                    'verified_by' => auth()->id(),
                    'status' => $validated['status'],
                    'rejection_reason' => $validated['rejection_reason'] ?? null,
                    'verified_at' => now(),
                ]
            );
            
            // Log activity
            ActivityLog::create([
                'admin_id' => auth()->id(),
                'action_type' => 'document_verify',
                'target_type' => 'Document',
                'target_id' => $document->id,
                'action_details' => json_encode([
                    'document_type' => $document->document_type,
                    'status' => $validated['status'],
                    'reason' => $validated['rejection_reason'] ?? null,
                ]),
                'ip_address' => request()->ip(),
            ]);
        });
        
        return redirect()->back()->with('success', 'Document verification updated successfully');
    }
}

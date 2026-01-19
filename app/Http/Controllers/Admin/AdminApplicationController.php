<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceApplication;
use App\Models\AdminRemark;
use App\Models\ApplicationStatusHistory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApplicationController extends Controller
{
    /**
     * Display list of applications with filters
     */
    public function index(Request $request)
    {
        $query = ServiceApplication::with('user', 'documents');
        
        // Apply status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Apply service type filter
        if ($request->has('service_type') && $request->service_type !== 'all') {
            $query->where('service_type', $request->service_type);
        }
        
        // Apply search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('application_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $applications = $query->latest()->paginate(20);
        
        return view('admin.applications.index', compact('applications'));
    }
    
    /**
     * Show application details
     */
    public function show(ServiceApplication $application)
    {
        $application->load([
            'user',
            'documents.verification.verifier',
            'statusHistory.changedBy',
            'remarks.admin'
        ]);
        
        return view('admin.applications.show', compact('application'));
    }
    
    /**
     * Update application status
     */
    public function updateStatus(Request $request, ServiceApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected,on_hold,requires_clarification',
            'reason' => 'required_if:status,rejected,requires_clarification|nullable|string|max:1000',
        ]);
        
        DB::transaction(function() use ($application, $validated) {
            // Update application status
            $application->update(['status' => $validated['status']]);
            
            // Create status history entry
            ApplicationStatusHistory::create([
                'application_id' => $application->id,
                'status' => $validated['status'],
                'changed_by' => auth()->id(),
                'remarks' => $validated['reason'] ?? null,
            ]);
            
            // Log activity
            ActivityLog::create([
                'admin_id' => auth()->id(),
                'action_type' => 'status_change',
                'target_type' => 'Application',
                'target_id' => $application->id,
                'action_details' => json_encode([
                    'application_number' => $application->application_number,
                    'new_status' => $validated['status'],
                    'reason' => $validated['reason'] ?? null,
                ]),
                'ip_address' => request()->ip(),
            ]);
        });
        
        return redirect()->back()->with('success', 'Application status updated successfully');
    }
    
    /**
     * Add admin remark to application
     */
    public function addRemark(Request $request, ServiceApplication $application)
    {
        $validated = $request->validate([
            'remark' => 'required|string|max:1000',
            'visibility' => 'required|in:internal,public',
        ]);
        
        AdminRemark::create([
            'application_id' => $application->id,
            'admin_id' => auth()->id(),
            'remark' => $validated['remark'],
            'visibility' => $validated['visibility'],
        ]);
        
        // Log activity
        ActivityLog::create([
            'admin_id' => auth()->id(),
            'action_type' => 'remark_added',
            'target_type' => 'Application',
            'target_id' => $application->id,
            'action_details' => json_encode([
                'application_number' => $application->application_number,
                'visibility' => $validated['visibility'],
            ]),
            'ip_address' => request()->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Remark added successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceApplication;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Calculate statistics
        $stats = [
            'total_applications' => ServiceApplication::count(),
            'pending_applications' => ServiceApplication::where('status', 'pending')->count(),
            'under_review_applications' => ServiceApplication::where('status', 'under_review')->count(),
            'approved_applications' => ServiceApplication::where('status', 'approved')->count(),
            'rejected_applications' => ServiceApplication::where('status', 'rejected')->count(),
            
            'total_appointments' => Appointment::count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'cancelled_appointments' => Appointment::where('status', 'cancelled')->count(),
        ];
        
        // Get recent applications (last 10)
        $recent_applications = ServiceApplication::with('user')
            ->latest()
            ->take(10)
            ->get();
        
        // Get pending appointments (upcoming)
        $pending_appointments = Appointment::with('user')
            ->where('status', 'confirmed')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date')
            ->take(10)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recent_applications', 'pending_appointments'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with('user');
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('rto_office') && $request->rto_office !== 'all') {
            $query->where('rto_office', $request->rto_office);
        }
        
        if ($request->has('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }
        
        $appointments = $query->orderBy('appointment_date')->paginate(20);
        
        return view('admin.appointments.index', compact('appointments'));
    }
    
    public function show(Appointment $appointment)
    {
        $appointment->load('user');
        return view('admin.appointments.show', compact('appointment'));
    }
    
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled,rescheduled,no_show',
            'reason' => 'required_if:status,cancelled|nullable|string',
        ]);
        
        $appointment->update([
            'status' => $validated['status'],
            'remarks' => $validated['reason'] ?? $appointment->remarks,
        ]);
        
        ActivityLog::create([
            'admin_id' => auth()->id(),
            'action_type' => 'appointment_status_change',
            'target_type' => 'Appointment',
            'target_id' => $appointment->id,
            'action_details' => json_encode([
                'booking_number' => $appointment->booking_number,
                'new_status' => $validated['status'],
            ]),
            'ip_address' => request()->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Appointment status updated');
    }
    
    public function reschedule(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after:today',
            'time_slot' => 'required|string',
            'reason' => 'required|string',
        ]);
        
        $old_date = $appointment->appointment_date;
        $old_time = $appointment->time_slot;
        
        $appointment->update([
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => $validated['time_slot'],
            'status' => 'rescheduled',
            'remarks' => $validated['reason'],
        ]);
        
        ActivityLog::create([
            'admin_id' => auth()->id(),
            'action_type' => 'appointment_reschedule',
            'target_type' => 'Appointment',
            'target_id' => $appointment->id,
            'action_details' => json_encode([
                'old_date' => $old_date,
                'old_time' => $old_time,
                'new_date' => $validated['appointment_date'],
                'new_time' => $validated['time_slot'],
            ]),
            'ip_address' => request()->ip(),
        ]);
        
        return redirect()->back()->with('success', 'Appointment rescheduled successfully');
    }
}

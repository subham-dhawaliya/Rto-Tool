<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.book');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|string',
            'application_number' => 'nullable|string',
            'rto_office' => 'required|string',
            'appointment_date' => 'required|date|after:today',
            'time_slot' => 'required|string',
        ]);

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'booking_number' => 'APT' . date('Ymd') . strtoupper(Str::random(6)),
            'service_type' => $validated['service_type'],
            'application_number' => $validated['application_number'],
            'rto_office' => $validated['rto_office'],
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => $validated['time_slot'],
            'status' => 'confirmed',
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully!');
    }

    public function show(Appointment $appointment)
    {
        abort_if($appointment->user_id !== auth()->id(), 403);
        return view('appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        abort_if($appointment->user_id !== auth()->id(), 403);
        $appointment->update(['status' => 'cancelled']);
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}

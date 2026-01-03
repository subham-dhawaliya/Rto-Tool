@extends('layouts.app')

@section('title', 'Appointment Details - RTO Portal')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Appointment Details</h1>
        <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
        </a>
    </div>

    <!-- Booking Confirmation Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <p class="text-gray-500">Booking Number</p>
                <p class="text-2xl font-bold text-blue-600">{{ $appointment->booking_number }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500 text-sm">Service Type</p>
                <p class="font-medium">{{ $appointment->service_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">RTO Office</p>
                <p class="font-medium">{{ $appointment->rto_office }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Appointment Date</p>
                <p class="font-medium text-lg">{{ $appointment->appointment_date->format('l, d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Time Slot</p>
                <p class="font-medium text-lg">{{ $appointment->time_slot }}</p>
            </div>
            @if($appointment->application_number)
            <div>
                <p class="text-gray-500 text-sm">Application Reference</p>
                <p class="font-medium">{{ $appointment->application_number }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- QR Code / Token -->
    @if($appointment->status == 'confirmed')
    <div class="bg-gray-50 rounded-lg p-6 mb-6 text-center">
        <p class="text-gray-600 mb-4">Show this booking number at the RTO counter</p>
        <div class="bg-white inline-block p-4 rounded-lg border-2 border-dashed border-gray-300">
            <p class="text-3xl font-mono font-bold">{{ $appointment->booking_number }}</p>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <button onclick="window.print()" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
            <i class="fas fa-print mr-2"></i>Print
        </button>
        @if($appointment->status == 'confirmed' && $appointment->appointment_date > now())
            <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                    <i class="fas fa-times mr-2"></i>Cancel Appointment
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
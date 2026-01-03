@extends('layouts.app')

@section('title', 'My Appointments - RTO Portal')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Appointments</h1>
        <a href="{{ route('appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Book New Appointment
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">RTO Office</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium">{{ $appointment->booking_number }}</td>
                        <td class="px-6 py-4 text-sm">{{ $appointment->service_name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $appointment->rto_office }}</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $appointment->appointment_date->format('d M Y') }}<br>
                            <span class="text-gray-500">{{ $appointment->time_slot }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                                @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:underline text-sm mr-3">View</a>
                            @if($appointment->status == 'confirmed' && $appointment->appointment_date > now())
                                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-calendar-times text-4xl mb-4"></i>
                            <p>No appointments found</p>
                            <a href="{{ route('appointments.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">Book your first appointment</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($appointments->hasPages())
        <div class="mt-6">{{ $appointments->links() }}</div>
    @endif
</div>
@endsection
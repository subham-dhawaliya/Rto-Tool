@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Appointments Management</h1>
    <p class="text-gray-600">View and manage all RTO appointments</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="all">All Status</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        
        <select name="rto_office" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="all">All RTO Offices</option>
            <option value="RTO Delhi Central">RTO Delhi Central</option>
            <option value="RTO Delhi East">RTO Delhi East</option>
        </select>
        
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2 border border-gray-300 rounded-lg">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Filter</button>
    </form>
</div>

<!-- Appointments Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($appointments as $appointment)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $appointment->booking_number }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $appointment->user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $appointment->service_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    {{ $appointment->appointment_date->format('M d, Y') }}<br>
                    <span class="text-xs text-gray-500">{{ $appointment->time_slot }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                        @if($appointment->status === 'confirmed') bg-blue-100 text-blue-700
                        @elseif($appointment->status === 'completed') bg-green-100 text-green-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-800">
                        View Details →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">No appointments found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">{{ $appointments->links() }}</div>
</div>
@endsection

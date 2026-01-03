@extends('layouts.app')

@section('title', 'Dashboard - RTO Portal')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Welcome, {{ auth()->user()->name }}!</h1>
    
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Applications</p>
                    <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Pending</p>
                    <p class="text-2xl font-bold">{{ $stats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Approved</p>
                    <p class="text-2xl font-bold">{{ $stats['approved'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-bell text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Notifications</p>
                    <p class="text-2xl font-bold">{{ $notifications->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <!-- Quick Actions -->
        <div class="md:col-span-2">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="{{ route('applications.create', 'learning-license') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                    <i class="fas fa-graduation-cap text-green-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Learning License</h3>
                        <p class="text-gray-500 text-sm">Apply for Learner's License</p>
                    </div>
                </a>
                <a href="{{ route('applications.create', 'driving-license') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                    <i class="fas fa-id-card text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Driving License</h3>
                        <p class="text-gray-500 text-sm">New, Renewal, Duplicate</p>
                    </div>
                </a>
                <a href="{{ route('applications.create', 'vehicle-registration') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                    <i class="fas fa-car text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Vehicle Registration</h3>
                        <p class="text-gray-500 text-sm">New Registration, Transfer</p>
                    </div>
                </a>
                <a href="{{ route('appointments.create') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                    <i class="fas fa-calendar-alt text-purple-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Book Appointment</h3>
                        <p class="text-gray-500 text-sm">Schedule RTO visit</p>
                    </div>
                </a>
                <a href="{{ route('applications.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                    <i class="fas fa-search text-orange-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">Track Applications</h3>
                        <p class="text-gray-500 text-sm">View all your applications</p>
                    </div>
                </a>
                <a href="{{ route('appointments.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                    <i class="fas fa-clock text-teal-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-semibold">My Appointments</h3>
                        <p class="text-gray-500 text-sm">View scheduled appointments</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Notifications -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Recent Notifications</h2>
            <div class="bg-white rounded-lg shadow">
                @forelse($notifications as $notification)
                    <div class="p-4 border-b last:border-b-0 {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                        <p class="text-sm">{{ $notification->data['message'] ?? 'New notification' }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="p-4 text-gray-500 text-center">
                        No notifications yet
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Recent Applications</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Application ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentApplications as $application)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $application->application_number }}</td>
                            <td class="px-6 py-4 text-sm">{{ $application->service_type }}</td>
                            <td class="px-6 py-4 text-sm">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($application->status == 'approved') bg-green-100 text-green-800
                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                    @elseif($application->status == 'processing') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('applications.show', $application) }}" class="text-blue-600 hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No applications yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

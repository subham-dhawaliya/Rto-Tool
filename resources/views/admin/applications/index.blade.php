@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Applications Management</h1>
    <p class="text-gray-600">Review and manage all RTO applications</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Status Filter -->
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="all">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <!-- Service Type Filter -->
        <select name="service_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="all">All Services</option>
            <option value="driving_license" {{ request('service_type') == 'driving_license' ? 'selected' : '' }}>Driving License</option>
            <option value="learning_license" {{ request('service_type') == 'learning_license' ? 'selected' : '' }}>Learning License</option>
            <option value="vehicle_registration" {{ request('service_type') == 'vehicle_registration' ? 'selected' : '' }}>Vehicle Registration</option>
        </select>

        <!-- Search -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by number or name..." 
               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-search mr-2"></i>Filter
        </button>
    </form>
</div>

<!-- Applications Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Application #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($applications as $application)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $application->application_number }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $application->user->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ ucwords(str_replace('_', ' ', $application->service_type)) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                        @if($application->status === 'pending') bg-orange-100 text-orange-700
                        @elseif($application->status === 'approved') bg-green-100 text-green-700
                        @elseif($application->status === 'rejected') bg-red-100 text-red-700
                        @else bg-blue-100 text-blue-700
                        @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $application->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('admin.applications.show', $application) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        View Details →
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    No applications found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $applications->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'My Applications - RTO Portal')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Applications</h1>
        <div class="flex space-x-2">
            <a href="{{ route('applications.create', 'driving-license') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>New Application
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form action="{{ route('applications.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div>
                <select name="status" class="border rounded-lg px-4 py-2">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <select name="service_type" class="border rounded-lg px-4 py-2">
                    <option value="">All Services</option>
                    <option value="learning-license" {{ request('service_type') == 'learning-license' ? 'selected' : '' }}>Learning License</option>
                    <option value="driving-license" {{ request('service_type') == 'driving-license' ? 'selected' : '' }}>Driving License</option>
                    <option value="vehicle-registration" {{ request('service_type') == 'vehicle-registration' ? 'selected' : '' }}>Vehicle Registration</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Filter</button>
            <a href="{{ route('applications.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Reset</a>
        </form>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Application ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied On</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Updated</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium">{{ $application->application_number }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucwords(str_replace('-', ' ', $application->service_type)) }}</td>
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
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $application->updated_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('applications.show', $application) }}" class="text-blue-600 hover:underline text-sm mr-3">View</a>
                            @if($application->status == 'pending')
                                <a href="{{ route('applications.edit', $application) }}" class="text-green-600 hover:underline text-sm">Edit</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-folder-open text-4xl mb-4"></i>
                            <p>No applications found</p>
                            <a href="{{ route('applications.create', 'driving-license') }}" class="text-blue-600 hover:underline mt-2 inline-block">Create your first application</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($applications->hasPages())
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection

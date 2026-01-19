@extends('admin.layout')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.applications.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
        ← Back to Applications
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
    <p class="text-gray-600">{{ $application->application_number }}</p>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
    <p class="text-green-700">{{ session('success') }}</p>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- User Information -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">User Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-medium">{{ $application->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $application->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">{{ $application->user->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Service Type</p>
                    <p class="font-medium">{{ ucwords(str_replace('_', ' ', $application->service_type)) }}</p>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Documents ({{ $application->documents->count() }})</h2>
            <div class="space-y-3">
                @forelse($application->documents as $document)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt text-gray-400 mr-3"></i>
                        <div>
                            <p class="font-medium">{{ $document->document_type }}</p>
                            <p class="text-xs text-gray-500">{{ $document->file_path }}</p>
                        </div>
                    </div>
                    @if($document->verification)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                        @if($document->verification->status === 'verified') bg-green-100 text-green-700
                        @elseif($document->verification->status === 'rejected') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($document->verification->status) }}
                    </span>
                    @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                        Pending
                    </span>
                    @endif
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">No documents uploaded</p>
                @endforelse
            </div>
        </div>

        <!-- Admin Remarks -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Admin Remarks</h2>
            
            <!-- Add Remark Form -->
            <form action="{{ route('admin.applications.remark', $application) }}" method="POST" class="mb-4">
                @csrf
                <textarea name="remark" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                          placeholder="Add a remark..."></textarea>
                <div class="flex items-center justify-between mt-2">
                    <select name="visibility" class="px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="public">Public (visible to user)</option>
                        <option value="internal">Internal (admin only)</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Add Remark
                    </button>
                </div>
            </form>

            <!-- Remarks List -->
            <div class="space-y-3">
                @forelse($application->remarks as $remark)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm">{{ $remark->remark }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                By {{ $remark->admin->name }} • {{ $remark->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $remark->visibility === 'internal' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($remark->visibility) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">No remarks yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Update -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>
            <form action="{{ route('admin.applications.status', $application) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3">
                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="under_review" {{ $application->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="on_hold" {{ $application->status === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                    <option value="requires_clarification" {{ $application->status === 'requires_clarification' ? 'selected' : '' }}>Requires Clarification</option>
                </select>
                
                <textarea name="reason" rows="3" placeholder="Reason (required for rejection)"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3"></textarea>
                
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Status History -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Status History</h2>
            <div class="space-y-3">
                @forelse($application->statusHistory as $history)
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ ucfirst($history->status) }}</p>
                        <p class="text-xs text-gray-500">{{ $history->created_at->format('M d, Y H:i') }}</p>
                        @if($history->remarks)
                        <p class="text-xs text-gray-600 mt-1">{{ $history->remarks }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">No history</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

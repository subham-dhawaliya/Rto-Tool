@extends('layouts.app')

@section('title', 'Application Details - RTO Portal')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Application Details</h1>
        <a href="{{ route('applications.index') }}" class="text-blue-600 hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Back to Applications
        </a>
    </div>

    <!-- Application Header Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <p class="text-gray-500 text-sm">Application Number</p>
                <p class="text-2xl font-bold text-blue-600">{{ $application->application_number }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($application->status == 'approved') bg-green-100 text-green-800
                @elseif($application->status == 'rejected') bg-red-100 text-red-800
                @elseif($application->status == 'processing') bg-blue-100 text-blue-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($application->status) }}
            </span>
        </div>
        <div class="grid md:grid-cols-4 gap-4 mt-6 pt-6 border-t">
            <div>
                <p class="text-gray-500 text-sm">Service Type</p>
                <p class="font-semibold">{{ $application->service_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Applied On</p>
                <p class="font-semibold">{{ $application->created_at->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Last Updated</p>
                <p class="font-semibold">{{ $application->updated_at->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Applicant</p>
                <p class="font-semibold">{{ $application->data['full_name'] ?? auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="md:col-span-2 space-y-6">
            <!-- Application Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>Application Information
                </h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($application->data ?? [] as $key => $value)
                        @if($value)
                        <div class="border-b pb-2">
                            <p class="text-gray-500 text-xs uppercase">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                            <p class="font-medium">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Uploaded Documents -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-folder-open text-blue-600 mr-2"></i>Uploaded Documents
                </h2>
                @if($application->documents && $application->documents->count() > 0)
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($application->documents as $document)
                    <div class="border rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-file text-blue-500"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $document->document_name }}</p>
                                <p class="text-gray-500 text-xs">{{ number_format($document->file_size / 1024, 1) }} KB</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($document->status == 'verified') bg-green-100 text-green-700
                            @elseif($document->status == 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($document->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">No documents uploaded</p>
                @endif
            </div>
        </div>

        <!-- Right Column - Timeline -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-history text-blue-600 mr-2"></i>Application Timeline
                </h2>
                <div class="space-y-4">
                    @forelse($application->statusHistory ?? [] as $history)
                    <div class="flex">
                        <div class="flex flex-col items-center mr-4">
                            <div class="w-3 h-3 rounded-full 
                                @if($history->status == 'approved') bg-green-500
                                @elseif($history->status == 'rejected') bg-red-500
                                @else bg-blue-500 @endif"></div>
                            @if(!$loop->last)
                            <div class="w-0.5 h-full bg-gray-200 mt-1"></div>
                            @endif
                        </div>
                        <div class="pb-4">
                            <p class="font-medium text-sm">{{ $history->status_label }}</p>
                            @if($history->remarks)
                            <p class="text-gray-500 text-xs">{{ $history->remarks }}</p>
                            @endif
                            <p class="text-gray-400 text-xs mt-1">{{ $history->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center">No status updates</p>
                    @endforelse
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    @if($application->status == 'pending')
                    <a href="{{ route('applications.edit', $application) }}" 
                       class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>Edit Application
                    </a>
                    @endif
                    <button onclick="window.print()" 
                            class="block w-full text-center border py-2 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i>Print Details
                    </button>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">Need Help?</h3>
                <p class="text-blue-700 text-sm"><i class="fas fa-phone mr-1"></i> 1800-XXX-XXXX</p>
                <p class="text-blue-700 text-sm"><i class="fas fa-envelope mr-1"></i> support@rtoportal.gov.in</p>
            </div>
        </div>
    </div>
</div>
@endsection

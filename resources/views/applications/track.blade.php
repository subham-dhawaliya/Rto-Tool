@extends('layouts.app')

@section('title', 'Track Application - RTO Portal')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Track Your Application</h1>
    <p class="text-gray-600 mb-8 text-center">Enter your application number to check the status</p>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('applications.track') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="application_number" 
                       value="{{ request('application_number') }}"
                       placeholder="Enter Application Number (e.g., RTO2024XXXXXXXX)"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 text-lg"
                       required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                <i class="fas fa-search mr-2"></i>Track
            </button>
        </form>
    </div>

    @if(request('application_number'))
        @if($application)
        <!-- Application Found -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-200 text-sm">Application Number</p>
                        <p class="text-2xl font-bold">{{ $application->application_number }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($application->status == 'approved') bg-green-500
                        @elseif($application->status == 'rejected') bg-red-500
                        @elseif($application->status == 'processing') bg-yellow-500
                        @else bg-gray-500 @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
            </div>

            <!-- Details -->
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-6 mb-8">
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
                        <p class="font-semibold">{{ $application->updated_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>

                <!-- Status Timeline -->
                <h3 class="font-semibold text-lg mb-4 border-b pb-2">Application Progress</h3>
                
                <!-- Progress Bar -->
                <div class="mb-8">
                    @php
                        $stages = ['pending', 'processing', 'approved'];
                        $currentIndex = array_search($application->status, $stages);
                        if($currentIndex === false) $currentIndex = 0;
                        $progress = (($currentIndex + 1) / count($stages)) * 100;
                    @endphp
                    <div class="flex justify-between mb-2">
                        <span class="text-sm {{ $application->status != 'rejected' ? 'text-green-600 font-semibold' : 'text-gray-500' }}">Submitted</span>
                        <span class="text-sm {{ in_array($application->status, ['processing', 'approved']) ? 'text-green-600 font-semibold' : 'text-gray-500' }}">Processing</span>
                        <span class="text-sm {{ $application->status == 'approved' ? 'text-green-600 font-semibold' : 'text-gray-500' }}">Completed</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="h-3 rounded-full transition-all duration-500
                            @if($application->status == 'rejected') bg-red-500
                            @else bg-green-500 @endif" 
                            style="width: {{ $application->status == 'rejected' ? '100' : $progress }}%"></div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="space-y-4">
                    @forelse($application->statusHistory ?? [] as $history)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mr-4
                            @if($history->status == 'approved') bg-green-100 text-green-600
                            @elseif($history->status == 'rejected') bg-red-100 text-red-600
                            @else bg-blue-100 text-blue-600 @endif">
                            @if($history->status == 'approved')
                                <i class="fas fa-check"></i>
                            @elseif($history->status == 'rejected')
                                <i class="fas fa-times"></i>
                            @else
                                <i class="fas fa-clock"></i>
                            @endif
                        </div>
                        <div class="flex-1 border-b pb-4">
                            <p class="font-semibold">{{ $history->status_label }}</p>
                            @if($history->remarks)
                            <p class="text-gray-600 text-sm">{{ $history->remarks }}</p>
                            @endif
                            <p class="text-gray-400 text-xs mt-1">{{ $history->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <p class="font-semibold">Application Submitted</p>
                            <p class="text-gray-400 text-xs mt-1">{{ $application->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Documents Status -->
                @if($application->documents && $application->documents->count() > 0)
                <div class="mt-8 pt-6 border-t">
                    <h3 class="font-semibold text-lg mb-4">Document Verification Status</h3>
                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach($application->documents as $doc)
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                            <span class="text-sm">{{ $doc->document_name }}</span>
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($doc->status == 'verified') bg-green-100 text-green-700
                                @elseif($doc->status == 'rejected') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($doc->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <!-- Application Not Found -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-8 text-center">
            <i class="fas fa-exclamation-circle text-red-500 text-5xl mb-4"></i>
            <h3 class="text-xl font-semibold text-red-800 mb-2">Application Not Found</h3>
            <p class="text-red-600">No application found with number: {{ request('application_number') }}</p>
            <p class="text-gray-600 mt-2">Please check the application number and try again.</p>
        </div>
        @endif
    @endif

    <!-- Help Section -->
    <div class="mt-8 bg-gray-50 rounded-lg p-6">
        <h3 class="font-semibold mb-4">Where to find your Application Number?</h3>
        <ul class="text-gray-600 space-y-2 text-sm">
            <li><i class="fas fa-check text-green-500 mr-2"></i>Check your email for application confirmation</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i>Login to your account and view "My Applications"</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i>Check SMS sent to your registered mobile number</li>
        </ul>
    </div>
</div>
@endsection

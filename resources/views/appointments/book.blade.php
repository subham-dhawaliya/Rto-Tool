@extends('layouts.app')

@section('title', 'Book Appointment - RTO Portal')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Book Appointment</h1>
    <p class="text-gray-600 mb-8">Schedule your visit to the RTO office</p>

    <form action="{{ route('appointments.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <!-- Service Selection -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Select Service</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="service_type" value="ll_test" class="mr-2" required>
                    <span class="font-medium">Learning License Test</span>
                    <p class="text-gray-500 text-sm mt-1">Online/Offline LL test slot</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="service_type" value="dl_test" class="mr-2">
                    <span class="font-medium">Driving Test</span>
                    <p class="text-gray-500 text-sm mt-1">Permanent license driving test</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="service_type" value="vehicle_inspection" class="mr-2">
                    <span class="font-medium">Vehicle Inspection</span>
                    <p class="text-gray-500 text-sm mt-1">New registration inspection</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="service_type" value="document_verification" class="mr-2">
                    <span class="font-medium">Document Verification</span>
                    <p class="text-gray-500 text-sm mt-1">Original document verification</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="service_type" value="fitness_test" class="mr-2">
                    <span class="font-medium">Fitness Test</span>
                    <p class="text-gray-500 text-sm mt-1">Vehicle fitness certificate</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="service_type" value="other" class="mr-2">
                    <span class="font-medium">Other Services</span>
                    <p class="text-gray-500 text-sm mt-1">General enquiry/services</p>
                </label>
            </div>
        </div>

        <!-- Application Reference (Optional) -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Application Reference (if any)</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Application Number</label>
                    <input type="text" name="application_number" value="{{ old('application_number') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g., RTO2024XXXXXXXX">
                </div>
            </div>
        </div>

        <!-- RTO Selection -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Select RTO Office</h2>
            <div>
                <label class="block text-gray-700 font-medium mb-2">RTO Office</label>
                <select name="rto_office" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Select RTO Office</option>
                    <option value="MH01">MH01 - Mumbai Central RTO</option>
                    <option value="MH02">MH02 - Mumbai West RTO</option>
                    <option value="MH03">MH03 - Mumbai East RTO</option>
                    <option value="MH04">MH04 - Thane RTO</option>
                    <option value="MH12">MH12 - Pune RTO</option>
                    <option value="MH14">MH14 - Pimpri-Chinchwad RTO</option>
                </select>
            </div>
        </div>

        <!-- Date & Time Selection -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Select Date & Time</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Appointment Date</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Appointments available for next 30 days</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Time Slot</label>
                    <select name="time_slot" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Time Slot</option>
                        <option value="09:00-09:30">09:00 AM - 09:30 AM</option>
                        <option value="09:30-10:00">09:30 AM - 10:00 AM</option>
                        <option value="10:00-10:30">10:00 AM - 10:30 AM</option>
                        <option value="10:30-11:00">10:30 AM - 11:00 AM</option>
                        <option value="11:00-11:30">11:00 AM - 11:30 AM</option>
                        <option value="11:30-12:00">11:30 AM - 12:00 PM</option>
                        <option value="14:00-14:30">02:00 PM - 02:30 PM</option>
                        <option value="14:30-15:00">02:30 PM - 03:00 PM</option>
                        <option value="15:00-15:30">03:00 PM - 03:30 PM</option>
                        <option value="15:30-16:00">03:30 PM - 04:00 PM</option>
                        <option value="16:00-16:30">04:00 PM - 04:30 PM</option>
                        <option value="16:30-17:00">04:30 PM - 05:00 PM</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Important Instructions -->
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
            <h3 class="font-semibold text-yellow-800 mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Important Instructions</h3>
            <ul class="text-yellow-700 text-sm space-y-1">
                <li>• Please arrive 15 minutes before your scheduled time</li>
                <li>• Carry all original documents along with photocopies</li>
                <li>• Carry a valid ID proof (Aadhaar/PAN/Passport)</li>
                <li>• For driving test, bring a vehicle with valid documents</li>
                <li>• Appointment can be cancelled up to 24 hours before the scheduled time</li>
            </ul>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-calendar-check mr-2"></i>Book Appointment
            </button>
        </div>
    </form>
</div>
@endsection
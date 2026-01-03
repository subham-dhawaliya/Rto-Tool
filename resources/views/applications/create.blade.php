@extends('layouts.app')

@section('title', 'Apply for ' . ucwords(str_replace('-', ' ', $serviceType)) . ' - RTO Portal')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Apply for {{ ucwords(str_replace('-', ' ', $serviceType)) }}</h1>
    <p class="text-gray-600 mb-8">Fill in the details below to submit your application</p>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        <input type="hidden" name="service_type" value="{{ $serviceType }}">

        <!-- Personal Information -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Personal Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Father's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gender</label>
                    <select name="gender" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Address -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Address Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Address</label>
                    <textarea name="address" rows="2" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">PIN Code</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" required pattern="[0-9]{6}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        @if($serviceType == 'driving-license')
        <!-- License Specific -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">License Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Application Type</label>
                    <select name="application_subtype" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Type</option>
                        <option value="new">New License</option>
                        <option value="renewal">Renewal</option>
                        <option value="duplicate">Duplicate</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Vehicle Class</label>
                    <select name="vehicle_class" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Class</option>
                        <option value="LMV">LMV (Light Motor Vehicle)</option>
                        <option value="MCWG">MCWG (Motorcycle with Gear)</option>
                        <option value="MCWOG">MCWOG (Motorcycle without Gear)</option>
                        <option value="HMV">HMV (Heavy Motor Vehicle)</option>
                    </select>
                </div>
            </div>
        </div>
        @endif

        @if($serviceType == 'vehicle-registration')
        <!-- Vehicle Specific -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Vehicle Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Vehicle Type</label>
                    <select name="vehicle_type" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Type</option>
                        <option value="two-wheeler">Two Wheeler</option>
                        <option value="four-wheeler">Four Wheeler</option>
                        <option value="commercial">Commercial Vehicle</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Manufacturer</label>
                    <input type="text" name="manufacturer" value="{{ old('manufacturer') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Model</label>
                    <input type="text" name="model" value="{{ old('model') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Chassis Number</label>
                    <input type="text" name="chassis_number" value="{{ old('chassis_number') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Engine Number</label>
                    <input type="text" name="engine_number" value="{{ old('engine_number') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
        @endif

        <!-- Documents -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Upload Documents</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">ID Proof (Aadhaar/PAN)</label>
                    <input type="file" name="id_proof" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Address Proof</label>
                    <input type="file" name="address_proof" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Passport Photo</label>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Declaration -->
        <div class="mb-6">
            <label class="flex items-start">
                <input type="checkbox" name="declaration" required class="mt-1 mr-2">
                <span class="text-gray-600 text-sm">I hereby declare that all the information provided is true and correct to the best of my knowledge.</span>
            </label>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Submit Application
            </button>
        </div>
    </form>
</div>
@endsection

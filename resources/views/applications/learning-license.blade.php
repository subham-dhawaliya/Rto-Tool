@extends('layouts.app')

@section('title', 'Learning License Application - RTO Portal')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Learning License Application</h1>
    <p class="text-gray-600 mb-8">Apply for learner's license - First step towards driving license</p>

    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
        <p class="text-blue-700"><i class="fas fa-info-circle mr-2"></i>Learning License is valid for 6 months. You can apply for permanent license after 30 days.</p>
    </div>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        <input type="hidden" name="service_type" value="learning-license">

        <!-- Personal Information -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Personal Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Full Name (as per Aadhaar)</label>
                    <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" required max="{{ date('Y-m-d', strtotime('-16 years')) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Minimum age: 16 years for non-gear, 18 years for gear vehicles</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Father's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gender</label>
                    <select name="gender" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Blood Group</label>
                    <select name="blood_group" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option><option value="A-">A-</option>
                        <option value="B+">B+</option><option value="B-">B-</option>
                        <option value="O+">O+</option><option value="O-">O-</option>
                        <option value="AB+">AB+</option><option value="AB-">AB-</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Mobile Number</label>
                    <input type="tel" name="mobile" value="{{ old('mobile', auth()->user()->phone) }}" required pattern="[0-9]{10}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Aadhaar Number</label>
                    <input type="text" name="aadhaar" value="{{ old('aadhaar') }}" required pattern="[0-9]{12}" maxlength="12"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Vehicle Class Selection -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Vehicle Class (Select all that apply)</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition flex items-start">
                    <input type="checkbox" name="vehicle_class[]" value="MCWOG" class="mt-1 mr-3">
                    <div>
                        <span class="font-medium">MCWOG</span>
                        <p class="text-gray-500 text-sm">Motorcycle Without Gear (Scooty/Activa) - Age 16+</p>
                    </div>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition flex items-start">
                    <input type="checkbox" name="vehicle_class[]" value="MCWG" class="mt-1 mr-3">
                    <div>
                        <span class="font-medium">MCWG</span>
                        <p class="text-gray-500 text-sm">Motorcycle With Gear - Age 18+</p>
                    </div>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition flex items-start">
                    <input type="checkbox" name="vehicle_class[]" value="LMV" class="mt-1 mr-3">
                    <div>
                        <span class="font-medium">LMV</span>
                        <p class="text-gray-500 text-sm">Light Motor Vehicle (Car) - Age 18+</p>
                    </div>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition flex items-start">
                    <input type="checkbox" name="vehicle_class[]" value="LMV-TR" class="mt-1 mr-3">
                    <div>
                        <span class="font-medium">LMV-TR</span>
                        <p class="text-gray-500 text-sm">Light Motor Vehicle Transport - Age 20+</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Address -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Address Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Present Address</label>
                    <textarea name="address" rows="2" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">City/District</label>
                    <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">PIN Code</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" required pattern="[0-9]{6}" maxlength="6"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">RTO Office</label>
                    <select name="rto_office" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select RTO</option>
                        <option value="MH01">MH01 - Mumbai Central</option>
                        <option value="MH02">MH02 - Mumbai West</option>
                        <option value="MH03">MH03 - Mumbai East</option>
                        <option value="MH04">MH04 - Thane</option>
                        <option value="MH12">MH12 - Pune</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Documents Upload -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Upload Documents</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Aadhaar Card (Front & Back)</label>
                    <input type="file" name="aadhaar_doc" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Address Proof</label>
                    <input type="file" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Passport Size Photo</label>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Signature</label>
                    <input type="file" name="signature" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            <p class="text-gray-500 text-sm mt-2"><i class="fas fa-info-circle mr-1"></i>Accepted formats: PDF, JPG, PNG (Max 2MB each)</p>
        </div>

        <!-- Declaration -->
        <div class="mb-6">
            <label class="flex items-start">
                <input type="checkbox" name="declaration" required class="mt-1 mr-2">
                <span class="text-gray-600 text-sm">I hereby declare that all information provided is true and correct. I understand that providing false information is punishable under law.</span>
            </label>
        </div>

        <!-- Fee Info -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="font-semibold mb-2">Application Fee</h3>
            <p class="text-gray-600">Learning License Fee: ₹200 (per vehicle class)</p>
            <p class="text-gray-500 text-sm">Payment will be collected after application verification</p>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-paper-plane mr-2"></i>Submit Application
            </button>
        </div>
    </form>
</div>
@endsection
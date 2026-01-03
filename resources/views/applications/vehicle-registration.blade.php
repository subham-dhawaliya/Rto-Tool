@extends('layouts.app')

@section('title', 'Vehicle Registration - RTO Portal')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Vehicle Registration</h1>
    <p class="text-gray-600 mb-8">Register your new vehicle or transfer ownership</p>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        <input type="hidden" name="service_type" value="vehicle-registration">

        <!-- Registration Type -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Registration Type</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="registration_type" value="new" class="mr-2" required>
                    <span class="font-medium">New Vehicle</span>
                    <p class="text-gray-500 text-sm mt-1">Brand new vehicle registration</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="registration_type" value="transfer" class="mr-2">
                    <span class="font-medium">Transfer</span>
                    <p class="text-gray-500 text-sm mt-1">Ownership transfer</p>
                </label>
                <label class="border rounded-lg p-4 cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="registration_type" value="re-registration" class="mr-2">
                    <span class="font-medium">Re-Registration</span>
                    <p class="text-gray-500 text-sm mt-1">From another state</p>
                </label>
            </div>
        </div>

        <!-- Owner Information -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Owner Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Owner Name</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', auth()->user()->name) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Father's/Husband's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
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
                <div>
                    <label class="block text-gray-700 font-medium mb-2">PAN Number</label>
                    <input type="text" name="pan" value="{{ old('pan') }}" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 uppercase" placeholder="ABCDE1234F">
                </div>
            </div>
        </div>

        <!-- Vehicle Details -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Vehicle Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Vehicle Category</label>
                    <select name="vehicle_category" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        <option value="two_wheeler">Two Wheeler</option>
                        <option value="three_wheeler">Three Wheeler</option>
                        <option value="four_wheeler">Four Wheeler (Private)</option>
                        <option value="commercial">Commercial Vehicle</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Fuel Type</label>
                    <select name="fuel_type" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Fuel Type</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        <option value="cng">CNG</option>
                        <option value="electric">Electric</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Manufacturer</label>
                    <input type="text" name="manufacturer" value="{{ old('manufacturer') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g., Maruti, Honda">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Model</label>
                    <input type="text" name="model" value="{{ old('model') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g., Swift, City">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Variant</label>
                    <input type="text" name="variant" value="{{ old('variant') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g., VXI, ZX">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Chassis Number</label>
                    <input type="text" name="chassis_number" value="{{ old('chassis_number') }}" required maxlength="17"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 uppercase">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Engine Number</label>
                    <input type="text" name="engine_number" value="{{ old('engine_number') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 uppercase">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Manufacturing Year</label>
                    <select name="mfg_year" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Year</option>
                        @for($y = date('Y'); $y >= 2000; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Seating Capacity</label>
                    <input type="number" name="seating_capacity" value="{{ old('seating_capacity') }}" min="1" max="50"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
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

        <!-- Insurance Details -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Insurance Details</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Insurance Company</label>
                    <input type="text" name="insurance_company" value="{{ old('insurance_company') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Policy Number</label>
                    <input type="text" name="policy_number" value="{{ old('policy_number') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Valid From</label>
                    <input type="date" name="insurance_from" value="{{ old('insurance_from') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Valid To</label>
                    <input type="date" name="insurance_to" value="{{ old('insurance_to') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Documents Upload -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b">Upload Documents</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Sale Invoice</label>
                    <input type="file" name="sale_invoice" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Insurance Certificate</label>
                    <input type="file" name="insurance_doc" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">PUC Certificate</label>
                    <input type="file" name="puc_doc" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Aadhaar Card</label>
                    <input type="file" name="aadhaar_doc" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Address Proof</label>
                    <input type="file" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Form 20 (Sale Certificate)</label>
                    <input type="file" name="form_20" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>

        <!-- Declaration -->
        <div class="mb-6">
            <label class="flex items-start">
                <input type="checkbox" name="declaration" required class="mt-1 mr-2">
                <span class="text-gray-600 text-sm">I hereby declare that all information provided is true and correct. I understand that providing false information is punishable under law.</span>
            </label>
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
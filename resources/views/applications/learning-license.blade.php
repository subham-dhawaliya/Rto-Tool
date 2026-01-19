@extends('layouts.app')

@section('title', 'Learning License Application - RTO Portal')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-teal-700 text-white rounded-t-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Learning License Application</h1>
                <p class="text-green-100 mt-2">Form 2 - Application for Learner's License</p>
            </div>
            <div class="hidden md:block bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                <i class="fas fa-graduation-cap text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="bg-green-50 border-l-4 border-green-500 p-4 flex items-start">
        <i class="fas fa-info-circle text-green-600 mt-1 mr-3"></i>
        <div>
            <p class="text-green-800 font-medium">Important Information</p>
            <p class="text-green-700 text-sm">Learning License is valid for 6 months. You can apply for permanent Driving License after 30 days of LL issue date.</p>
        </div>
    </div>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" id="llForm">
        @csrf
        <input type="hidden" name="service_type" value="learning-license">

        <!-- SECTION A: Applicant Type -->
        <div class="bg-white rounded-lg shadow mb-6 mt-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">A</span>
                    Applicant Category
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition text-center {{ old('applicant_type', 'fresh') == 'fresh' ? 'border-green-500 bg-green-50' : '' }}">
                        <input type="radio" name="applicant_type" value="fresh" class="hidden" {{ old('applicant_type', 'fresh') == 'fresh' ? 'checked' : '' }}>
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                        </div>
                        <p class="font-semibold">Fresh Application</p>
                        <p class="text-gray-500 text-xs mt-1">First time applicant</p>
                    </label>
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition text-center {{ old('applicant_type') == 'retest' ? 'border-green-500 bg-green-50' : '' }}">
                        <input type="radio" name="applicant_type" value="retest" class="hidden" {{ old('applicant_type') == 'retest' ? 'checked' : '' }}>
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-redo text-orange-600 text-2xl"></i>
                        </div>
                        <p class="font-semibold">Re-test</p>
                        <p class="text-gray-500 text-xs mt-1">Failed in previous test</p>
                    </label>
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition text-center {{ old('applicant_type') == 'additional' ? 'border-green-500 bg-green-50' : '' }}">
                        <input type="radio" name="applicant_type" value="additional" class="hidden" {{ old('applicant_type') == 'additional' ? 'checked' : '' }}>
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-plus-circle text-blue-600 text-2xl"></i>
                        </div>
                        <p class="font-semibold">Additional Class</p>
                        <p class="text-gray-500 text-xs mt-1">Already have LL, adding class</p>
                    </label>
                </div>
            </div>
        </div>

        <!-- SECTION B: Personal Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">B</span>
                    Personal Details
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Full Name -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Full Name <span class="text-red-500">*</span>
                            <span class="text-gray-400 text-xs font-normal">(As per Aadhaar)</span>
                        </label>
                        <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Enter your full name">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="dob" value="{{ old('dob') }}" required 
                            max="{{ date('Y-m-d', strtotime('-16 years')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-gray-400 text-xs mt-1">Min age: 16 (non-gear), 18 (gear)</p>
                    </div>

                    <!-- Father's Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Father's Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="father_name" value="{{ old('father_name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Father's full name">
                    </div>

                    <!-- Mother's Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Mother's Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Mother's full name">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="transgender" {{ old('gender') == 'transgender' ? 'selected' : '' }}>Transgender</option>
                        </select>
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Blood Group <span class="text-red-500">*</span>
                        </label>
                        <select name="blood_group" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select Blood Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Place of Birth -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Place of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="City/Town">
                    </div>

                    <!-- Qualification -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Educational Qualification <span class="text-red-500">*</span>
                        </label>
                        <select name="qualification" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select Qualification</option>
                            <option value="illiterate">Illiterate</option>
                            <option value="below_8th">Below 8th</option>
                            <option value="8th_pass">8th Pass</option>
                            <option value="10th_pass">10th Pass</option>
                            <option value="12th_pass">12th Pass</option>
                            <option value="graduate">Graduate</option>
                            <option value="post_graduate">Post Graduate</option>
                        </select>
                    </div>

                    <!-- Identification Marks -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Identification Mark 1 <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="identification_mark_1" value="{{ old('identification_mark_1') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="e.g., Mole on right cheek">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Identification Mark 2
                        </label>
                        <input type="text" name="identification_mark_2" value="{{ old('identification_mark_2') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="e.g., Scar on left hand">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION C: Contact Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">C</span>
                    Contact Details
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Mobile -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <span class="inline-flex items-center px-4 bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl text-gray-600">+91</span>
                            <input type="tel" name="mobile" value="{{ old('mobile', auth()->user()->phone) }}" required 
                                pattern="[0-9]{10}" maxlength="10"
                                class="w-full px-4 py-3 border border-gray-300 rounded-r-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="10 digit mobile">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="email@example.com">
                    </div>

                    <!-- Aadhaar -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Aadhaar Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="aadhaar" value="{{ old('aadhaar') }}" required 
                            pattern="[0-9]{12}" maxlength="12"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="12 digit Aadhaar">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION D: Address Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">D</span>
                    Address Details
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="md:col-span-3">
                        <label class="block text-gray-700 font-medium mb-2">
                            House No./Building/Street <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address_line1" value="{{ old('address_line1') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="House/Flat No., Building Name, Street">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Locality/Area <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address_line2" value="{{ old('address_line2') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Locality, Area">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Landmark</label>
                        <input type="text" name="landmark" value="{{ old('landmark') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Near landmark">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            City/Town <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="City/Town">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            District <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="district" value="{{ old('district') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="District">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            State <span class="text-red-500">*</span>
                        </label>
                        <select name="state" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Select State</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Telangana">Telangana</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            PIN Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pincode" value="{{ old('pincode') }}" required
                            pattern="[0-9]{6}" maxlength="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="6 digit PIN">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION E: Vehicle Class Selection -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">E</span>
                    Vehicle Class Selection
                </h2>
                <p class="text-gray-500 text-sm mt-1">Select the vehicle categories you want to learn</p>
            </div>
            <div class="p-6">
                <!-- Age Eligibility Info -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                    <h4 class="font-medium text-yellow-800 mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Age Eligibility</h4>
                    <div class="grid md:grid-cols-3 gap-4 text-sm text-yellow-700">
                        <div><i class="fas fa-check mr-1"></i> 16+ years: Non-gear two wheeler</div>
                        <div><i class="fas fa-check mr-1"></i> 18+ years: Gear vehicles, LMV</div>
                        <div><i class="fas fa-check mr-1"></i> 20+ years: Transport vehicles</div>
                    </div>
                </div>

                <!-- Two Wheeler -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-motorcycle text-green-600 mr-2"></i> Two Wheeler
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition flex items-center">
                            <input type="checkbox" name="vehicle_class[]" value="MCWOG" class="w-5 h-5 text-green-600 rounded mr-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">MCWOG</span>
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Age 16+</span>
                                </div>
                                <p class="text-gray-500 text-sm">Motorcycle Without Gear (Scooty/Activa)</p>
                            </div>
                        </label>
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition flex items-center">
                            <input type="checkbox" name="vehicle_class[]" value="MCWG" class="w-5 h-5 text-green-600 rounded mr-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">MCWG</span>
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Age 18+</span>
                                </div>
                                <p class="text-gray-500 text-sm">Motorcycle With Gear (Bike)</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Four Wheeler -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-car text-blue-600 mr-2"></i> Four Wheeler
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition flex items-center">
                            <input type="checkbox" name="vehicle_class[]" value="LMV" class="w-5 h-5 text-green-600 rounded mr-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">LMV</span>
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Age 18+</span>
                                </div>
                                <p class="text-gray-500 text-sm">Light Motor Vehicle (Car/Jeep)</p>
                            </div>
                        </label>
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition flex items-center">
                            <input type="checkbox" name="vehicle_class[]" value="LMV-NT" class="w-5 h-5 text-green-600 rounded mr-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">LMV-NT</span>
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Age 18+</span>
                                </div>
                                <p class="text-gray-500 text-sm">LMV Non-Transport (Private Car)</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Transport -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-truck text-orange-600 mr-2"></i> Transport Vehicles
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition flex items-center">
                            <input type="checkbox" name="vehicle_class[]" value="LMV-TR" class="w-5 h-5 text-green-600 rounded mr-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">LMV-TR</span>
                                    <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full">Age 20+</span>
                                </div>
                                <p class="text-gray-500 text-sm">LMV Transport (Taxi/Commercial)</p>
                            </div>
                        </label>
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-green-500 transition flex items-center">
                            <input type="checkbox" name="vehicle_class[]" value="HMV" class="w-5 h-5 text-green-600 rounded mr-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">HMV</span>
                                    <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full">Age 20+</span>
                                </div>
                                <p class="text-gray-500 text-sm">Heavy Motor Vehicle (Truck/Bus)</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- RTO Selection -->
                <div class="mt-6 pt-6 border-t">
                    <label class="block text-gray-700 font-medium mb-2">
                        Select RTO Office <span class="text-red-500">*</span>
                    </label>
                    <select name="rto_office" required class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select RTO Office</option>
                        <optgroup label="Maharashtra">
                            <option value="MH01">MH01 - Mumbai Central</option>
                            <option value="MH02">MH02 - Mumbai West</option>
                            <option value="MH03">MH03 - Mumbai East</option>
                            <option value="MH04">MH04 - Thane</option>
                            <option value="MH12">MH12 - Pune</option>
                            <option value="MH14">MH14 - Pimpri-Chinchwad</option>
                        </optgroup>
                        <optgroup label="Gujarat">
                            <option value="GJ01">GJ01 - Ahmedabad</option>
                            <option value="GJ05">GJ05 - Surat</option>
                        </optgroup>
                        <optgroup label="Karnataka">
                            <option value="KA01">KA01 - Bangalore Central</option>
                            <option value="KA02">KA02 - Bangalore West</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION F: Document Uploads -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">F</span>
                    Document Uploads
                </h2>
                <p class="text-gray-500 text-sm mt-1">Upload clear scanned copies (PDF/JPG/PNG, Max 2MB each)</p>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Photo -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-green-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-user text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Passport Size Photo <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Recent photo, white background</p>
                                </div>
                            </div>
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                        </label>
                    </div>

                    <!-- Signature -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-green-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-signature text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Signature <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Sign on white paper</p>
                                </div>
                            </div>
                            <input type="file" name="signature" accept=".jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                        </label>
                    </div>

                    <!-- Aadhaar Card -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-green-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-orange-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-id-card text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Aadhaar Card <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Front & back in single file</p>
                                </div>
                            </div>
                            <input type="file" name="aadhaar_doc" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200">
                        </label>
                    </div>

                    <!-- Address Proof -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-green-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-purple-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-home text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Address Proof <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Electricity bill/Passport/Voter ID</p>
                                </div>
                            </div>
                            <input type="file" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                        </label>
                    </div>

                    <!-- Age Proof -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-green-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-teal-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-birthday-cake text-teal-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Age/DOB Proof <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Birth Certificate/10th Marksheet</p>
                                </div>
                            </div>
                            <input type="file" name="age_proof" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200">
                        </label>
                    </div>

                    <!-- Medical Certificate (for transport) -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-green-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-notes-medical text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Medical Certificate</p>
                                    <p class="text-gray-500 text-xs">Required for transport vehicles</p>
                                </div>
                            </div>
                            <input type="file" name="medical_cert" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-100 file:text-red-700 hover:file:bg-red-200">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION G: Declaration -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-sm mr-2">G</span>
                    Declaration
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-xl p-4 mb-4 max-h-40 overflow-y-auto text-sm text-gray-700 border">
                    <p class="mb-2">I hereby declare that:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>All information provided is true and correct to the best of my knowledge.</li>
                        <li>I am not disqualified for holding a learner's license under Motor Vehicles Act, 1988.</li>
                        <li>I do not suffer from any disease or disability that may affect my driving ability.</li>
                        <li>I have not been convicted of any offense under the Motor Vehicles Act.</li>
                        <li>I understand that providing false information is punishable under law.</li>
                    </ol>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center cursor-pointer p-3 border rounded-xl hover:bg-gray-50">
                        <input type="checkbox" name="declaration" required class="w-5 h-5 text-green-600 rounded mr-3">
                        <span class="text-gray-700">I confirm that all information provided is true and I accept the terms. <span class="text-red-500">*</span></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Fee Summary -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-rupee-sign text-green-600 mr-2"></i>Fee Summary
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Application Fee</span>
                        <span class="font-medium">₹ 150.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">LL Test Fee (per class)</span>
                        <span class="font-medium">₹ 50.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Service Charge</span>
                        <span class="font-medium">₹ 30.00</span>
                    </div>
                    <div class="flex justify-between py-3 bg-green-50 px-3 rounded-lg">
                        <span class="font-semibold text-gray-800">Estimated Total</span>
                        <span class="font-bold text-green-600 text-lg">₹ 230.00*</span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    *Fee varies based on vehicle classes selected. Payment after document verification.
                </p>
            </div>
        </div>

        <!-- Submit Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-gray-600 text-sm">
                    <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                    Your data is secure and encrypted
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 font-medium">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-xl hover:from-green-700 hover:to-teal-700 font-semibold shadow-lg shadow-green-500/30">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Application
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Radio button styling
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                r.closest('label').classList.remove('border-green-500', 'bg-green-50');
            });
            if (this.checked) {
                this.closest('label').classList.add('border-green-500', 'bg-green-50');
            }
        });
    });

    // Checkbox styling
    document.querySelectorAll('input[type="checkbox"][name="vehicle_class[]"]').forEach(cb => {
        cb.addEventListener('change', function() {
            if (this.checked) {
                this.closest('label').classList.add('border-green-500', 'bg-green-50');
            } else {
                this.closest('label').classList.remove('border-green-500', 'bg-green-50');
            }
        });
    });
</script>
@endsection

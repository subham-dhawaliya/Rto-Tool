@extends('layouts.app')

@section('title', 'Driving License Application - RTO Portal')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white rounded-t-lg p-6">
        <h1 class="text-3xl font-bold">Driving License Application</h1>
        <p class="text-blue-200 mt-2">Form 4 - Application for Driving License</p>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white border-x border-b p-4 mb-6">
        <div class="flex justify-between items-center max-w-3xl mx-auto">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                <span class="text-xs mt-1 text-blue-600 font-medium">Personal</span>
            </div>
            <div class="flex-1 h-1 bg-blue-200 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-blue-200 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                <span class="text-xs mt-1 text-gray-500">Contact</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                <span class="text-xs mt-1 text-gray-500">License</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold">4</div>
                <span class="text-xs mt-1 text-gray-500">Documents</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold">5</div>
                <span class="text-xs mt-1 text-gray-500">Submit</span>
            </div>
        </div>
    </div>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" id="dlForm">
        @csrf
        <input type="hidden" name="service_type" value="driving-license">

        <!-- SECTION A: Application Type -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">A</span>
                    Application Type
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-4 gap-4">
                    <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('application_subtype') == 'new' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="application_subtype" value="new" class="hidden peer" required {{ old('application_subtype') == 'new' ? 'checked' : '' }}>
                        <i class="fas fa-plus-circle text-3xl text-blue-600 mb-2"></i>
                        <p class="font-semibold">New License</p>
                        <p class="text-gray-500 text-xs mt-1">First time applicant</p>
                    </label>
                    <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('application_subtype') == 'renewal' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="application_subtype" value="renewal" class="hidden peer" {{ old('application_subtype') == 'renewal' ? 'checked' : '' }}>
                        <i class="fas fa-sync-alt text-3xl text-green-600 mb-2"></i>
                        <p class="font-semibold">Renewal</p>
                        <p class="text-gray-500 text-xs mt-1">Renew expired license</p>
                    </label>
                    <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('application_subtype') == 'duplicate' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="application_subtype" value="duplicate" class="hidden peer" {{ old('application_subtype') == 'duplicate' ? 'checked' : '' }}>
                        <i class="fas fa-copy text-3xl text-orange-600 mb-2"></i>
                        <p class="font-semibold">Duplicate</p>
                        <p class="text-gray-500 text-xs mt-1">Lost/damaged license</p>
                    </label>
                    <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('application_subtype') == 'add_class' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="application_subtype" value="add_class" class="hidden peer" {{ old('application_subtype') == 'add_class' ? 'checked' : '' }}>
                        <i class="fas fa-layer-group text-3xl text-purple-600 mb-2"></i>
                        <p class="font-semibold">Add Class</p>
                        <p class="text-gray-500 text-xs mt-1">Add vehicle category</p>
                    </label>
                </div>
                @error('application_subtype')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- SECTION B: Personal Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">B</span>
                    Personal Details
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Full Name -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Full Name <span class="text-red-500">*</span>
                            <span class="text-gray-400 text-xs font-normal">(As per Aadhaar Card)</span>
                        </label>
                        <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror"
                            placeholder="Enter full name">
                        @error('full_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="dob" value="{{ old('dob') }}" required 
                            max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-gray-400 text-xs mt-1">Minimum age: 18 years</p>
                    </div>

                    <!-- Father's Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Father's Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="father_name" value="{{ old('father_name') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Father's full name">
                    </div>

                    <!-- Mother's Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Mother's Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Mother's full name">
                    </div>

                    <!-- Spouse Name (Optional) -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Spouse Name <span class="text-gray-400 text-xs font-normal">(if applicable)</span>
                        </label>
                        <input type="text" name="spouse_name" value="{{ old('spouse_name') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Spouse's full name">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
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
                        <select name="blood_group" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Blood Group</option>
                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        </select>
                    </div>

                    <!-- Nationality -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Nationality <span class="text-red-500">*</span>
                        </label>
                        <select name="nationality" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="indian" selected>Indian</option>
                            <option value="foreign">Foreign National</option>
                        </select>
                    </div>

                    <!-- Place of Birth -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Place of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="City/Town">
                    </div>

                    <!-- Country of Birth -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Country of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="country_of_birth" value="{{ old('country_of_birth', 'India') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Qualification -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Educational Qualification <span class="text-red-500">*</span>
                        </label>
                        <select name="qualification" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Qualification</option>
                            <option value="illiterate" {{ old('qualification') == 'illiterate' ? 'selected' : '' }}>Illiterate</option>
                            <option value="below_8th" {{ old('qualification') == 'below_8th' ? 'selected' : '' }}>Below 8th</option>
                            <option value="8th_pass" {{ old('qualification') == '8th_pass' ? 'selected' : '' }}>8th Pass</option>
                            <option value="10th_pass" {{ old('qualification') == '10th_pass' ? 'selected' : '' }}>10th Pass</option>
                            <option value="12th_pass" {{ old('qualification') == '12th_pass' ? 'selected' : '' }}>12th Pass</option>
                            <option value="graduate" {{ old('qualification') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                            <option value="post_graduate" {{ old('qualification') == 'post_graduate' ? 'selected' : '' }}>Post Graduate</option>
                            <option value="professional" {{ old('qualification') == 'professional' ? 'selected' : '' }}>Professional Degree</option>
                        </select>
                    </div>

                    <!-- Organ Donor -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Organ Donor <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <div class="flex space-x-4 mt-2">
                            <label class="flex items-center">
                                <input type="radio" name="organ_donor" value="yes" class="mr-2" {{ old('organ_donor') == 'yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="organ_donor" value="no" class="mr-2" {{ old('organ_donor', 'no') == 'no' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Identification Marks -->
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Identification Mark 1 <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="identification_mark_1" value="{{ old('identification_mark_1') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Mole on right cheek">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Identification Mark 2 <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <input type="text" name="identification_mark_2" value="{{ old('identification_mark_2') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Scar on left hand">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION C: Contact Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">C</span>
                    Contact Details
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Mobile Number -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 rounded-l-lg text-gray-600">+91</span>
                            <input type="tel" name="mobile" value="{{ old('mobile', auth()->user()->phone) }}" required 
                                pattern="[0-9]{10}" maxlength="10"
                                class="w-full px-4 py-2 border rounded-r-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="10 digit mobile">
                        </div>
                    </div>

                    <!-- Alternate Mobile -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Alternate Mobile <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 bg-gray-100 border border-r-0 rounded-l-lg text-gray-600">+91</span>
                            <input type="tel" name="alternate_mobile" value="{{ old('alternate_mobile') }}" 
                                pattern="[0-9]{10}" maxlength="10"
                                class="w-full px-4 py-2 border rounded-r-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="10 digit mobile">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="email@example.com">
                    </div>

                    <!-- Aadhaar Number -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Aadhaar Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="aadhaar" value="{{ old('aadhaar') }}" required 
                            pattern="[0-9]{12}" maxlength="12"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="12 digit Aadhaar number">
                    </div>

                    <!-- PAN Number -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            PAN Number <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <input type="text" name="pan_number" value="{{ old('pan_number') }}" 
                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 uppercase"
                            placeholder="ABCDE1234F">
                    </div>

                    <!-- Emergency Contact -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Emergency Contact <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="emergency_contact" value="{{ old('emergency_contact') }}" required
                            pattern="[0-9]{10}" maxlength="10"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Emergency contact number">
                    </div>

                    <!-- Emergency Contact Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Emergency Contact Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Name of emergency contact">
                    </div>

                    <!-- Relationship -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Relationship <span class="text-red-500">*</span>
                        </label>
                        <select name="emergency_relationship" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Relationship</option>
                            <option value="father" {{ old('emergency_relationship') == 'father' ? 'selected' : '' }}>Father</option>
                            <option value="mother" {{ old('emergency_relationship') == 'mother' ? 'selected' : '' }}>Mother</option>
                            <option value="spouse" {{ old('emergency_relationship') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                            <option value="sibling" {{ old('emergency_relationship') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                            <option value="friend" {{ old('emergency_relationship') == 'friend' ? 'selected' : '' }}>Friend</option>
                            <option value="other" {{ old('emergency_relationship') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION D: Address Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">D</span>
                    Address Details
                </h2>
            </div>
            <div class="p-6">
                <!-- Present Address -->
                <h3 class="font-medium text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-home text-blue-500 mr-2"></i> Present Address
                </h3>
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="md:col-span-3">
                        <label class="block text-gray-700 font-medium mb-2">
                            House No./Building/Flat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="present_house_no" value="{{ old('present_house_no') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="House/Flat/Building number">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Street/Locality/Area <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="present_street" value="{{ old('present_street') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Street name, locality">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Landmark <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                        </label>
                        <input type="text" name="present_landmark" value="{{ old('present_landmark') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Near landmark">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Village/Town/City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="present_city" value="{{ old('present_city') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="City/Town name">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Taluka/Tehsil <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="present_taluka" value="{{ old('present_taluka') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Taluka/Tehsil">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            District <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="present_district" value="{{ old('present_district') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="District name">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            State <span class="text-red-500">*</span>
                        </label>
                        <select name="present_state" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select State</option>
                            <option value="Maharashtra" {{ old('present_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                            <option value="Gujarat" {{ old('present_state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                            <option value="Karnataka" {{ old('present_state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                            <option value="Delhi" {{ old('present_state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                            <option value="Tamil Nadu" {{ old('present_state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                            <option value="Uttar Pradesh" {{ old('present_state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                            <option value="Rajasthan" {{ old('present_state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                            <option value="West Bengal" {{ old('present_state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                            <option value="Madhya Pradesh" {{ old('present_state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                            <option value="Kerala" {{ old('present_state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            PIN Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="present_pincode" value="{{ old('present_pincode') }}" required
                            pattern="[0-9]{6}" maxlength="6"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="6 digit PIN">
                    </div>
                </div>

                <!-- Same as Present Address Checkbox -->
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="same_as_present" id="sameAddress" class="mr-3 w-5 h-5 text-blue-600">
                        <span class="font-medium">Permanent address is same as present address</span>
                    </label>
                </div>

                <!-- Permanent Address -->
                <h3 class="font-medium text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i> Permanent Address
                </h3>
                <div class="grid md:grid-cols-3 gap-4" id="permanentAddressSection">
                    <div class="md:col-span-3">
                        <label class="block text-gray-700 font-medium mb-2">
                            House No./Building/Flat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="permanent_house_no" value="{{ old('permanent_house_no') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 perm-field"
                            placeholder="House/Flat/Building number">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Street/Locality/Area <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="permanent_street" value="{{ old('permanent_street') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 perm-field"
                            placeholder="Street name, locality">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Landmark</label>
                        <input type="text" name="permanent_landmark" value="{{ old('permanent_landmark') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Near landmark">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Village/Town/City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="permanent_city" value="{{ old('permanent_city') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 perm-field"
                            placeholder="City/Town name">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            District <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="permanent_district" value="{{ old('permanent_district') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 perm-field"
                            placeholder="District name">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            State <span class="text-red-500">*</span>
                        </label>
                        <select name="permanent_state" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 perm-field">
                            <option value="">Select State</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            PIN Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="permanent_pincode" value="{{ old('permanent_pincode') }}"
                            pattern="[0-9]{6}" maxlength="6"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 perm-field"
                            placeholder="6 digit PIN">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION E: License Type & Vehicle Class -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">E</span>
                    License Type & Vehicle Class
                </h2>
            </div>
            <div class="p-6">
                <!-- License Type -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">
                        License Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition flex items-center {{ old('license_type') == 'non_transport' ? 'border-blue-500 bg-blue-50' : '' }}">
                            <input type="radio" name="license_type" value="non_transport" class="mr-3" required {{ old('license_type') == 'non_transport' ? 'checked' : '' }}>
                            <div>
                                <span class="font-semibold">Non-Transport (Private)</span>
                                <p class="text-gray-500 text-sm">For personal/private use vehicles</p>
                            </div>
                        </label>
                        <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition flex items-center {{ old('license_type') == 'transport' ? 'border-blue-500 bg-blue-50' : '' }}">
                            <input type="radio" name="license_type" value="transport" class="mr-3" {{ old('license_type') == 'transport' ? 'checked' : '' }}>
                            <div>
                                <span class="font-semibold">Transport (Commercial)</span>
                                <p class="text-gray-500 text-sm">For commercial/hire vehicles</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Learning License Details -->
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h3 class="font-medium text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-id-card text-yellow-600 mr-2"></i> Learning License Details
                        <span class="text-red-500 ml-1">*</span>
                    </h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">LL Number</label>
                            <input type="text" name="ll_number" value="{{ old('ll_number') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., MH01 2024 0001234">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">LL Issue Date</label>
                            <input type="date" name="ll_issue_date" value="{{ old('ll_issue_date') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">LL Expiry Date</label>
                            <input type="date" name="ll_expiry_date" value="{{ old('ll_expiry_date') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Issuing RTO</label>
                            <input type="text" name="ll_issuing_rto" value="{{ old('ll_issuing_rto') }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., MH01 - Mumbai">
                        </div>
                    </div>
                    <p class="text-yellow-700 text-sm mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        LL must be at least 30 days old and not expired to apply for permanent DL
                    </p>
                </div>

                <!-- Vehicle Class Selection -->
                <div>
                    <label class="block text-gray-700 font-medium mb-3">
                        Vehicle Class <span class="text-red-500">*</span>
                        <span class="text-gray-400 text-xs font-normal">(Select all that apply)</span>
                    </label>
                    
                    <!-- Two Wheeler -->
                    <p class="text-sm font-semibold text-gray-600 mb-2 mt-4">Two Wheeler</p>
                    <div class="grid md:grid-cols-3 gap-3 mb-4">
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="MCWOG" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">MCWOG</span>
                                <p class="text-gray-500 text-xs">Motorcycle Without Gear (Scooty/Activa)</p>
                                <p class="text-blue-600 text-xs">Age: 16+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="MCWG" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">MCWG</span>
                                <p class="text-gray-500 text-xs">Motorcycle With Gear (Bike)</p>
                                <p class="text-blue-600 text-xs">Age: 18+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="MC-EX50CC" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">MC EX50CC</span>
                                <p class="text-gray-500 text-xs">Motorcycle exceeding 50cc</p>
                                <p class="text-blue-600 text-xs">Age: 18+ years</p>
                            </div>
                        </label>
                    </div>

                    <!-- Four Wheeler (Non-Transport) -->
                    <p class="text-sm font-semibold text-gray-600 mb-2">Four Wheeler (Non-Transport)</p>
                    <div class="grid md:grid-cols-3 gap-3 mb-4">
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="LMV" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">LMV</span>
                                <p class="text-gray-500 text-xs">Light Motor Vehicle (Car/Jeep)</p>
                                <p class="text-blue-600 text-xs">Age: 18+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="LMV-NT" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">LMV-NT</span>
                                <p class="text-gray-500 text-xs">LMV Non-Transport</p>
                                <p class="text-blue-600 text-xs">Age: 18+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="INVCRG" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">INVCRG</span>
                                <p class="text-gray-500 text-xs">Invalid Carriage</p>
                                <p class="text-blue-600 text-xs">For differently abled</p>
                            </div>
                        </label>
                    </div>

                    <!-- Transport Vehicles -->
                    <p class="text-sm font-semibold text-gray-600 mb-2">Transport Vehicles (Commercial)</p>
                    <div class="grid md:grid-cols-3 gap-3 mb-4">
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="LMV-TR" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">LMV-TR</span>
                                <p class="text-gray-500 text-xs">LMV Transport (Taxi/Cab)</p>
                                <p class="text-blue-600 text-xs">Age: 20+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="MGV" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">MGV</span>
                                <p class="text-gray-500 text-xs">Medium Goods Vehicle</p>
                                <p class="text-blue-600 text-xs">Age: 20+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="HMV" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">HMV</span>
                                <p class="text-gray-500 text-xs">Heavy Motor Vehicle (Truck)</p>
                                <p class="text-blue-600 text-xs">Age: 20+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="HPMV" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">HPMV</span>
                                <p class="text-gray-500 text-xs">Heavy Passenger Motor Vehicle (Bus)</p>
                                <p class="text-blue-600 text-xs">Age: 20+ years</p>
                            </div>
                        </label>
                        <label class="border rounded-lg p-3 cursor-pointer hover:border-blue-500 transition flex items-start">
                            <input type="checkbox" name="vehicle_class[]" value="TRAILER" class="mt-1 mr-3">
                            <div>
                                <span class="font-medium text-sm">TRAILER</span>
                                <p class="text-gray-500 text-xs">Trailer/Articulated Vehicle</p>
                                <p class="text-blue-600 text-xs">Age: 20+ years</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- RTO Selection -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-medium mb-2">
                        Select RTO Office <span class="text-red-500">*</span>
                    </label>
                    <select name="rto_office" required class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select RTO Office</option>
                        <optgroup label="Maharashtra">
                            <option value="MH01" {{ old('rto_office') == 'MH01' ? 'selected' : '' }}>MH01 - Mumbai Central</option>
                            <option value="MH02" {{ old('rto_office') == 'MH02' ? 'selected' : '' }}>MH02 - Mumbai West</option>
                            <option value="MH03" {{ old('rto_office') == 'MH03' ? 'selected' : '' }}>MH03 - Mumbai East</option>
                            <option value="MH04" {{ old('rto_office') == 'MH04' ? 'selected' : '' }}>MH04 - Thane</option>
                            <option value="MH05" {{ old('rto_office') == 'MH05' ? 'selected' : '' }}>MH05 - Kalyan</option>
                            <option value="MH12" {{ old('rto_office') == 'MH12' ? 'selected' : '' }}>MH12 - Pune</option>
                            <option value="MH14" {{ old('rto_office') == 'MH14' ? 'selected' : '' }}>MH14 - Pimpri-Chinchwad</option>
                            <option value="MH20" {{ old('rto_office') == 'MH20' ? 'selected' : '' }}>MH20 - Aurangabad</option>
                            <option value="MH31" {{ old('rto_office') == 'MH31' ? 'selected' : '' }}>MH31 - Nagpur</option>
                        </optgroup>
                        <optgroup label="Gujarat">
                            <option value="GJ01" {{ old('rto_office') == 'GJ01' ? 'selected' : '' }}>GJ01 - Ahmedabad</option>
                            <option value="GJ05" {{ old('rto_office') == 'GJ05' ? 'selected' : '' }}>GJ05 - Surat</option>
                        </optgroup>
                        <optgroup label="Karnataka">
                            <option value="KA01" {{ old('rto_office') == 'KA01' ? 'selected' : '' }}>KA01 - Bangalore Central</option>
                            <option value="KA02" {{ old('rto_office') == 'KA02' ? 'selected' : '' }}>KA02 - Bangalore West</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION F: Document Uploads -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">F</span>
                    Document Uploads
                </h2>
                <p class="text-gray-500 text-sm mt-1">Upload clear scanned copies or photos of documents</p>
            </div>
            <div class="p-6">
                <!-- Document Guidelines -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-medium text-blue-800 mb-2"><i class="fas fa-info-circle mr-2"></i>Document Guidelines</h4>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li>• Accepted formats: PDF, JPG, JPEG, PNG</li>
                        <li>• Maximum file size: 2 MB per document</li>
                        <li>• Documents should be clearly readable</li>
                        <li>• Photo should be recent (taken within last 3 months)</li>
                        <li>• Signature should be on white background</li>
                    </ul>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Photo Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-user text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Passport Size Photo <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Recent color photo with white background</p>
                                </div>
                            </div>
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-gray-400 text-xs mt-2">Size: 35mm x 45mm, Max 500KB</p>
                        </label>
                    </div>

                    <!-- Signature Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-signature text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Signature <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Sign on white paper and scan/photo</p>
                                </div>
                            </div>
                            <input type="file" name="signature" accept=".jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="text-gray-400 text-xs mt-2">Size: 35mm x 15mm, Max 300KB</p>
                        </label>
                    </div>

                    <!-- Aadhaar Card -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-id-card text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Aadhaar Card <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Front and back side in single PDF/image</p>
                                </div>
                            </div>
                            <input type="file" name="aadhaar_doc" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        </label>
                    </div>

                    <!-- Address Proof -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-home text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Address Proof <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Electricity bill/Passport/Voter ID/Bank Statement</p>
                                </div>
                            </div>
                            <input type="file" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        </label>
                    </div>

                    <!-- Age Proof -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-teal-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-birthday-cake text-teal-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Age/DOB Proof <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Birth Certificate/10th Marksheet/Passport</p>
                                </div>
                            </div>
                            <input type="file" name="age_proof" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </label>
                    </div>

                    <!-- Learning License Copy -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Learning License Copy <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Valid Learning License</p>
                                </div>
                            </div>
                            <input type="file" name="ll_copy" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                        </label>
                    </div>

                    <!-- Medical Certificate -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-notes-medical text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Medical Certificate (Form 1A) <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">From registered medical practitioner</p>
                                </div>
                            </div>
                            <input type="file" name="medical_cert" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        </label>
                    </div>

                    <!-- ID Proof -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-passport text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">ID Proof <span class="text-gray-400 text-xs font-normal">(Optional)</span></p>
                                    <p class="text-gray-500 text-xs">PAN Card/Passport/Voter ID</p>
                                </div>
                            </div>
                            <input type="file" name="id_proof" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION G: Declaration -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">G</span>
                    Declaration & Undertaking
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4 mb-4 max-h-48 overflow-y-auto text-sm text-gray-700">
                    <p class="mb-3">I hereby declare that:</p>
                    <ol class="list-decimal list-inside space-y-2">
                        <li>All the information provided by me in this application is true and correct to the best of my knowledge and belief.</li>
                        <li>I am not disqualified for holding or obtaining a driving license under the Motor Vehicles Act, 1988.</li>
                        <li>I do not suffer from any disease or disability which is likely to cause my driving of a motor vehicle to be a source of danger to the public.</li>
                        <li>I am not currently holding any driving license issued by any other licensing authority in India.</li>
                        <li>My previous application for driving license has not been rejected or my license has not been revoked or suspended.</li>
                        <li>I have not been convicted of any offense under the Motor Vehicles Act or any other law relating to motor vehicles.</li>
                        <li>I understand that furnishing false information is an offense punishable under Section 177 of the Motor Vehicles Act, 1988.</li>
                        <li>I agree to abide by all traffic rules and regulations as prescribed by the Government.</li>
                    </ol>
                </div>

                <div class="space-y-3">
                    <label class="flex items-start cursor-pointer p-3 border rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="declaration_info" required class="mt-1 mr-3 w-5 h-5 text-blue-600">
                        <span class="text-gray-700">I confirm that all information provided above is true, complete, and correct. <span class="text-red-500">*</span></span>
                    </label>

                    <label class="flex items-start cursor-pointer p-3 border rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="declaration_documents" required class="mt-1 mr-3 w-5 h-5 text-blue-600">
                        <span class="text-gray-700">I confirm that all uploaded documents are genuine and belong to me. <span class="text-red-500">*</span></span>
                    </label>

                    <label class="flex items-start cursor-pointer p-3 border rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="declaration_terms" required class="mt-1 mr-3 w-5 h-5 text-blue-600">
                        <span class="text-gray-700">I have read and agree to the <a href="#" class="text-blue-600 underline">Terms & Conditions</a> and <a href="#" class="text-blue-600 underline">Privacy Policy</a>. <span class="text-red-500">*</span></span>
                    </label>

                    <label class="flex items-start cursor-pointer p-3 border rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="declaration_penalty" required class="mt-1 mr-3 w-5 h-5 text-blue-600">
                        <span class="text-gray-700">I understand that providing false information is punishable under law and may result in rejection of application and legal action. <span class="text-red-500">*</span></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Fee Summary -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-rupee-sign text-green-600 mr-2"></i>
                    Fee Summary
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Application Fee</span>
                        <span class="font-medium">₹ 200.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Test Fee (per vehicle class)</span>
                        <span class="font-medium">₹ 300.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Smart Card Fee</span>
                        <span class="font-medium">₹ 200.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Service Charge</span>
                        <span class="font-medium">₹ 50.00</span>
                    </div>
                    <div class="flex justify-between py-3 bg-blue-50 px-3 rounded-lg">
                        <span class="font-semibold text-gray-800">Estimated Total</span>
                        <span class="font-bold text-blue-600 text-lg">₹ 750.00*</span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    *Final fee may vary based on vehicle classes selected. Payment will be collected after document verification.
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
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="button" onclick="saveDraft()" class="px-6 py-3 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 font-medium">
                        <i class="fas fa-save mr-2"></i>Save Draft
                    </button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Application
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Same as present address functionality
    document.getElementById('sameAddress')?.addEventListener('change', function() {
        const permFields = document.querySelectorAll('.perm-field');
        const permSection = document.getElementById('permanentAddressSection');
        
        if (this.checked) {
            permSection.style.opacity = '0.5';
            permFields.forEach(field => {
                field.removeAttribute('required');
                field.disabled = true;
            });
            // Copy values
            document.querySelector('[name="permanent_house_no"]').value = document.querySelector('[name="present_house_no"]').value;
            document.querySelector('[name="permanent_street"]').value = document.querySelector('[name="present_street"]').value;
            document.querySelector('[name="permanent_city"]').value = document.querySelector('[name="present_city"]').value;
            document.querySelector('[name="permanent_district"]').value = document.querySelector('[name="present_district"]').value;
            document.querySelector('[name="permanent_state"]').value = document.querySelector('[name="present_state"]').value;
            document.querySelector('[name="permanent_pincode"]').value = document.querySelector('[name="present_pincode"]').value;
        } else {
            permSection.style.opacity = '1';
            permFields.forEach(field => {
                field.setAttribute('required', 'required');
                field.disabled = false;
            });
        }
    });

    // Radio button styling
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                r.closest('label').classList.remove('border-blue-500', 'bg-blue-50');
            });
            if (this.checked) {
                this.closest('label').classList.add('border-blue-500', 'bg-blue-50');
            }
        });
    });

    // Save draft function
    function saveDraft() {
        alert('Draft saving feature coming soon!');
    }
</script>
@endpush
@endsection

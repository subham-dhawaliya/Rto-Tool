@extends('layouts.app')

@section('title', 'Vehicle Registration - RTO Portal')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white rounded-t-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Vehicle Registration</h1>
                <p class="text-blue-200 mt-2">Form 20 - Application for Registration of Motor Vehicle</p>
            </div>
            <div class="hidden md:block bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                <i class="fas fa-car text-4xl"></i>
            </div>
        </div>
    </div>

    <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" id="vrForm">
        @csrf
        <input type="hidden" name="service_type" value="vehicle-registration">

        <!-- SECTION A: Registration Type -->
        <div class="bg-white rounded-lg shadow mb-6 mt-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">A</span>
                    Registration Type
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-4 gap-4">
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('registration_type', 'new') == 'new' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="registration_type" value="new" class="hidden" required {{ old('registration_type', 'new') == 'new' ? 'checked' : '' }}>
                        <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-plus-circle text-blue-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-sm">New Vehicle</p>
                        <p class="text-gray-500 text-xs mt-1">Brand new vehicle</p>
                    </label>
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('registration_type') == 'transfer' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="registration_type" value="transfer" class="hidden" {{ old('registration_type') == 'transfer' ? 'checked' : '' }}>
                        <div class="bg-green-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-exchange-alt text-green-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-sm">Transfer</p>
                        <p class="text-gray-500 text-xs mt-1">Ownership transfer</p>
                    </label>
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('registration_type') == 're_registration' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="registration_type" value="re_registration" class="hidden" {{ old('registration_type') == 're_registration' ? 'checked' : '' }}>
                        <div class="bg-orange-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-redo text-orange-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-sm">Re-Registration</p>
                        <p class="text-gray-500 text-xs mt-1">From other state</p>
                    </label>
                    <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center {{ old('registration_type') == 'duplicate_rc' ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="registration_type" value="duplicate_rc" class="hidden" {{ old('registration_type') == 'duplicate_rc' ? 'checked' : '' }}>
                        <div class="bg-purple-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-copy text-purple-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-sm">Duplicate RC</p>
                        <p class="text-gray-500 text-xs mt-1">Lost/damaged RC</p>
                    </label>
                </div>
            </div>
        </div>

        <!-- SECTION B: Owner Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">B</span>
                    Owner Details
                </h2>
            </div>
            <div class="p-6">
                <!-- Owner Type -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Owner Type <span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="owner_type" value="individual" class="mr-2" checked>
                            <span>Individual</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="owner_type" value="company" class="mr-2">
                            <span>Company/Firm</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="owner_type" value="government" class="mr-2">
                            <span>Government</span>
                        </label>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Owner Name -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Owner Name <span class="text-red-500">*</span>
                            <span class="text-gray-400 text-xs font-normal">(As per Aadhaar/PAN)</span>
                        </label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', auth()->user()->name) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter owner's full name">
                    </div>

                    <!-- Relation Type -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Relation <span class="text-red-500">*</span></label>
                        <select name="relation_type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select</option>
                            <option value="S/O">S/O (Son of)</option>
                            <option value="D/O">D/O (Daughter of)</option>
                            <option value="W/O">W/O (Wife of)</option>
                            <option value="H/O">H/O (Husband of)</option>
                        </select>
                    </div>

                    <!-- Father/Husband Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Father's/Spouse Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="father_spouse_name" value="{{ old('father_spouse_name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Father's/Spouse name">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="dob" value="{{ old('dob') }}" required
                            max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Mobile -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <span class="inline-flex items-center px-4 bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl text-gray-600">+91</span>
                            <input type="tel" name="mobile" value="{{ old('mobile', auth()->user()->phone) }}" required 
                                pattern="[0-9]{10}" maxlength="10"
                                class="w-full px-4 py-3 border border-gray-300 rounded-r-xl focus:ring-2 focus:ring-blue-500"
                                placeholder="10 digit mobile">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="email@example.com">
                    </div>

                    <!-- Aadhaar -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Aadhaar Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="aadhaar" value="{{ old('aadhaar') }}" required 
                            pattern="[0-9]{12}" maxlength="12"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="12 digit Aadhaar">
                    </div>

                    <!-- PAN -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            PAN Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pan_number" value="{{ old('pan_number') }}" required
                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 uppercase"
                            placeholder="ABCDE1234F">
                    </div>
                </div>

                <!-- Address -->
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-medium text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i> Owner's Address
                    </h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-gray-700 font-medium mb-2">
                                Address Line 1 <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="address_line1" value="{{ old('address_line1') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                                placeholder="House/Flat No., Building Name, Street">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2">Address Line 2</label>
                            <input type="text" name="address_line2" value="{{ old('address_line2') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                                placeholder="Locality, Area">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">District <span class="text-red-500">*</span></label>
                            <input type="text" name="district" value="{{ old('district') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">State <span class="text-red-500">*</span></label>
                            <select name="state" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
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
                            <label class="block text-gray-700 font-medium mb-2">PIN Code <span class="text-red-500">*</span></label>
                            <input type="text" name="pincode" value="{{ old('pincode') }}" required
                                pattern="[0-9]{6}" maxlength="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                                placeholder="6 digit PIN">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION C: Vehicle Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">C</span>
                    Vehicle Details
                </h2>
            </div>
            <div class="p-6">
                <!-- Vehicle Category -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Vehicle Category <span class="text-red-500">*</span></label>
                    <div class="grid md:grid-cols-4 gap-4">
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center">
                            <input type="radio" name="vehicle_category" value="two_wheeler" class="hidden" required>
                            <i class="fas fa-motorcycle text-3xl text-blue-600 mb-2"></i>
                            <p class="font-medium text-sm">Two Wheeler</p>
                        </label>
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center">
                            <input type="radio" name="vehicle_category" value="three_wheeler" class="hidden">
                            <i class="fas fa-shuttle-van text-3xl text-green-600 mb-2"></i>
                            <p class="font-medium text-sm">Three Wheeler</p>
                        </label>
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center">
                            <input type="radio" name="vehicle_category" value="four_wheeler" class="hidden">
                            <i class="fas fa-car text-3xl text-purple-600 mb-2"></i>
                            <p class="font-medium text-sm">Four Wheeler</p>
                        </label>
                        <label class="border-2 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition text-center">
                            <input type="radio" name="vehicle_category" value="commercial" class="hidden">
                            <i class="fas fa-truck text-3xl text-orange-600 mb-2"></i>
                            <p class="font-medium text-sm">Commercial</p>
                        </label>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <!-- Manufacturer -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Manufacturer/Make <span class="text-red-500">*</span>
                        </label>
                        <select name="manufacturer" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Manufacturer</option>
                            <optgroup label="Two Wheeler">
                                <option value="Honda">Honda</option>
                                <option value="Hero">Hero</option>
                                <option value="TVS">TVS</option>
                                <option value="Bajaj">Bajaj</option>
                                <option value="Royal Enfield">Royal Enfield</option>
                                <option value="Suzuki">Suzuki</option>
                                <option value="Yamaha">Yamaha</option>
                            </optgroup>
                            <optgroup label="Four Wheeler">
                                <option value="Maruti Suzuki">Maruti Suzuki</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Tata">Tata</option>
                                <option value="Mahindra">Mahindra</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Kia">Kia</option>
                                <option value="Honda Cars">Honda Cars</option>
                                <option value="MG">MG</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Model -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Model <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="model" value="{{ old('model') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Swift, City, Activa">
                    </div>

                    <!-- Variant -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Variant</label>
                        <input type="text" name="variant" value="{{ old('variant') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., VXI, ZX, Deluxe">
                    </div>

                    <!-- Fuel Type -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Fuel Type <span class="text-red-500">*</span>
                        </label>
                        <select name="fuel_type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Fuel Type</option>
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="cng">CNG</option>
                            <option value="lpg">LPG</option>
                            <option value="electric">Electric</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="petrol_cng">Petrol + CNG</option>
                        </select>
                    </div>

                    <!-- Color -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Color <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="color" value="{{ old('color') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Pearl White">
                    </div>

                    <!-- Manufacturing Year -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Manufacturing Year <span class="text-red-500">*</span>
                        </label>
                        <select name="mfg_year" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Year</option>
                            @for($y = date('Y'); $y >= 2010; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Chassis Number -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Chassis Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="chassis_number" value="{{ old('chassis_number') }}" required
                            maxlength="17"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 uppercase"
                            placeholder="17 character chassis number">
                        <p class="text-gray-400 text-xs mt-1">Found on vehicle frame/invoice</p>
                    </div>

                    <!-- Engine Number -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Engine Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="engine_number" value="{{ old('engine_number') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 uppercase"
                            placeholder="Engine number">
                    </div>

                    <!-- Engine Capacity -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Engine Capacity (CC) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="engine_capacity" value="{{ old('engine_capacity') }}" required
                            min="50" max="10000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 1197">
                    </div>

                    <!-- Seating Capacity -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Seating Capacity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="seating_capacity" value="{{ old('seating_capacity') }}" required
                            min="1" max="60"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 5">
                    </div>

                    <!-- Unladen Weight -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Unladen Weight (Kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="unladen_weight" value="{{ old('unladen_weight') }}" required
                            min="50"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 1050">
                    </div>

                    <!-- Laden Weight -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Laden Weight (Kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="laden_weight" value="{{ old('laden_weight') }}" required
                            min="100"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 1500">
                    </div>
                </div>

                <!-- Vehicle Use -->
                <div class="mt-6 pt-6 border-t">
                    <label class="block text-gray-700 font-medium mb-3">Vehicle Use <span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center cursor-pointer border-2 rounded-xl px-4 py-3 hover:border-blue-500">
                            <input type="radio" name="vehicle_use" value="private" class="mr-2" required checked>
                            <span>Private/Personal</span>
                        </label>
                        <label class="flex items-center cursor-pointer border-2 rounded-xl px-4 py-3 hover:border-blue-500">
                            <input type="radio" name="vehicle_use" value="commercial" class="mr-2">
                            <span>Commercial/Transport</span>
                        </label>
                        <label class="flex items-center cursor-pointer border-2 rounded-xl px-4 py-3 hover:border-blue-500">
                            <input type="radio" name="vehicle_use" value="taxi" class="mr-2">
                            <span>Taxi/Cab</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION D: Purchase & Insurance Details -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">D</span>
                    Purchase & Insurance Details
                </h2>
            </div>
            <div class="p-6">
                <!-- Purchase Details -->
                <h3 class="font-medium text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-shopping-cart text-green-500 mr-2"></i> Purchase Information
                </h3>
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Dealer Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="dealer_name" value="{{ old('dealer_name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Authorized dealer name">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Invoice Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Sale invoice number">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Invoice Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="invoice_date" value="{{ old('invoice_date') }}" required
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Invoice Amount (₹) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="invoice_amount" value="{{ old('invoice_amount') }}" required
                            min="10000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Total invoice amount">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Ex-Showroom Price (₹) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="ex_showroom_price" value="{{ old('ex_showroom_price') }}" required
                            min="10000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Ex-showroom price">
                    </div>
                </div>

                <!-- Insurance Details -->
                <h3 class="font-medium text-gray-700 mb-4 flex items-center pt-6 border-t">
                    <i class="fas fa-shield-alt text-blue-500 mr-2"></i> Insurance Information
                </h3>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Insurance Company <span class="text-red-500">*</span>
                        </label>
                        <select name="insurance_company" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Company</option>
                            <option value="ICICI Lombard">ICICI Lombard</option>
                            <option value="HDFC Ergo">HDFC Ergo</option>
                            <option value="Bajaj Allianz">Bajaj Allianz</option>
                            <option value="New India Assurance">New India Assurance</option>
                            <option value="United India">United India</option>
                            <option value="National Insurance">National Insurance</option>
                            <option value="Oriental Insurance">Oriental Insurance</option>
                            <option value="Tata AIG">Tata AIG</option>
                            <option value="Reliance General">Reliance General</option>
                            <option value="SBI General">SBI General</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Policy Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="policy_number" value="{{ old('policy_number') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Insurance policy number">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Insurance Type <span class="text-red-500">*</span>
                        </label>
                        <select name="insurance_type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Type</option>
                            <option value="comprehensive">Comprehensive</option>
                            <option value="third_party">Third Party Only</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Valid From <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="insurance_from" value="{{ old('insurance_from') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Valid To <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="insurance_to" value="{{ old('insurance_to') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            IDV Amount (₹) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="idv_amount" value="{{ old('idv_amount') }}" required
                            min="10000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Insured Declared Value">
                    </div>
                </div>

                <!-- Hypothecation (if financed) -->
                <div class="mt-6 pt-6 border-t">
                    <label class="flex items-center cursor-pointer mb-4">
                        <input type="checkbox" name="is_financed" id="isFinanced" class="w-5 h-5 text-blue-600 rounded mr-3">
                        <span class="font-medium text-gray-700">Vehicle is financed/on loan</span>
                    </label>
                    <div id="financeDetails" class="hidden grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Financier/Bank Name</label>
                            <input type="text" name="financier_name" value="{{ old('financier_name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                                placeholder="Bank/NBFC name">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Loan Account Number</label>
                            <input type="text" name="loan_account" value="{{ old('loan_account') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500"
                                placeholder="Loan account number">
                        </div>
                    </div>
                </div>

                <!-- RTO Selection -->
                <div class="mt-6 pt-6 border-t">
                    <label class="block text-gray-700 font-medium mb-2">
                        Select RTO Office <span class="text-red-500">*</span>
                    </label>
                    <select name="rto_office" required class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <option value="">Select RTO Office</option>
                        <optgroup label="Maharashtra">
                            <option value="MH01">MH01 - Mumbai Central</option>
                            <option value="MH02">MH02 - Mumbai West</option>
                            <option value="MH03">MH03 - Mumbai East</option>
                            <option value="MH04">MH04 - Thane</option>
                            <option value="MH12">MH12 - Pune</option>
                        </optgroup>
                        <optgroup label="Gujarat">
                            <option value="GJ01">GJ01 - Ahmedabad</option>
                        </optgroup>
                        <optgroup label="Karnataka">
                            <option value="KA01">KA01 - Bangalore</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION E: Document Uploads -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">E</span>
                    Document Uploads
                </h2>
                <p class="text-gray-500 text-sm mt-1">Upload clear scanned copies (PDF/JPG/PNG, Max 2MB each)</p>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Sale Invoice -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-file-invoice text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Sale Invoice <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Original sale invoice from dealer</p>
                                </div>
                            </div>
                            <input type="file" name="sale_invoice" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                        </label>
                    </div>

                    <!-- Insurance Certificate -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Insurance Certificate <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Valid insurance policy document</p>
                                </div>
                            </div>
                            <input type="file" name="insurance_doc" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                        </label>
                    </div>

                    <!-- PUC Certificate -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-teal-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-leaf text-teal-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">PUC Certificate <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Pollution Under Control certificate</p>
                                </div>
                            </div>
                            <input type="file" name="puc_doc" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200">
                        </label>
                    </div>

                    <!-- Aadhaar Card -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
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
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
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

                    <!-- Form 20 -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-indigo-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-file-alt text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Form 20 (Sale Certificate) <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Signed by dealer</p>
                                </div>
                            </div>
                            <input type="file" name="form_20" accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200">
                        </label>
                    </div>

                    <!-- Photo -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-pink-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-user text-pink-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Passport Photo <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Recent photo, white background</p>
                                </div>
                            </div>
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200">
                        </label>
                    </div>

                    <!-- Signature -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-5 hover:border-blue-400 transition bg-gray-50">
                        <label class="block cursor-pointer">
                            <div class="flex items-center mb-3">
                                <div class="bg-yellow-100 p-3 rounded-xl mr-4">
                                    <i class="fas fa-signature text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Signature <span class="text-red-500">*</span></p>
                                    <p class="text-gray-500 text-xs">Sign on white paper</p>
                                </div>
                            </div>
                            <input type="file" name="signature" accept=".jpg,.jpeg,.png" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-yellow-100 file:text-yellow-700 hover:file:bg-yellow-200">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION F: Declaration -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm mr-2">F</span>
                    Declaration
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-xl p-4 mb-4 max-h-40 overflow-y-auto text-sm text-gray-700 border">
                    <p class="mb-2">I hereby declare that:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>All information provided is true and correct to the best of my knowledge.</li>
                        <li>The vehicle is not stolen and has been lawfully acquired.</li>
                        <li>All taxes and duties applicable have been paid.</li>
                        <li>The vehicle complies with all safety and emission norms.</li>
                        <li>I understand that providing false information is punishable under law.</li>
                    </ol>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center cursor-pointer p-3 border rounded-xl hover:bg-gray-50">
                        <input type="checkbox" name="declaration" required class="w-5 h-5 text-blue-600 rounded mr-3">
                        <span class="text-gray-700">I confirm that all information provided is true and I accept the terms. <span class="text-red-500">*</span></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Fee Summary -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-rupee-sign text-blue-600 mr-2"></i>Fee Summary (Estimated)
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Registration Fee</span>
                        <span class="font-medium">₹ 600.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Road Tax (varies by state)</span>
                        <span class="font-medium">As applicable</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Smart Card Fee</span>
                        <span class="font-medium">₹ 200.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Hypothecation Fee (if financed)</span>
                        <span class="font-medium">₹ 1,500.00</span>
                    </div>
                    <div class="flex justify-between py-3 bg-blue-50 px-3 rounded-lg">
                        <span class="font-semibold text-gray-800">Base Fee (excl. Road Tax)</span>
                        <span class="font-bold text-blue-600 text-lg">₹ 2,300.00*</span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    *Road tax varies based on vehicle price and type. Final amount will be calculated after verification.
                </p>
            </div>
        </div>

        <!-- Submit Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-gray-600 text-sm">
                    <i class="fas fa-shield-alt text-blue-500 mr-1"></i>
                    Your data is secure and encrypted
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 font-medium">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 font-semibold shadow-lg shadow-blue-500/30">
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
                const label = r.closest('label');
                if (label) {
                    label.classList.remove('border-blue-500', 'bg-blue-50');
                }
            });
            if (this.checked) {
                const label = this.closest('label');
                if (label) {
                    label.classList.add('border-blue-500', 'bg-blue-50');
                }
            }
        });
    });

    // Finance details toggle
    document.getElementById('isFinanced')?.addEventListener('change', function() {
        const financeDetails = document.getElementById('financeDetails');
        if (this.checked) {
            financeDetails.classList.remove('hidden');
            financeDetails.classList.add('grid');
        } else {
            financeDetails.classList.add('hidden');
            financeDetails.classList.remove('grid');
        }
    });
</script>
@endsection

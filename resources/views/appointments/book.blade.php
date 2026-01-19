<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - RTO Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .time-slot { transition: all 0.2s ease; }
        .time-slot:hover { transform: scale(1.05); }
        .time-slot.selected { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="gradient-bg text-white py-6 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Book Appointment</h1>
                    <p class="text-purple-100 mt-1">Schedule your visit to RTO office</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg backdrop-blur-sm transition">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
            @csrf

            <!-- Service Type Selection -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white font-bold mr-3">1</div>
                    <h2 class="text-xl font-semibold text-gray-800">Select Service Type</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="service_type" value="ll_test" class="peer hidden" required>
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-3xl mr-3">📝</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Learning License Test</h3>
                                    <p class="text-sm text-gray-600 mt-1">Written test for learner's license</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="service_type" value="dl_test" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-3xl mr-3">🚗</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Driving Test</h3>
                                    <p class="text-sm text-gray-600 mt-1">Practical driving test</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="service_type" value="vehicle_inspection" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-3xl mr-3">🔍</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Vehicle Inspection</h3>
                                    <p class="text-sm text-gray-600 mt-1">Physical vehicle verification</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="service_type" value="document_verification" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-3xl mr-3">📄</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Document Verification</h3>
                                    <p class="text-sm text-gray-600 mt-1">Original document check</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="service_type" value="fitness_test" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-3xl mr-3">🏥</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Fitness Test</h3>
                                    <p class="text-sm text-gray-600 mt-1">Vehicle fitness certificate</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="service_type" value="other" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-3xl mr-3">📋</div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Other Services</h3>
                                    <p class="text-sm text-gray-600 mt-1">General RTO services</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Application Number (Optional)</label>
                    <input type="text" name="application_number" value="{{ old('application_number') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="e.g., APP20240101ABC123">
                    <p class="text-xs text-gray-500 mt-1">Enter if you have an existing application</p>
                </div>
            </div>

            <!-- RTO Office Selection -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white font-bold mr-3">2</div>
                    <h2 class="text-xl font-semibold text-gray-800">Select RTO Office</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="rto_office" value="RTO Delhi Central" class="peer hidden" required>
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🏢</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">RTO Delhi Central</h3>
                                    <p class="text-xs text-gray-600 mt-1">Kashmere Gate, New Delhi</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="rto_office" value="RTO Delhi East" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🏢</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">RTO Delhi East</h3>
                                    <p class="text-xs text-gray-600 mt-1">Laxmi Nagar, East Delhi</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="rto_office" value="RTO Delhi West" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🏢</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">RTO Delhi West</h3>
                                    <p class="text-xs text-gray-600 mt-1">Janakpuri, West Delhi</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="rto_office" value="RTO Delhi South" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🏢</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">RTO Delhi South</h3>
                                    <p class="text-xs text-gray-600 mt-1">Saket, South Delhi</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="rto_office" value="RTO Delhi North" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🏢</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">RTO Delhi North</h3>
                                    <p class="text-xs text-gray-600 mt-1">Rohini, North Delhi</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="card-hover cursor-pointer">
                        <input type="radio" name="rto_office" value="RTO Dwarka" class="peer hidden">
                        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🏢</div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">RTO Dwarka</h3>
                                    <p class="text-xs text-gray-600 mt-1">Sector 10, Dwarka</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Date & Time Selection -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white font-bold mr-3">3</div>
                    <h2 class="text-xl font-semibold text-gray-800">Select Date & Time</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Appointment Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="appointment_date" id="appointmentDate" 
                               value="{{ old('appointment_date') }}" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Select a date within next 30 days</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Time Slot <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-2" id="timeSlots">
                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="09:00 AM - 10:00 AM" class="peer hidden" required>
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">09:00 AM</div>
                                    <div class="text-xs opacity-75">10:00 AM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="10:00 AM - 11:00 AM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">10:00 AM</div>
                                    <div class="text-xs opacity-75">11:00 AM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="11:00 AM - 12:00 PM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">11:00 AM</div>
                                    <div class="text-xs opacity-75">12:00 PM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="12:00 PM - 01:00 PM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">12:00 PM</div>
                                    <div class="text-xs opacity-75">01:00 PM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="02:00 PM - 03:00 PM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">02:00 PM</div>
                                    <div class="text-xs opacity-75">03:00 PM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="03:00 PM - 04:00 PM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">03:00 PM</div>
                                    <div class="text-xs opacity-75">04:00 PM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="04:00 PM - 05:00 PM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">04:00 PM</div>
                                    <div class="text-xs opacity-75">05:00 PM</div>
                                </div>
                            </label>

                            <label class="time-slot cursor-pointer">
                                <input type="radio" name="time_slot" value="05:00 PM - 06:00 PM" class="peer hidden">
                                <div class="border-2 border-gray-200 peer-checked:border-purple-500 rounded-lg p-3 text-center peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-indigo-600 peer-checked:text-white">
                                    <div class="text-sm font-medium">05:00 PM</div>
                                    <div class="text-xs opacity-75">06:00 PM</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary & Submit -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl shadow-md p-6 mb-6 border border-purple-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">📋 Appointment Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Service Type:</span>
                        <span class="font-medium text-gray-800" id="summaryService">Not selected</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">RTO Office:</span>
                        <span class="font-medium text-gray-800" id="summaryRTO">Not selected</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium text-gray-800" id="summaryDate">Not selected</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Time Slot:</span>
                        <span class="font-medium text-gray-800" id="summaryTime">Not selected</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 gradient-bg text-white py-4 rounded-lg font-semibold hover:shadow-lg transition transform hover:scale-105">
                    🎯 Confirm Appointment
                </button>
                <a href="{{ route('dashboard') }}" class="px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        // Update summary in real-time
        const serviceInputs = document.querySelectorAll('input[name="service_type"]');
        const rtoInputs = document.querySelectorAll('input[name="rto_office"]');
        const dateInput = document.getElementById('appointmentDate');
        const timeInputs = document.querySelectorAll('input[name="time_slot"]');

        const serviceNames = {
            'll_test': 'Learning License Test',
            'dl_test': 'Driving Test',
            'vehicle_inspection': 'Vehicle Inspection',
            'document_verification': 'Document Verification',
            'fitness_test': 'Fitness Test',
            'other': 'Other Services'
        };

        serviceInputs.forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('summaryService').textContent = serviceNames[input.value];
            });
        });

        rtoInputs.forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('summaryRTO').textContent = input.value;
            });
        });

        dateInput.addEventListener('change', () => {
            const date = new Date(dateInput.value);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('summaryDate').textContent = date.toLocaleDateString('en-IN', options);
        });

        timeInputs.forEach(input => {
            input.addEventListener('change', () => {
                document.getElementById('summaryTime').textContent = input.value;
            });
        });
    </script>
</body>
</html>

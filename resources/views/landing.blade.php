@extends('layouts.app')

@section('title', 'RTO Services Portal - Home')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Regional Transport Office Services</h1>
        <p class="text-xl mb-8">Apply for driving licenses, vehicle registration, permits and more - all online!</p>
        @guest
            <a href="{{ route('register') }}" class="bg-white text-blue-800 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-100 transition">
                Get Started
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="bg-white text-blue-800 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-100 transition">
                Go to Dashboard
            </a>
        @endguest
    </div>
</section>

<!-- Services Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Our Services</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-green-600 text-4xl mb-4"><i class="fas fa-graduation-cap"></i></div>
                <h3 class="text-xl font-semibold mb-2">Learning License</h3>
                <p class="text-gray-600">Apply for learner's license - your first step to driving.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-id-card"></i></div>
                <h3 class="text-xl font-semibold mb-2">Driving License</h3>
                <p class="text-gray-600">Apply for new driving license, renewal, or duplicate license.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-blue-600 text-4xl mb-4"><i class="fas fa-car"></i></div>
                <h3 class="text-xl font-semibold mb-2">Vehicle Registration</h3>
                <p class="text-gray-600">Register new vehicles, transfer ownership, or get duplicate RC.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-purple-600 text-4xl mb-4"><i class="fas fa-calendar-alt"></i></div>
                <h3 class="text-xl font-semibold mb-2">Book Appointment</h3>
                <p class="text-gray-600">Schedule your RTO visit for tests and verifications.</p>
            </div>
            <a href="{{ route('applications.track') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition block">
                <div class="text-orange-600 text-4xl mb-4"><i class="fas fa-search"></i></div>
                <h3 class="text-xl font-semibold mb-2">Track Application</h3>
                <p class="text-gray-600">Track your application status in real-time.</p>
            </a>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-teal-600 text-4xl mb-4"><i class="fas fa-clipboard-check"></i></div>
                <h3 class="text-xl font-semibold mb-2">Fitness Certificate</h3>
                <p class="text-gray-600">Apply for vehicle fitness certificate renewal.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="bg-gray-200 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">How It Works</h2>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                <h3 class="font-semibold mb-2">Register</h3>
                <p class="text-gray-600">Create your account</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                <h3 class="font-semibold mb-2">Apply</h3>
                <p class="text-gray-600">Choose service & apply</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                <h3 class="font-semibold mb-2">Track</h3>
                <p class="text-gray-600">Monitor your application</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">4</div>
                <h3 class="font-semibold mb-2">Receive</h3>
                <p class="text-gray-600">Get your documents</p>
            </div>
        </div>
    </div>
</section>
@endsection

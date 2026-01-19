@extends('layouts.app')

@section('title', 'Register - RTO Portal')

@section('content')
<div class="min-h-[85vh] flex">
    <!-- Left Side - Registration Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-lg">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center justify-center bg-blue-600 text-white p-4 rounded-2xl mb-4">
                    <i class="fas fa-car text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">RTO Portal</h2>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                    <p class="text-gray-500 mt-2">Join thousands of users managing their RTO services online</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-red-700 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                placeholder="Enter your full name">
                        </div>
                    </div>

                    <!-- Email & Phone Row -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                    placeholder="you@example.com">
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">+91</span>
                                </div>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    pattern="[0-9]{10}" maxlength="10"
                                    class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                    placeholder="9876543210">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" required minlength="8"
                                class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Minimum 8 characters">
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password-toggle"></i>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="flex space-x-1">
                                <div class="h-1 w-1/4 rounded bg-gray-200" id="strength-1"></div>
                                <div class="h-1 w-1/4 rounded bg-gray-200" id="strength-2"></div>
                                <div class="h-1 w-1/4 rounded bg-gray-200" id="strength-3"></div>
                                <div class="h-1 w-1/4 rounded bg-gray-200" id="strength-4"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" id="strength-text">Use 8+ characters with mix of letters, numbers & symbols</p>
                        </div>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Re-enter your password">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_confirmation-toggle"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-start">
                        <input type="checkbox" name="terms" id="terms" required
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                        <label for="terms" class="ml-3 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> 
                            and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-lg shadow-blue-500/30 flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or register with</span>
                    </div>
                </div>

                <!-- Social Register -->
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </a>
                    <button type="button" class="flex items-center justify-center py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        <i class="fas fa-id-card text-orange-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">DigiLocker</span>
                    </button>
                </div>

                <!-- Login Link -->
                <p class="text-center mt-8 text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Sign In</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side - Illustration/Info -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-green-500 via-teal-600 to-blue-700 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="white"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#dots)"/>
            </svg>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-32 right-16 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-32 left-16 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute top-1/3 right-1/3 w-16 h-16 bg-yellow-400/20 rounded-full blur-lg"></div>
        
        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center px-12 text-white">
            <div class="mb-8">
                <div class="flex items-center mb-6">
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <i class="fas fa-id-card text-4xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold mb-4">Join RTO Portal</h1>
                <p class="text-green-100 text-lg leading-relaxed">
                    Create your account and get access to all RTO services from the comfort of your home. No more waiting in long queues!
                </p>
            </div>
            
            <!-- Benefits -->
            <div class="space-y-5">
                <div class="flex items-start bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div class="bg-yellow-400 text-yellow-900 p-2 rounded-lg mr-4">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Quick & Easy</h3>
                        <p class="text-green-100 text-sm">Apply for licenses in minutes, not hours</p>
                    </div>
                </div>
                <div class="flex items-start bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div class="bg-blue-400 text-blue-900 p-2 rounded-lg mr-4">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Real-time Tracking</h3>
                        <p class="text-green-100 text-sm">Track your application status 24/7</p>
                    </div>
                </div>
                <div class="flex items-start bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div class="bg-purple-400 text-purple-900 p-2 rounded-lg mr-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Online Appointments</h3>
                        <p class="text-green-100 text-sm">Book your RTO visit at your convenience</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial -->
            <div class="mt-10 bg-white/10 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center mb-3">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center text-xs font-bold">R</div>
                        <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center text-xs font-bold">S</div>
                        <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold">A</div>
                    </div>
                    <div class="ml-3 flex text-yellow-400">
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                    </div>
                </div>
                <p class="text-green-100 text-sm italic">"Got my driving license without visiting RTO even once. Amazing service!"</p>
                <p class="text-white text-sm font-medium mt-2">- Rahul S., Mumbai</p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = document.getElementById(fieldId + '-toggle');
    if (field.type === 'password') {
        field.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}

// Password strength checker
document.getElementById('password')?.addEventListener('input', function(e) {
    const password = e.target.value;
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
    const texts = ['Weak', 'Fair', 'Good', 'Strong'];
    
    for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById('strength-' + i);
        bar.className = 'h-1 w-1/4 rounded ' + (i <= strength ? colors[strength - 1] : 'bg-gray-200');
    }
    
    const textEl = document.getElementById('strength-text');
    if (strength > 0) {
        textEl.textContent = texts[strength - 1] + ' password';
        textEl.className = 'text-xs mt-1 ' + colors[strength - 1].replace('bg-', 'text-');
    } else {
        textEl.textContent = 'Use 8+ characters with mix of letters, numbers & symbols';
        textEl.className = 'text-xs text-gray-500 mt-1';
    }
});
</script>
@endsection

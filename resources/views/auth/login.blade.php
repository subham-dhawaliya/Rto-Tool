@extends('layouts.app')

@section('title', 'Login - RTO Portal')

@section('content')
<div class="min-h-[85vh] flex">
    <!-- Left Side - Illustration/Info -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)"/>
            </svg>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-40 right-20 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-yellow-400/20 rounded-full blur-lg"></div>
        
        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center px-12 text-white">
            <div class="mb-8">
                <div class="flex items-center mb-6">
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <i class="fas fa-car text-4xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Access your RTO services dashboard. Track applications, book appointments, and manage all your transport-related services in one place.
                </p>
            </div>
            
            <!-- Features List -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="bg-green-400/20 p-2 rounded-lg mr-4">
                        <i class="fas fa-check text-green-300"></i>
                    </div>
                    <span class="text-blue-100">Track your license applications</span>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-400/20 p-2 rounded-lg mr-4">
                        <i class="fas fa-check text-green-300"></i>
                    </div>
                    <span class="text-blue-100">Book RTO appointments online</span>
                </div>
                <div class="flex items-center">
                    <div class="bg-green-400/20 p-2 rounded-lg mr-4">
                        <i class="fas fa-check text-green-300"></i>
                    </div>
                    <span class="text-blue-100">Download digital documents</span>
                </div>
            </div>

            <!-- Stats -->
            <div class="mt-12 grid grid-cols-3 gap-6">
                <div class="text-center">
                    <p class="text-3xl font-bold">50K+</p>
                    <p class="text-blue-200 text-sm">Active Users</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold">100+</p>
                    <p class="text-blue-200 text-sm">RTO Offices</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold">24/7</p>
                    <p class="text-blue-200 text-sm">Support</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center justify-center bg-blue-600 text-white p-4 rounded-2xl mb-4">
                    <i class="fas fa-car text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">RTO Portal</h2>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Sign In</h2>
                    <p class="text-gray-500 mt-2">Enter your credentials to access your account</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-700 text-sm">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Email Field -->
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
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password-toggle"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Forgot password?</a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition font-semibold shadow-lg shadow-blue-500/30 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or continue with</span>
                    </div>
                </div>

                <!-- Social Login -->
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
                        <i class="fas fa-mobile-alt text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">OTP Login</span>
                    </button>
                </div>

                <!-- Register Link -->
                <p class="text-center mt-8 text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Create Account</a>
                </p>
            </div>

            <!-- Help Text -->
            <p class="text-center mt-6 text-gray-500 text-sm">
                <i class="fas fa-shield-alt mr-1"></i>
                Your data is protected with 256-bit encryption
            </p>
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
</script>
@endsection

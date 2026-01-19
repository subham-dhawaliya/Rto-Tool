<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RTO Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-2xl mr-3"></i>
                    <span class="text-xl font-bold">RTO Admin Panel</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Welcome, {{ auth()->user()->name }}</span>
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm hover:text-gray-200 transition">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
            <p class="text-gray-600 mt-1">Monitor and manage RTO applications and appointments</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Applications -->
            <div class="stat-card bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Applications</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_applications'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="stat-card bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending Review</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['pending_applications'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Approved Applications -->
            <div class="stat-card bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Approved</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['approved_applications'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Appointments -->
            <div class="stat-card bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Appointments</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['confirmed_appointments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.applications.index') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-tasks text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Manage Applications</h3>
                        <p class="text-sm text-gray-500">Review and process applications</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.appointments.index') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Manage Appointments</h3>
                        <p class="text-sm text-gray-500">View and schedule appointments</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-chart-bar text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Reports</h3>
                        <p class="text-sm text-gray-500">Generate analytics reports</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Applications & Pending Appointments -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Applications -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
                    <a href="{{ route('admin.applications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
                </div>
                <div class="space-y-3">
                    @forelse($recent_applications as $application)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $application->application_number }}</p>
                            <p class="text-sm text-gray-600">{{ $application->user->name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($application->status === 'pending') bg-orange-100 text-orange-700
                                @elseif($application->status === 'approved') bg-green-100 text-green-700
                                @elseif($application->status === 'rejected') bg-red-100 text-red-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $application->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No applications yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Pending Appointments -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h2>
                    <a href="{{ route('admin.appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
                </div>
                <div class="space-y-3">
                    @forelse($pending_appointments as $appointment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $appointment->booking_number }}</p>
                            <p class="text-sm text-gray-600">{{ $appointment->user->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $appointment->time_slot }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No upcoming appointments</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>

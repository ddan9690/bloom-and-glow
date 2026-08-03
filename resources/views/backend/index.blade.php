@extends('layouts.app')

@section('title', "Dashboard | Bloom & Glow Mbita")

@section('content')
<!-- Dashboard Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-8 sm:py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-purple-600"></i>
                    <span>System Administration Hub</span>
                </span>
                
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    Welcome back, {{ auth()->user()->name ?? 'Admin' }}! 👋
                </h1>
                <p class="text-sm sm:text-base text-gray-600 font-['Plus_Jakarta_Sans'] mt-2">
                    Here is an overview of appointments, client requests, and system operations.
                </p>
            </div>

            <div class="flex items-center gap-3">
                @can('manage users')
                <a href="{{ route('management.users.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-purple-800 hover:bg-purple-900 text-white font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Manage Staff</span>
                </a>
                @endcan
            </div>
        </div>
    </div>
</section>

<!-- Notification Alerts -->
@if(session('success'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif

<!-- Main Content Area -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[600px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Metrics Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Pending Bookings -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 font-['Outfit']">Pending Bookings</p>
                    <h3 class="text-3xl font-bold font-['Outfit'] text-gray-900 mt-1">{{ $stats['pending'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Confirmed Bookings -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 font-['Outfit']">Confirmed</p>
                    <h3 class="text-3xl font-bold font-['Outfit'] text-gray-900 mt-1">{{ $stats['confirmed'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Completed Appointments -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 font-['Outfit']">Completed</p>
                    <h3 class="text-3xl font-bold font-['Outfit'] text-gray-900 mt-1">{{ $stats['completed'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Total System Users -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 font-['Outfit']">Staff & Users</p>
                    <h3 class="text-3xl font-bold font-['Outfit'] text-gray-900 mt-1">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-700">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <!-- Quick Links Grid Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @can('manage users')
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold font-['Outfit'] text-gray-900">Staff & Permissions</h4>
                    <p class="text-xs text-gray-500 mt-1">Register or modify staff clearance levels.</p>
                </div>
                <a href="{{ route('management.users.index') }}" class="p-3 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-colors">
                    <i data-lucide="user-cog" class="w-5 h-5"></i>
                </a>
            </div>
            @endcan

            @can('manage categories')
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold font-['Outfit'] text-gray-900">Service Categories</h4>
                    <p class="text-xs text-gray-500 mt-1">Manage salon offerings and pricing sheets.</p>
                </div>
                <a href="{{ route('management.categories.index') }}" class="p-3 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-colors">
                    <i data-lucide="grid" class="w-5 h-5"></i>
                </a>
            </div>
            @endcan

            @can('manage services')
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold font-['Outfit'] text-gray-900">Manage Services</h4>
                    <p class="text-xs text-gray-500 mt-1">Configure salon treatments and active rates.</p>
                </div>
                <a href="{{ route('management.services.index') }}" class="p-3 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-colors">
                    <i data-lucide="scissors" class="w-5 h-5"></i>
                </a>
            </div>
            @endcan
        </div>

        <!-- Latest Bookings Table Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold font-['Outfit'] text-gray-900">Recent Client Bookings</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Latest appointment requests received through the portal</p>
                </div>
                <a href="{{ route('management.bookings.index') }}" class="text-xs font-semibold text-purple-800 hover:text-purple-900 flex items-center gap-1 font-['Outfit']">
                    <span>View All Bookings</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">
                            <th class="py-3.5 px-4">#</th>
                            <th class="py-3.5 px-4">Client Name</th>
                            <th class="py-3.5 px-4">Phone</th>
                            <th class="py-3.5 px-4">Service Requested</th>
                            <th class="py-3.5 px-4">Schedule Date</th>
                            <th class="py-3.5 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-['Plus_Jakarta_Sans']">
                        @forelse($latestBookings as $booking)
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-gray-900">{{ $booking['row_no'] }}</td>
                            <td class="py-3.5 px-4 font-medium text-gray-900 whitespace-nowrap">{{ $booking['name'] }}</td>
                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">{{ $booking['phone'] }}</td>
                            <td class="py-3.5 px-4 text-gray-800 max-w-xs truncate">{{ $booking['service'] }}</td>
                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">{{ $booking['appointment_date'] }} at {{ $booking['appointment_time'] }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'rescheduled' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                    $badgeStyle = $statusClasses[$booking['status']] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md border uppercase tracking-wide {{ $badgeStyle }}">
                                    {{ ucfirst($booking['status']) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500 text-sm">No recent bookings recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection
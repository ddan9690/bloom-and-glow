@extends('layouts.app')

@section('title', "Manage Bookings | Bloom & Glow Mbita")

@section('content')
<!-- Header Section -->
<section class="bg-white text-gray-900 overflow-hidden py-8 sm:py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                    <i data-lucide="calendar-range" class="w-4 h-4 text-purple-600"></i>
                    <span>Booking Operations</span>
                </span>
                
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    Client Bookings Management 📅
                </h1>
                <p class="text-sm sm:text-base text-gray-600 font-['Plus_Jakarta_Sans'] mt-2">
                    Review, filter, and update appointment requests from salon clients.
                </p>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 pb-4">
            <a href="{{ route('management.bookings.index') }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all {{ is_null($status) ? 'bg-purple-800 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                All Bookings <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ is_null($status) ? 'bg-purple-900 text-purple-100' : 'bg-gray-100 text-gray-600' }}">{{ $counts['all'] }}</span>
            </a>
            
            <a href="{{ route('management.bookings.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all {{ $status === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Pending <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $status === 'pending' ? 'bg-amber-700 text-amber-100' : 'bg-gray-100 text-gray-600' }}">{{ $counts['pending'] }}</span>
            </a>

            <a href="{{ route('management.bookings.index', ['status' => 'confirmed']) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all {{ $status === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Confirmed <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $status === 'confirmed' ? 'bg-blue-700 text-blue-100' : 'bg-gray-100 text-gray-600' }}">{{ $counts['confirmed'] }}</span>
            </a>

            <a href="{{ route('management.bookings.index', ['status' => 'completed']) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all {{ $status === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Completed <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $status === 'completed' ? 'bg-emerald-700 text-emerald-100' : 'bg-gray-100 text-gray-600' }}">{{ $counts['completed'] }}</span>
            </a>

            <a href="{{ route('management.bookings.index', ['status' => 'rescheduled']) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all {{ $status === 'rescheduled' ? 'bg-purple-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Rescheduled <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $status === 'rescheduled' ? 'bg-purple-700 text-purple-100' : 'bg-gray-100 text-gray-600' }}">{{ $counts['rescheduled'] }}</span>
            </a>

            <a href="{{ route('management.bookings.index', ['status' => 'cancelled']) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all {{ $status === 'cancelled' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Cancelled <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $status === 'cancelled' ? 'bg-red-700 text-red-100' : 'bg-gray-100 text-gray-600' }}">{{ $counts['cancelled'] }}</span>
            </a>
        </div>

        <!-- Bookings Table Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold font-['Outfit'] text-gray-900">Bookings Directory</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Showing client booking appointments with update options</p>
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">
                            <th class="py-3.5 px-4">ID</th>
                            <th class="py-3.5 px-4">Client Details</th>
                            <th class="py-3.5 px-4">Services</th>
                            <th class="py-3.5 px-4">Schedule</th>
                            <th class="py-3.5 px-4">Location</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-['Plus_Jakarta_Sans']">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-4 px-4 font-semibold text-gray-900">#{{ $booking->id }}</td>
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900">{{ $booking->client_name }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">{{ $booking->client_phone }}</div>
                            </td>
                            <td class="py-4 px-4 text-gray-800">
                                @if($booking->services->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($booking->services as $service)
                                            <span class="px-2 py-0.5 bg-purple-50 text-purple-700 border border-purple-100 rounded text-xs font-medium">{{ $service->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">No services listed</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-gray-600 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $booking->preferred_time }}</div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-lg border {{ $booking->location_type === 'studio' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-teal-50 text-teal-700 border-teal-200' }}">
                                    {{ ucfirst($booking->location_type) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'rescheduled' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                    $badgeStyle = $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md border uppercase tracking-wide {{ $badgeStyle }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('operations.bookings.status', $booking->id) }}" method="POST" class="inline-flex items-center gap-1">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded-lg px-2 py-1 bg-white font-medium focus:ring-2 focus:ring-purple-500 focus:outline-none">
                                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="rescheduled" {{ $booking->status === 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500 text-sm">No bookings found for this filter criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($bookings->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
            @endif
        </div>

    </div>
</section>
@endsection
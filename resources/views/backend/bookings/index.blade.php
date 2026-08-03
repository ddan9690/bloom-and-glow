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

<!-- Main Content Area with Alpine.js Wrapper -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[600px]" 
         x-data="{ 
            selectedStatus: '{{ $status ?? 'all' }}', 
            searchQuery: '',
            rescheduleModalOpen: false,
            activeBookingId: null,
            activeBookingName: '',
            activeDate: '',
            activeTime: '',
            openRescheduleModal(id, name, date, time) {
                this.activeBookingId = id;
                this.activeBookingName = name;
                this.activeDate = date;
                this.activeTime = time;
                this.rescheduleModalOpen = true;
            },
            hasVisibleRows(rows) {
                if (!rows) return false;
                for (let i = 0; i < rows.length; i++) {
                    let status = rows[i].getAttribute('data-status');
                    let name = rows[i].getAttribute('data-name');
                    let phone = rows[i].getAttribute('data-phone');
                    
                    let matchesStatus = (this.selectedStatus === 'all' || status === this.selectedStatus);
                    let matchesSearch = (this.searchQuery === '' || 
                                         name.includes(this.searchQuery.toLowerCase()) || 
                                         phone.includes(this.searchQuery));
                    if (matchesStatus && matchesSearch) return true;
                }
                return false;
            }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 pb-4">
            <button @click="selectedStatus = 'all'" 
                    :class="selectedStatus === 'all' ? 'bg-purple-800 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all">
                All Bookings <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="selectedStatus === 'all' ? 'bg-purple-900 text-purple-100' : 'bg-gray-100 text-gray-600'">{{ $counts['all'] }}</span>
            </button>
            
            <button @click="selectedStatus = 'pending'" 
                    :class="selectedStatus === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all">
                Pending <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="selectedStatus === 'pending' ? 'bg-amber-700 text-amber-100' : 'bg-gray-100 text-gray-600'">{{ $counts['pending'] }}</span>
            </button>

            <button @click="selectedStatus = 'confirmed'" 
                    :class="selectedStatus === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all">
                Confirmed <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="selectedStatus === 'confirmed' ? 'bg-blue-700 text-blue-100' : 'bg-gray-100 text-gray-600'">{{ $counts['confirmed'] }}</span>
            </button>

            <button @click="selectedStatus = 'completed'" 
                    :class="selectedStatus === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all">
                Completed <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="selectedStatus === 'completed' ? 'bg-emerald-700 text-emerald-100' : 'bg-gray-100 text-gray-600'">{{ $counts['completed'] }}</span>
            </button>

            <button @click="selectedStatus = 'rescheduled'" 
                    :class="selectedStatus === 'rescheduled' ? 'bg-purple-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all">
                Rescheduled <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="selectedStatus === 'rescheduled' ? 'bg-purple-700 text-purple-100' : 'bg-gray-100 text-gray-600'">{{ $counts['rescheduled'] }}</span>
            </button>

            <button @click="selectedStatus = 'cancelled'" 
                    :class="selectedStatus === 'cancelled' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold font-['Outfit'] transition-all">
                Cancelled <span class="ml-1 px-2 py-0.5 rounded-full text-xs" :class="selectedStatus === 'cancelled' ? 'bg-red-700 text-red-100' : 'bg-gray-100 text-gray-600'">{{ $counts['cancelled'] }}</span>
            </button>
        </div>

        <!-- Bookings Table Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden" x-ref="tableContainer">
            <div class="p-6 border-b border-gray-200 flex justify-end">
                <!-- Search Input Field -->
                <div class="relative w-full sm:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Search client name or phone..." 
                           class="w-full pl-9 pr-4 py-2 text-xs sm:text-sm bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[950px]">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">
                            <th class="py-3.5 px-4">#</th>
                            <th class="py-3.5 px-4">Client Details</th>
                            <th class="py-3.5 px-4">Services</th>
                            <th class="py-3.5 px-4">Schedule & History</th>
                            <th class="py-3.5 px-4">Location</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-['Plus_Jakarta_Sans']" x-ref="tableBody">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-purple-50/30 transition-colors booking-row"
                            data-status="{{ $booking->status }}"
                            data-name="{{ strtolower($booking->client_name) }}"
                            data-phone="{{ $booking->client_phone }}"
                            x-show="(selectedStatus === 'all' || '{{ $booking->status }}' === selectedStatus) && 
                                    (searchQuery === '' || 
                                     '{{ strtolower($booking->client_name) }}'.includes(searchQuery.toLowerCase()) || 
                                     '{{ $booking->client_phone }}'.includes(searchQuery))">
                            
                            <td class="py-4 px-4 font-semibold text-gray-900">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900">{{ $booking->client_name }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">{{ $booking->client_phone }}</div>
                            </td>
                            <td class="py-4 px-4 text-gray-800">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-purple-50 text-purple-700 border border-purple-100 rounded-md text-xs font-medium">
                                    <i data-lucide="scissors" class="w-3.5 h-3.5 text-purple-500 flex-shrink-0"></i>
                                    <span>{{ $booking->formatted_services ?? 'General Service' }}</span>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600 whitespace-nowrap">
                                <div class="font-medium text-gray-900">
                                    {{ strtoupper(\Carbon\Carbon::parse($booking->preferred_date)->format('d-M-y')) }} at {{ strtolower(\Carbon\Carbon::parse($booking->preferred_time)->format('g:ia')) }}
                                </div>
                                
                                <!-- Reschedule History Track Display -->
                                @if($booking->original_date)
                                <div class="text-[11px] text-purple-700 bg-purple-50 border border-purple-200 px-2 py-0.5 rounded mt-1 inline-block font-medium">
                                    🔄 Rescheduled from {{ strtoupper(\Carbon\Carbon::parse($booking->original_date)->format('d-M-y')) }} @if($booking->original_time) at {{ strtolower(\Carbon\Carbon::parse($booking->original_time)->format('g:ia')) }} @endif
                                </div>
                                @endif

                                <div class="text-[10px] text-gray-400 mt-0.5">
                                    Placed: {{ strtoupper(\Carbon\Carbon::parse($booking->created_at)->format('d-M-y')) }}, {{ strtolower(\Carbon\Carbon::parse($booking->created_at)->format('g:ia')) }}
                                </div>
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
                                    <!-- Status Update Form -->
                                    <form action="{{ route('operations.bookings.status', $booking->id) }}" method="POST" class="inline-flex items-center">
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

                                    <!-- Reschedule Action Button -->
                                    <button @click="openRescheduleModal({{ $booking->id }}, '{{ addslashes($booking->client_name) }}', '{{ $booking->preferred_date }}', '{{ $booking->preferred_time }}')" 
                                            class="px-2.5 py-1 text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                                        Reschedule
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="empty-database-row">
                            <td colspan="7" class="py-8 text-center text-gray-500 text-sm">No bookings found in the system.</td>
                        </tr>
                        @endforelse

                        <!-- Dynamic No Match Row -->
                        <tr x-show="!hasVisibleRows($refs.tableBody.querySelectorAll('.booking-row'))" style="display: none;">
                            <td colspan="7" class="py-10 text-center text-gray-500 text-sm">
                                No booking found with the details.
                            </td>
                        </tr>
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

    <!-- Alpine.js Reschedule Modal -->
    <div x-cloak x-show="rescheduleModalOpen" class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 flex items-center justify-center p-4">
        <div @click.away="rescheduleModalOpen = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold font-['Outfit'] text-gray-900">Reschedule Booking</h3>
                <button @click="rescheduleModalOpen = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="'{{ url('management/bookings') }}/' + activeBookingId + '/reschedule'" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-xs text-gray-500">Client</p>
                    <p class="text-sm font-semibold text-gray-900" x-text="activeBookingName"></p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">New Preferred Date</label>
                    <input type="date" name="preferred_date" x-model="activeDate" required class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">New Preferred Time</label>
                    <input type="time" name="preferred_time" x-model="activeTime" required class="w-full text-xs sm:text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="rescheduleModalOpen = false" class="px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-purple-700 rounded-xl hover:bg-purple-800 shadow-sm">Save New Schedule</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
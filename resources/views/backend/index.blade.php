@extends('layouts.app')

@section('title', "Dashboard & Latest Bookings | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-8 sm:py-12 lg:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6" data-aos="fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-purple-600"></i>
                    <span>Admin Control Center</span>
                </span>
                
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    Welcome back, <span class="text-purple-800">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-sm sm:text-base text-gray-600 font-['Plus_Jakarta_Sans'] mt-2">
                    Manage your bookings, service catalog, operating settings, and staff permissions seamlessly.
                </p>
            </div>

            <!-- Quick Action & Management Hub Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('management.users.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-purple-100 hover:bg-purple-200 text-purple-900 font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit'] border border-purple-200">
                    <i data-lucide="users" class="w-4 h-4 text-purple-700"></i>
                    <span>Staff Management</span>
                </a>
                <a href="{{ route('management.category-daily-limits.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="sliders" class="w-4 h-4 text-purple-200"></i>
                    <span>Booking Settings</span>
                </a>
                <a href="{{ route('management.categories.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="folder-cog" class="w-4 h-4 text-gray-500"></i>
                    <span>Manage Services</span>
                </a>
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

<!-- Dashboard Content Section -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Bookings Counters Grid -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold font-['Outfit'] text-gray-900">Booking Overview</h2>
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Real-time status</span>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                
                <!-- Pending Bookings Card -->
                <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between hover:border-amber-200 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-amber-700 bg-amber-50 px-2 sm:px-2.5 py-1 rounded-md font-['Outfit']">Pending</span>
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-800 flex items-center justify-center">
                            <i data-lucide="clock" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">{{ $stats['pending'] }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Awaiting review</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-800 hover:text-amber-900 transition-colors">
                            <span>View pending</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Confirmed Bookings Card -->
                <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between hover:border-blue-200 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-blue-700 bg-blue-50 px-2 sm:px-2.5 py-1 rounded-md font-['Outfit']">Confirmed</span>
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-800 flex items-center justify-center">
                            <i data-lucide="calendar-check" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">{{ $stats['confirmed'] }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Scheduled sessions</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-800 hover:text-blue-900 transition-colors">
                            <span>View confirmed</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Completed Bookings Card -->
                <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between hover:border-emerald-200 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 sm:px-2.5 py-1 rounded-md font-['Outfit']">Completed</span>
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <i data-lucide="check-circle-2" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">{{ $stats['completed'] }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Successfully served</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 hover:text-emerald-900 transition-colors">
                            <span>View completed</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- Cancelled Bookings Card -->
                <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between hover:border-red-200 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-red-700 bg-red-50 px-2 sm:px-2.5 py-1 rounded-md font-['Outfit']">Cancelled</span>
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl bg-red-50 text-red-800 flex items-center justify-center">
                            <i data-lucide="x-circle" class="w-4 h-4 sm:w-6 sm:h-6"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">{{ $stats['cancelled'] }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Declined or dropped</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-800 hover:text-red-900 transition-colors">
                            <span>View cancelled</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Latest Bookings Table Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold font-['Outfit'] text-gray-900">Latest Bookings</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Real-time incoming client appointments sorted by most recent</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-medium text-purple-900 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter Status</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Export</span>
                    </a>
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[850px]">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">
                            <th class="py-3.5 px-4">#</th>
                            <th class="py-3.5 px-4">Booked On</th>
                            <th class="py-3.5 px-4">Name</th>
                            <th class="py-3.5 px-4">Phone</th>
                            <th class="py-3.5 px-4">Service(s)</th>
                            <th class="py-3.5 px-4">Preferred Date</th>
                            <th class="py-3.5 px-4">Preferred Time</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-['Plus_Jakarta_Sans']">
                        @forelse($latestBookings as $booking)
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-gray-900">{{ $booking['row_no'] ?? $loop->iteration }}</td>
                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">{{ $booking['booked_on'] }}</td>
                            <td class="py-3.5 px-4 font-medium text-gray-900 whitespace-nowrap">{{ $booking['name'] }}</td>
                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">{{ $booking['phone'] }}</td>
                            <td class="py-3.5 px-4 text-gray-800 font-medium">{{ $booking['service'] }}</td>
                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">{{ $booking['appointment_date'] }}</td>
                            <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">{{ $booking['appointment_time'] ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                    $currentStatus = strtolower($booking['status'] ?? 'pending');
                                    $badgeClass = $statusClasses[$currentStatus] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md border uppercase tracking-wide {{ $badgeClass }}">
                                    {{ ucfirst($currentStatus) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <form id="status-form-{{ $booking['id'] }}" action="{{ route('operations.bookings.status', $booking['id']) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" 
                                            onchange="confirmStatusChange(this, '{{ $booking['id'] }}', '{{ $booking['name'] }}')" 
                                            class="text-xs font-medium py-1.5 px-2.5 rounded-lg border border-gray-300 bg-white text-gray-800 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 outline-none cursor-pointer">
                                        <option value="" disabled selected>Select Action</option>
                                        <option value="confirmed">Confirm</option>
                                        <option value="completed">Complete</option>
                                        <option value="cancelled">Cancel</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-6 text-center text-gray-500 text-sm">No recent bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination Summary -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
                <span>Showing latest bookings matrix</span>
                <a href="{{ route('dashboard') }}" class="font-medium text-purple-900 hover:underline">View all bookings matrix →</a>
            </div>
        </div>

        <!-- Main Management Grid (Categories, Services, & Quick Access Control) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left 2 Columns: Categories & Services Catalog Management Hub -->
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold font-['Outfit'] text-gray-900">Service Categories & Offerings</h3>
                            <p class="text-xs text-gray-500">Structured layout of services catalog under each category</p>
                        </div>
                        <a href="{{ route('management.categories.index') }}" class="text-sm font-medium text-purple-900 hover:underline inline-flex items-center gap-1">
                            <span>Manage Services</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>

                    <!-- Category Group List -->
                    <div class="space-y-6">
                        @forelse($categories as $category)
                        <!-- Dynamic Category Item -->
                        <div class="border border-gray-200 rounded-xl p-4 sm:p-5 bg-gray-50/30">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-200 mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-900 flex items-center justify-center font-bold">
                                        <i data-lucide="{{ $category->icon ?? 'scissors' }}" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 font-['Outfit']">{{ $category->name }}</h4>
                                        <span class="text-xs text-gray-500">{{ $category->services->count() }} active services</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('management.categories.index') }}" class="px-2.5 py-1 text-xs font-medium text-purple-800 bg-purple-50 border border-purple-200 rounded-md hover:bg-purple-100 transition-colors">Edit</a>
                                    <a href="{{ route('management.categories.index') }}" class="px-2.5 py-1 text-xs font-medium text-purple-800 bg-white border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">+ Add Service</a>
                                </div>
                            </div>

                            <!-- Services under Category -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                @forelse($category->services as $service)
                                <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center justify-between text-sm">
                                    <div>
                                        <p class="font-medium text-gray-900 font-['Outfit']">{{ $service->name }}</p>
                                        <span class="text-xs text-gray-500">{{ $service->duration_mins }} mins • KSh {{ number_format($service->price) }}</span>
                                    </div>
                                    <a href="{{ route('management.categories.index') }}" class="text-gray-400 hover:text-purple-900"><i data-lucide="more-vertical" class="w-4 h-4"></i></a>
                                </div>
                                @empty
                                <div class="col-span-2 text-xs text-gray-500 py-2">No services listed under this category yet.</div>
                                @endforelse
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6 text-gray-500 text-sm">No service categories found.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Column: System Control Hub -->
            <div class="space-y-6">
                
                <!-- Side Navigation Links Panel (Configured with Real Routes) -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-bold font-['Outfit'] text-gray-900 mb-4">Quick Navigation</h3>
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-purple-50/50 text-gray-700 hover:text-purple-900 transition-colors text-sm font-medium">
                            <span class="flex items-center gap-2.5">
                                <i data-lucide="calendar" class="w-4 h-4 text-purple-800"></i>
                                <span>All Bookings Matrix</span>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                        </a>
                        <a href="{{ route('management.categories.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-purple-50/50 text-gray-700 hover:text-purple-900 transition-colors text-sm font-medium">
                            <span class="flex items-center gap-2.5">
                                <i data-lucide="folder-cog" class="w-4 h-4 text-purple-800"></i>
                                <span>Manage Services</span>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                        </a>
                        <a href="{{ route('management.users.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-purple-50/50 text-gray-700 hover:text-purple-900 transition-colors text-sm font-medium">
                            <span class="flex items-center gap-2.5">
                                <i data-lucide="users" class="w-4 h-4 text-purple-800"></i>
                                <span>Staff Management</span>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                        </a>
                        <a href="{{ route('management.category-daily-limits.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-purple-50/50 text-gray-700 hover:text-purple-900 transition-colors text-sm font-medium">
                            <span class="flex items-center gap-2.5">
                                <i data-lucide="sliders" class="w-4 h-4 text-purple-800"></i>
                                <span>Manage Booking Settings</span>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- SweetAlert2 Scripts CDN (Ensure layout includes it or add here) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmStatusChange(selectElement, bookingId, clientName) {
        const selectedStatus = selectElement.value;
        const form = document.getElementById('status-form-' + bookingId);

        if (!selectedStatus) return;

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to change booking status for ${clientName} to "${selectedStatus.toUpperCase()}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#581c87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show success loader or submit immediately
                Swal.fire({
                    title: 'Updated!',
                    text: 'Booking status has been updated successfully.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(() => {
                    form.submit();
                }, 1000);
            } else {
                // Reset select dropdown if cancelled
                selectElement.selectedIndex = 0;
            }
        });
    }
</script>
@endsection
@extends('layouts.app')

@section('title', "{$category->name} Services | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-6 sm:py-8 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-2 font-['Plus_Jakarta_Sans']">
                    <a href="{{ route('management.categories.index') }}" class="hover:text-purple-900 transition-colors">Categories Management</a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-gray-900 font-medium">{{ $category->name }}</span>
                </nav>
                
                <h1 class="text-2xl sm:text-3xl font-bold font-['Outfit'] tracking-tight text-gray-900 flex items-center gap-3">
                    <span>{{ $category->name }}</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $category->available === 'yes' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                        {{ $category->available === 'yes' ? 'Available' : 'Not Available' }}
                    </span>
                </h1>
            </div>

            <!-- Back Button -->
            <div class="flex items-center">
                <a href="{{ route('management.categories.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition-all text-sm font-['Outfit']">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Back to Categories</span>
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

<!-- Main Content Layout -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]" x-data="{ openAddModal: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Section Header & Add Trigger -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div>
                <h2 class="text-lg font-bold font-['Outfit'] text-gray-900">Services under {{ $category->name }}</h2>
            </div>
            
            <button @click="openAddModal = true" 
                class="inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-4 py-2.5 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                <i data-lucide="plus" class="w-4 h-4 text-purple-200"></i>
                <span>Add Service</span>
            </button>
        </div>

        <!-- Services Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[650px]">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">
                            <th class="py-3.5 px-4">#</th>
                            <th class="py-3.5 px-4">Service Name</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-['Plus_Jakarta_Sans']">
                        @forelse($category->services as $service)
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-gray-900">{{ $loop->iteration }}</td>
                            <td class="py-3.5 px-4 font-bold text-gray-900 font-['Outfit']">
                                <a href="{{ route('management.services.show', ['service' => $service->id, 'slug' => $service->slug]) }}" class="text-purple-900 hover:text-purple-700 hover:underline transition-colors">
                                    {{ $service->name }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('management.services.update', $service->id) }}" method="POST" id="status-form-{{ $service->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $service->name }}">
                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                    <input type="hidden" name="available" id="status-input-{{ $service->id }}" value="{{ $service->available }}">
                                    
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               value="{{ $service->available === 'yes' ? 'no' : 'yes' }}" 
                                               class="sr-only peer" 
                                               @if($service->available === 'yes') checked @endif
                                               onchange="confirmToggleStatus(this, '{{ $service->id }}', '{{ $service->available === 'yes' ? 'Not Available' : 'Available' }}')">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                    </label>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('management.services.edit', ['service' => $service->id, 'slug' => $service->slug]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-purple-800 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                <!-- Delete Service Form -->
                                <form action="{{ route('management.services.destroy', $service->id) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500 text-sm">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                                        <i data-lucide="layers" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-gray-600 font-medium">No services found under this category yet.</p>
                                    <button @click="openAddModal = true" class="text-xs text-purple-900 font-bold hover:underline">Add the first service</button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Alpine.js Add Service Modal -->
    <div x-show="openAddModal" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div @click.away="openAddModal = false" 
             class="relative bg-white rounded-2xl max-w-lg w-full p-6 overflow-hidden shadow-2xl">
            
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                <h3 class="text-lg font-bold font-['Outfit'] text-gray-900">Add Service to {{ $category->name }}</h3>
                <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('management.services.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <input type="hidden" name="available" value="yes">

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1 font-['Outfit']">Service Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-purple-600 focus:ring-1 focus:ring-purple-600">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-purple-900 hover:bg-purple-800 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
                        Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function confirmDelete(button) {
        const form = button.closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this service?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmToggleStatus(checkbox, serviceId, targetStatusText) {
        const form = document.getElementById('status-form-' + serviceId);
        const input = document.getElementById('status-input-' + serviceId);
        
        Swal.fire({
            title: 'Change Status',
            text: `Change status to ${targetStatusText}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#581c87',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                input.value = checkbox.value;
                form.submit();
            } else {
                checkbox.checked = !checkbox.checked;
            }
        });
    }
</script>
@endpush
@endsection
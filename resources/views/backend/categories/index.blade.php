@extends('layouts.app')

@section('title', "Categories Management | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-6 sm:py-8 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-purple-600"></i>
                    <span>Admin Control Center</span>
                </span>
                
                <h1 class="text-2xl sm:text-3xl font-bold font-['Outfit'] tracking-tight text-gray-900 mt-3">
                    Categories Management
                </h1>
            </div>

            <!-- Quick Action Button -->
            <div class="flex items-center">
                <a href="{{ route('management.categories.create') }}" 
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="plus" class="w-4 h-4 text-purple-200"></i>
                    <span>Add New Category</span>
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

<!-- Categories Content Section -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]" x-data="{ modalOpen: false, activeImage: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Categories Table Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[650px]">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">
                            <th class="py-3.5 px-4">#</th>
                            <th class="py-3.5 px-4">Image / Icon</th>
                            <th class="py-3.5 px-4">Name</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-['Plus_Jakarta_Sans']">
                        @forelse($categories as $category)
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-gray-900">{{ $loop->iteration }}</td>
                            <td class="py-3.5 px-4">
                                @if($category->image)
                                    @php
                                        $imagePath = asset('storage/' . $category->image);
                                    @endphp
                                    <img src="{{ $imagePath }}" 
                                         alt="{{ $category->name }}" 
                                         width="45" 
                                         class="rounded-lg object-cover shadow-sm cursor-pointer hover:opacity-85 transition-opacity h-11 w-11"
                                         @click="activeImage = '{{ $imagePath }}'; modalOpen = true;">
                                @else
                                    <div class="w-11 h-11 rounded-lg bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-700">
                                        <i data-lucide="grid" class="w-5 h-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-900 font-['Outfit']">
                                <a href="{{ route('management.categories.show', ['category' => $category->id, 'slug' => $category->slug]) }}" class="text-purple-900 hover:text-purple-700 hover:underline transition-colors">
                                    {{ $category->name }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('management.categories.update', $category->id) }}" method="POST" id="status-form-{{ $category->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $category->name }}">
                                    <input type="hidden" name="available" id="status-input-{{ $category->id }}" value="{{ $category->available }}">
                                    
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               value="{{ $category->available === 'yes' ? 'no' : 'yes' }}" 
                                               class="sr-only peer" 
                                               @if($category->available === 'yes') checked @endif
                                               onchange="confirmToggleStatus(this, '{{ $category->id }}', '{{ $category->available === 'yes' ? 'Not Available' : 'Available' }}')">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                    </label>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('management.categories.edit', ['category' => $category->id, 'slug' => $category->slug]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-purple-800 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('management.categories.destroy', $category->id) }}" method="POST" class="inline-block delete-form">
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
                            <td colspan="5" class="py-8 text-center text-gray-500 text-sm">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination Summary -->
            @if(method_exists($categories, 'links'))
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
                    <span>Showing categories results</span>
                    <div>
                        {{ $categories->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Alpine.js Image Preview Modal -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div @click.away="modalOpen = false" 
             class="relative bg-white rounded-2xl max-w-lg w-full p-4 overflow-hidden shadow-2xl flex flex-col items-center">
            
            <button @click="modalOpen = false" 
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors z-10">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="w-full max-h-[80vh] flex items-center justify-center overflow-hidden rounded-xl bg-gray-50 my-2">
                <img :src="activeImage" alt="Category Image Preview" class="max-h-[70vh] w-auto object-contain rounded-lg">
            </div>

            <div class="w-full text-center mt-2">
                <button @click="modalOpen = false" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition-colors">
                    Close Preview
                </button>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function confirmDelete(button) {
        const form = button.closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this category?',
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

    function confirmToggleStatus(checkbox, categoryId, targetStatusText) {
        const form = document.getElementById('status-form-' + categoryId);
        const input = document.getElementById('status-input-' + categoryId);
        
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
                // Revert checkbox state if canceled
                checkbox.checked = !checkbox.checked;
            }
        });
    }
</script>
@endpush
@endsection
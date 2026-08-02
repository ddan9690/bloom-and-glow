@extends('layouts.app')

@section('title', "Edit Category | Bloom & Glow Mbita")

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
                    Edit Category
                </h1>
                <p class="text-sm sm:text-base text-gray-600 font-['Plus_Jakarta_Sans'] mt-2">
                    Update service category details, status, and associated image.
                </p>
            </div>

            <!-- Back Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('management.categories.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="arrow-left" class="w-4 h-4 text-gray-500"></i>
                    <span>Back to Categories</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Notification Alerts -->
@if(session('error'))
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif

<!-- Form Section -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 sm:p-8" x-data="{ hasImage: {{ old('has_image', $category->image ? 'true' : 'false') ? 'true' : 'false' }}, fileName: '' }">
            
            <form action="{{ route('management.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-700 font-['Outfit'] mb-2">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $category->name) }}" 
                           required
                           class="w-full px-4 py-3 text-sm rounded-xl border @error('name') border-red-300 bg-red-50/30 @else border-gray-300 @enderror bg-white text-gray-900 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 outline-none transition-all"
                           placeholder="e.g. Hair Styling & Kinyozi">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Status (Available) -->
                <div>
                    <label for="available" class="block text-xs font-semibold uppercase tracking-wider text-gray-700 font-['Outfit'] mb-2">Status <span class="text-red-500">*</span></label>
                    <select id="available" 
                            name="available" 
                            required
                            class="w-full px-4 py-3 text-sm rounded-xl border @error('available') border-red-300 bg-red-50/30 @else border-gray-300 @enderror bg-white text-gray-900 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 outline-none transition-all cursor-pointer">
                        <option value="yes" {{ old('available', $category->available) === 'yes' ? 'selected' : '' }}>Available</option>
                        <option value="no" {{ old('available', $category->available) === 'no' ? 'selected' : '' }}>Not Available</option>
                    </select>
                    @error('available')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Existing Image Preview (If Available) -->
                @if($category->image)
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center gap-4">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-16 h-16 rounded-lg object-cover shadow-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-900 font-['Outfit']">Current Category Image</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Checking "Category Has Image" and uploading a new one will replace this image.</p>
                    </div>
                </div>
                @endif

                <!-- Category Has Image Checkbox -->
                <div class="flex items-center gap-3 py-1">
                    <input type="checkbox" 
                           id="has_image" 
                           name="has_image" 
                           value="1"
                           x-model="hasImage"
                           {{ old('has_image', $category->image ? true : false) ? 'checked' : '' }}
                           class="w-4 h-4 text-purple-900 border-gray-300 rounded focus:ring-purple-800 cursor-pointer">
                    <label for="has_image" class="text-xs font-semibold uppercase tracking-wider text-gray-700 font-['Outfit'] cursor-pointer select-none">
                        Category Has Image
                    </label>
                </div>

                <!-- Category Image Upload Input (Conditional) -->
                <div x-show="hasImage" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700 font-['Outfit'] mb-2">Upload New Image</label>
                    
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50/50 hover:bg-gray-50 transition-all">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-400 mb-2"></i>
                                <p class="mb-1 text-xs text-gray-600 font-medium">
                                    <span class="font-bold text-purple-900">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-[11px] text-gray-400" x-text="fileName ? 'Selected: ' + fileName : 'PNG, JPG, WEBP up to 2MB'"></p>
                            </div>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''"
                                   class="hidden">
                        </label>
                    </div>
                    @error('image')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Submit Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('management.categories.index') }}" 
                       class="px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium text-sm transition-all font-['Outfit']">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 rounded-xl bg-purple-900 hover:bg-purple-800 text-white font-medium text-sm transition-all shadow-sm font-['Outfit'] inline-flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Update Category</span>
                    </button>
                </div>

            </form>

        </div>

    </div>
</section>
@endsection
@extends('layouts.app')

@section('title', "Edit Service | Bloom & Glow Mbita")

@section('content')
<section class="bg-white py-8 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 font-['Outfit']">Edit Service: {{ $service->name }}</h1>
    </div>
</section>

<section class="py-8 bg-gray-50/50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('management.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-2">Category</label>
                <select name="category_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-900" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $service->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-2">Service Name</label>
                <input type="text" name="name" value="{{ $service->name }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-900" required>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-900">{{ $service->description }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-2">Image</label>
                @if($service->image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $service->image) }}" class="w-20 h-20 rounded-xl object-cover"></div>
                @endif
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-900" required>
                    <option value="yes" {{ ($service->status ?? $service->available) === 'yes' ? 'selected' : '' }}>Available</option>
                    <option value="no" {{ ($service->status ?? $service->available) === 'no' ? 'selected' : '' }}>Not Available</option>
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('management.services.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium">Cancel</a>
                <button type="submit" class="px-5 py-2.5 bg-purple-900 text-white rounded-xl text-sm font-medium">Update Service</button>
            </div>
        </form>
    </div>
</section>
@endsection
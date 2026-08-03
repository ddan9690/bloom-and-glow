@extends('layouts.app')

@section('title', "{$category->name} Details | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-8 sm:py-12 lg:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6" data-aos="fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-2">
                    <i data-lucide="layers" class="w-4 h-4 text-purple-600"></i>
                    <span>Category Overview</span>
                </span>
                
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    {{ $category->name }}
                </h1>
                <p class="text-sm text-gray-500 font-['Plus_Jakarta_Sans'] mt-1">
                    Status: 
                    <span class="font-semibold {{ $category->available === 'yes' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $category->available === 'yes' ? 'Available' : 'Not Available' }}
                    </span>
                </p>
            </div>

            <!-- Back & Edit Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('management.categories.edit', $category->id) }}" 
                    class="inline-flex items-center justify-center gap-2 bg-purple-50 hover:bg-purple-100 text-purple-900 border border-purple-200 font-medium px-4 py-2.5 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                    <span>Edit Category</span>
                </a>
                <a href="{{ route('management.categories.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition-all text-sm font-['Outfit']">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Back to Categories</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services List Under This Category Section -->
<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold font-['Outfit'] text-gray-900">Services under {{ $category->name }}</h3>
                </div>
            </div>

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
                                {{ $service->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('management.services.toggle-status', $service->id) }}" method="POST" id="status-form-{{ $service->id }}" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="status" value="yes" 
                                            {{ ($service->status ?? $service->available) === 'yes' ? 'checked' : '' }} 
                                            onchange="confirmStatusChange({{ $service->id }}, '{{ addslashes($service->name) }}')"
                                            class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-900"></div>
                                    </label>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('management.services.edit', $service->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-purple-800 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('management.services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500 text-sm">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i data-lucide="folder-open" class="w-8 h-8 text-gray-400"></i>
                                    <span>No services found assigned to this category yet.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<script>
    function confirmStatusChange(serviceId, serviceName) {
        Swal.fire({
            title: 'Update Status?',
            text: `Are you sure you want to change the status for "${serviceName}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#581c87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`status-form-${serviceId}`).submit();
            } else {
                location.reload();
            }
        });
    }
</script>
@endsection
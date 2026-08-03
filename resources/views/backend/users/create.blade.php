
@extends('layouts.app')

@section('title', "Add New Staff | Bloom & Glow Mbita")

@section('content')
<section class="bg-white text-gray-900 overflow-hidden py-8 sm:py-12 lg:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                    <i data-lucide="user-plus" class="w-4 h-4 text-purple-600"></i>
                    <span>Access Control</span>
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    Add New Staff Member
                </h1>
            </div>
            <div>
                <a href="{{ route('management.users.index') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition-all text-sm font-['Outfit']">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Back to Staff List</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('management.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-purple-900 focus:ring-2 focus:ring-purple-900/20 focus:outline-none font-['Plus_Jakarta_Sans'] @error('name') border-red-500 @enderror"
                        placeholder="e.g. Jane Doe">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-purple-900 focus:ring-2 focus:ring-purple-900/20 focus:outline-none font-['Plus_Jakarta_Sans'] @error('phone') border-red-500 @enderror"
                        placeholder="e.g. 0712345678">
                    <p class="text-xs text-gray-400 font-['Plus_Jakarta_Sans']">Note: The phone number will automatically serve as the initial login password.</p>
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Assignment -->
                <div class="space-y-2">
                    <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 font-['Outfit']">Assign System Role</label>
                    <select name="role" id="role" required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-purple-900 focus:ring-2 focus:ring-purple-900/20 focus:outline-none font-['Plus_Jakarta_Sans'] bg-white @error('role') border-red-500 @enderror">
                        <option value="" disabled selected>Select role...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Action -->
                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="{{ route('management.users.index') }}" 
                        class="px-5 py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium font-['Outfit'] transition-all">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 rounded-xl bg-purple-900 hover:bg-purple-800 text-white text-sm font-medium font-['Outfit'] shadow-sm transition-all">
                        Save Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
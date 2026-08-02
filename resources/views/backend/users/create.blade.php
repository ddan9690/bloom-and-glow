@extends('layouts.app')

@section('title', "Add New User | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-12 lg:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                <i data-lucide="user-plus" class="w-4 h-4 text-purple-600"></i>
                <span>Team Management</span>
            </span>
            
            <h1 class="text-3xl sm:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                Add New <span class="text-purple-800">User Account</span>
            </h1>
            <p class="text-sm sm:text-base text-gray-600 font-['Plus_Jakarta_Sans'] mt-2">
                Provision a new administrator or staff member to securely manage the booking ecosystem.
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-10">
            
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                <div class="font-bold mb-1">Please fix the following errors:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                        placeholder="e.g. Brenda Akinyi">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                        placeholder="0712345678">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                        placeholder="Min. 6 characters">
                </div>

                <div>
                    <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-3">
                        Assign Role <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-purple-50/50 transition-all">
                            <input type="radio" name="role" value="Staff" {{ old('role', 'Staff') === 'Staff' ? 'checked' : '' }} class="text-purple-800 focus:ring-purple-800">
                            <div>
                                <span class="block text-sm font-bold text-gray-900">Staff</span>
                                <span class="block text-xs text-gray-500">View & update booking status</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-purple-50/50 transition-all">
                            <input type="radio" name="role" value="Admin" {{ old('role') === 'Admin' ? 'checked' : '' }} class="text-purple-800 focus:ring-purple-800">
                            <div>
                                <span class="block text-sm font-bold text-gray-900">Admin</span>
                                <span class="block text-xs text-gray-500">Full operational management</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-4 border-t border-gray-100">
                    <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3 rounded-xl shadow-sm transition-all text-sm">
                        <i data-lucide="user-check" class="w-4 h-4 text-purple-200"></i>
                        <span>Save User Account</span>
                    </button>
                </div>

            </form>

        </div>

    </div>
</section>
@endsection
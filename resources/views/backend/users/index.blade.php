@extends('layouts.app')

@section('title', "Manage Staff | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-12 lg:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6" data-aos="fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                    <i data-lucide="shield-check" class="w-4 h-4 text-purple-600"></i>
                    <span>Access Control & Team</span>
                </span>
                
                <h1 class="text-3xl sm:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    Staff <span class="text-purple-800">Management</span>
                </h1>
            </div>

            <!-- Trigger Button to Open Add User Modal/Drawer -->
            @can('manage users')
            <div>
                <button onclick="document.getElementById('addUserModal').classList.remove('hidden')" 
                    class="inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-6 py-3 rounded-xl transition-all shadow-sm text-sm">
                    <i data-lucide="user-plus" class="w-4 h-4 text-purple-200"></i>
                    <span>Add New User</span>
                </button>
            </div>
            @endcan
        </div>
    </div>
</section>

<!-- Notification Alerts -->
@if(session('success'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif

<!-- Users List Section -->
<section class="py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Responsive Card Container -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-bold font-['Outfit'] text-gray-900">Staff</h2>
            </div>

            <!-- Desktop Header Grid (Hidden on mobile) -->
            <div class="hidden lg:grid grid-cols-12 gap-4 px-6 py-3.5 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                <div class="col-span-1">#</div>
                <div class="col-span-4">Staff Details</div>
                <div class="col-span-2">Phone Number</div>
                <div class="col-span-2">Assigned Role</div>
                <div class="col-span-3 text-right">Actions</div>
            </div>

            <!-- List Body -->
            <div class="divide-y divide-gray-100">
                @forelse($users as $index => $user)
                <div class="p-6 hover:bg-purple-50/25 transition-colors flex flex-col lg:grid lg:grid-cols-12 lg:items-center gap-4">
                    
                    <!-- Index Number Column -->
                    <div class="lg:col-span-1 flex items-center gap-2">
                        <span class="lg:hidden font-semibold text-xs text-gray-400 uppercase">#</span>
                        <span class="text-sm font-bold text-gray-500 font-['Outfit']">
                            {{ method_exists($users, 'firstItem') ? $users->firstItem() + $index : $index + 1 }}
                        </span>
                    </div>

                    <!-- User Details -->
                    <div class="lg:col-span-4 flex items-center gap-3.5">
                        <div>
                            <h3 class="font-bold font-['Outfit'] text-gray-900 text-base">{{ $user->name }}</h3>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="lg:col-span-2 flex items-center gap-2 text-sm text-gray-600">
                        <span class="lg:hidden font-semibold text-xs text-gray-400 uppercase">Phone:</span>
                        <i data-lucide="phone" class="w-4 h-4 text-gray-400 lg:hidden"></i>
                        <span>{{ $user->phone }}</span>
                    </div>

                    <!-- Role Badge -->
                    <div class="lg:col-span-2 flex items-center gap-2">
                        <span class="lg:hidden font-semibold text-xs text-gray-400 uppercase">Role:</span>
                        @php
                            $roleName = $user->getRoleNames()->first() ?? 'User';
                            $badgeColor = match($roleName) {
                                'Super Admin' => 'bg-red-50 text-red-700 border-red-200',
                                'Admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                default => 'bg-blue-50 text-blue-700 border-blue-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $badgeColor }}">
                            {{ $roleName }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="lg:col-span-3 flex items-center justify-end gap-2 pt-3 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                        @can('update', $user)
                        <button onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->phone }}', '{{ $roleName }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-900 text-xs font-medium transition-all">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Edit</span>
                        </button>
                        @endcan

                        @can('delete', $user)
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium transition-all">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                        @endif
                        @endcan
                    </div>

                </div>
                @empty
                <div class="p-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 font-['Outfit']">No staff found</h3>
                    <p class="text-sm text-gray-500 mt-1">Get started by adding a new staff profile.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            @if(method_exists($users, 'links'))
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $users->links() }}
            </div>
            @endif
        </div>

    </div>
</section>

<!-- Add User Modal -->
<div id="addUserModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-xl border border-gray-100 relative animate-in fade-in zoom-in duration-200">
        
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
            <h3 class="text-xl font-bold font-['Outfit'] text-gray-900">Add New System User</h3>
            <button onclick="document.getElementById('addUserModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm bg-gray-50/50 outline-none" placeholder="e.g. Brenda Akinyi">
            </div>

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm bg-gray-50/50 outline-none" placeholder="0712345678">
            </div>

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm bg-gray-50/50 outline-none" placeholder="Min. 6 characters">
            </div>

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">Assign Role <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-gray-200 cursor-pointer hover:bg-purple-50/50 transition-all">
                        <input type="radio" name="role" value="Staff" checked class="text-purple-800 focus:ring-purple-800">
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Staff</span>
                            <span class="block text-xs text-gray-500">View & update bookings</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-gray-200 cursor-pointer hover:bg-purple-50/50 transition-all">
                        <input type="radio" name="role" value="Admin" class="text-purple-800 focus:ring-purple-800">
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Admin</span>
                            <span class="block text-xs text-gray-500">Full control & management</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('addUserModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-900 hover:bg-purple-800 text-white text-sm font-medium transition-all">Save User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-xl border border-gray-100 relative animate-in fade-in zoom-in duration-200">
        
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
            <h3 class="text-xl font-bold font-['Outfit'] text-gray-900">Edit System User</h3>
            <button onclick="document.getElementById('editUserModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editUserForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="edit_name" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" id="edit_phone" name="phone" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-1.5">Password <span class="text-xs text-gray-400 font-normal">(Leave blank to keep current)</span></label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm bg-gray-50/50 outline-none" placeholder="New password if changing">
            </div>

            <div>
                <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">Assign Role <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-gray-200 cursor-pointer hover:bg-purple-50/50 transition-all">
                        <input type="radio" id="edit_role_staff" name="role" value="Staff" class="text-purple-800 focus:ring-purple-800">
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Staff</span>
                            <span class="block text-xs text-gray-500">View & update bookings</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-gray-200 cursor-pointer hover:bg-purple-50/50 transition-all">
                        <input type="radio" id="edit_role_admin" name="role" value="Admin" class="text-purple-800 focus:ring-purple-800">
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Admin</span>
                            <span class="block text-xs text-gray-500">Full control & management</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('editUserModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-900 hover:bg-purple-800 text-white text-sm font-medium transition-all">Update Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, phone, role) {
        const form = document.getElementById('editUserForm');
        form.action = `/users/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_phone').value = phone;
        
        if (role === 'Staff') {
            document.getElementById('edit_role_staff').checked = true;
        } else if (role === 'Admin') {
            document.getElementById('edit_role_admin').checked = true;
        }
        
        document.getElementById('editUserModal').classList.remove('hidden');
    }
</script>
@endsection
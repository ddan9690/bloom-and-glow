@extends('layouts.app')

@section('title', "Staff Management | Bloom & Glow Mbita")

@section('content')
<section class="bg-white text-gray-900 overflow-hidden py-8 sm:py-12 lg:py-16 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-4">
                    <i data-lucide="users" class="w-4 h-4 text-purple-600"></i>
                    <span>Access Control</span>
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-['Outfit'] tracking-tight text-gray-900">
                    Staff Management
                </h1>
            </div>
            @php
                $currentUser = auth()->user();
                $canCreateUser = $currentUser->hasRole('Super Admin') || $currentUser->hasRole('Admin');
            @endphp
            @if($canCreateUser)
            <div>
                <a href="{{ route('management.users.create') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-5 py-3 rounded-xl transition-all shadow-sm text-sm font-['Outfit']">
                    <i data-lucide="user-plus" class="w-4 h-4 text-purple-200"></i>
                    <span>Add New Staff</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

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

<section class="py-8 sm:py-12 bg-gray-50/50 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($users as $user)
            @php
                $currentUser = auth()->user();
                $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');
                $isCurrentAdmin = $currentUser->hasRole('Admin');
                $isCurrentStaff = $currentUser->hasRole('Staff');
                
                $isTargetSuperAdmin = $user->hasRole('Super Admin');
                $isTargetAdmin = $user->hasRole('Admin');
                $isTargetStaff = $user->hasRole('Staff');
                
                // Determine if role selector should be shown
                $showRoleSelector = false;
                $availableRoles = collect();
                
                if ($isCurrentSuperAdmin) {
                    // Super Admin sees everything except cannot change own role via dropdown
                    if ($user->id !== $currentUser->id) {
                        $showRoleSelector = true;
                        $availableRoles = $roles;
                    }
                } elseif ($isCurrentAdmin) {
                    // Admin can only manage non-Super Admin users and not themselves
                    if (!$isTargetSuperAdmin && $user->id !== $currentUser->id) {
                        $showRoleSelector = true;
                        $availableRoles = $roles->filter(function($role) {
                            return in_array($role->name, ['Admin', 'Staff']);
                        });
                    }
                }
                // Staff sees NO role selector at all
                
                // Determine if delete button should be shown
                $showDelete = false;
                if ($isCurrentSuperAdmin) {
                    // Super Admin can delete anyone except themselves and other Super Admins
                    if (!$isTargetSuperAdmin && $user->id !== $currentUser->id) {
                        $showDelete = true;
                    }
                } elseif ($isCurrentAdmin) {
                    // Admin can only delete Staff users (not themselves, not other admins)
                    if ($isTargetStaff && $user->id !== $currentUser->id) {
                        $showDelete = true;
                    }
                }
                // Staff sees NO delete button
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-all">
                <div class="space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 font-['Outfit'] text-base">{{ $user->name }}</h3>
                            <p class="text-xs text-gray-500 font-['Plus_Jakarta_Sans'] flex items-center gap-1.5 mt-0.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-gray-400"></i>
                                <span>{{ $user->phone }}</span>
                            </p>
                        </div>
                        @if($isTargetSuperAdmin)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <i data-lucide="shield" class="w-3 h-3 mr-1"></i>
                            Super Admin
                        </span>
                        @elseif($isTargetAdmin)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i data-lucide="user-check" class="w-3 h-3 mr-1"></i>
                            Admin
                        </span>
                        @elseif($isTargetStaff)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i data-lucide="user" class="w-3 h-3 mr-1"></i>
                            Staff
                        </span>
                        @endif
                    </div>

                    <!-- Role Selector - Only shown when conditions are met -->
                    @if($showRoleSelector && $availableRoles->count() > 0)
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500 font-['Outfit']">Role:</span>
                        <select onchange="confirmRoleChange({{ $user->id }}, this.value, '{{ addslashes($user->name) }}')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-purple-200 bg-purple-50/50 text-purple-900 focus:ring-2 focus:ring-purple-900 focus:outline-none font-['Plus_Jakarta_Sans'] cursor-pointer">
                            @foreach($availableRoles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-end">
                    @if($showDelete)
                    <form action="{{ route('management.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                            <i data-lucide="trash-2" class="w-3 h-3"></i> Remove
                        </button>
                    </form>
                    @elseif($user->id === $currentUser->id)
                    <span class="text-[11px] font-medium text-purple-700 bg-purple-50 px-2 py-0.5 rounded">Current Account</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-gray-500 text-sm bg-white rounded-2xl border border-gray-200">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                    <span>No users found.</span>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    function confirmRoleChange(userId, newRole, userName) {
        Swal.fire({
            title: 'Change User Role?',
            text: `Are you sure you want to assign the role "${newRole}" to ${userName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#581c87',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('management/users') }}/${userId}/role`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ role: newRole })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#581c87'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                        location.reload();
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Network error occurred.', 'error');
                    location.reload();
                });
            } else {
                location.reload();
            }
        });
    }
</script>
@endsection
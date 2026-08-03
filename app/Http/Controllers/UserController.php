<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->get();

        // Filter roles based on current user's permissions
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');

        if ($isCurrentSuperAdmin) {
            $roles = Role::all();
        } else {
            // Admins can only see Admin and Staff roles
            $roles = Role::whereIn('name', ['Admin', 'Staff'])->get();
        }

        return view('backend.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');

        if ($isCurrentSuperAdmin) {
            $roles = Role::all();
        } else {
            // Admins can only assign Admin and Staff roles
            $roles = Role::whereIn('name', ['Admin', 'Staff'])->get();
        }

        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');

        // Prevent non-super-admins from creating a super-admin user
        if ($validated['role'] === 'Super Admin' && !$isCurrentSuperAdmin) {
            return back()->withInput()->with('error', 'Unauthorized action. Only the System Developer (Super Admin) can assign Super Admin privileges.');
        }

        // Prevent admins from creating admin users (they can only create staff)
        if (!$isCurrentSuperAdmin && $validated['role'] === 'Admin') {
            return back()->withInput()->with('error', 'Unauthorized action. Only Super Admin can create Admin accounts.');
        }

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['phone']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('management.users.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Update the specified user's role inline.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');
        $isCurrentAdmin = $currentUser->hasRole('Admin');
        $isTargetSuperAdmin = $user->hasRole('Super Admin');
        $isTargetAdmin = $user->hasRole('Admin');
        $isTargetStaff = $user->hasRole('Staff');

        // 1. SUPER ADMIN CHECKS
        if ($isCurrentSuperAdmin) {
            // Super Admin can do anything except demote themselves
            if ($user->id === $currentUser->id && $validated['role'] !== 'Super Admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own Super Admin role.'
                ], 403);
            }

            $user->syncRoles([$validated['role']]);

            return response()->json([
                'success' => true,
                'message' => "Role updated successfully to {$validated['role']}."
            ]);
        }

        // 2. ADMIN CHECKS
        if ($isCurrentAdmin) {
            // Admin CANNOT modify Super Admin accounts
            if ($isTargetSuperAdmin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action. You cannot modify a Super Admin account.'
                ], 403);
            }

            // Admin CANNOT assign Super Admin role
            if ($validated['role'] === 'Super Admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action. Only the System Developer can assign Super Admin privileges.'
                ], 403);
            }

            // Admin CANNOT change their OWN role
            if ($user->id === $currentUser->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own role.'
                ], 403);
            }

            // Admin can only assign Admin or Staff roles
            if (!in_array($validated['role'], ['Admin', 'Staff'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action. You can only assign Admin or Staff roles.'
                ], 403);
            }

            // Admin can promote Staff to Admin
            if ($isTargetStaff && $validated['role'] === 'Admin') {
                $user->syncRoles([$validated['role']]);
                return response()->json([
                    'success' => true,
                    'message' => "Staff promoted to Admin successfully."
                ]);
            }

            // Admin can demote Admin to Staff
            if ($isTargetAdmin && $validated['role'] === 'Staff') {
                $user->syncRoles([$validated['role']]);
                return response()->json([
                    'success' => true,
                    'message' => "Admin demoted to Staff successfully."
                ]);
            }

            // If trying to change to same role or invalid combination
            if ($isTargetStaff && $validated['role'] === 'Staff') {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already a Staff member.'
                ], 403);
            }

            if ($isTargetAdmin && $validated['role'] === 'Admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already an Admin.'
                ], 403);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid role change operation.'
            ], 403);
        }

        // 3. STAFF CHECKS - Staff cannot change any roles
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized action. You do not have permission to manage roles.'
        ], 403);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');
        $isCurrentAdmin = $currentUser->hasRole('Admin');
        $isTargetSuperAdmin = $user->hasRole('Super Admin');

        // Super Admin cannot edit themselves through this route (they should use update)
        if ($isCurrentSuperAdmin && $user->id === $currentUser->id) {
            return redirect()->route('management.users.index')->with('error', 'Use the role selector to manage your account.');
        }

        // Admin cannot edit Super Admin accounts
        if ($isTargetSuperAdmin && !$isCurrentSuperAdmin) {
            return redirect()->route('management.users.index')->with('error', 'Unauthorized action. You cannot edit a Super Admin account.');
        }

        // Admin cannot edit their own account through this route
        if ($isCurrentAdmin && $user->id === $currentUser->id) {
            return redirect()->route('management.users.index')->with('error', 'You cannot edit your own account.');
        }

        if ($isCurrentSuperAdmin) {
            $roles = Role::all();
        } else {
            // Admins can only see Admin and Staff roles
            $roles = Role::whereIn('name', ['Admin', 'Staff'])->get();
        }

        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');
        $isCurrentAdmin = $currentUser->hasRole('Admin');
        $isTargetSuperAdmin = $user->hasRole('Super Admin');

        // Super Admin cannot edit themselves through this route
        if ($isCurrentSuperAdmin && $user->id === $currentUser->id) {
            return redirect()->route('management.users.index')->with('error', 'Use the role selector to manage your account.');
        }

        // Admin cannot edit Super Admin accounts
        if ($isTargetSuperAdmin && !$isCurrentSuperAdmin) {
            return redirect()->route('management.users.index')->with('error', 'Unauthorized action. You cannot modify a Super Admin account.');
        }

        // Admin cannot edit their own account through this route
        if ($isCurrentAdmin && $user->id === $currentUser->id) {
            return redirect()->route('management.users.index')->with('error', 'You cannot edit your own account.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        // Super Admin can assign any role
        if ($isCurrentSuperAdmin) {
            $user->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);
            $user->syncRoles([$validated['role']]);

            return redirect()->route('management.users.index')
                ->with('success', 'User updated successfully.');
        }

        // Admin role validation
        if ($isCurrentAdmin) {
            if ($validated['role'] === 'Super Admin') {
                return back()->withInput()->with('error', 'Unauthorized action. Only the System Developer can assign Super Admin privileges.');
            }

            if (!in_array($validated['role'], ['Admin', 'Staff'])) {
                return back()->withInput()->with('error', 'Unauthorized action. You can only assign Admin or Staff roles.');
            }

            $user->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);
            $user->syncRoles([$validated['role']]);

            return redirect()->route('management.users.index')
                ->with('success', 'User updated successfully.');
        }

        return redirect()->route('management.users.index')
            ->with('error', 'Unauthorized action.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = $currentUser->hasRole('Super Admin');
        $isCurrentAdmin = $currentUser->hasRole('Admin');
        $isTargetSuperAdmin = $user->hasRole('Super Admin');
        $isTargetAdmin = $user->hasRole('Admin');

        // Cannot delete Super Admin
        if ($isTargetSuperAdmin) {
            return back()->with('error', 'Critical security error: The System Developer account cannot be removed.');
        }

        // Cannot delete yourself
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Admin cannot delete other Admin accounts
        if ($isCurrentAdmin && $isTargetAdmin) {
            return back()->with('error', 'Unauthorized action. You cannot delete Admin accounts.');
        }

        // Admin can only delete Staff accounts
        if ($isCurrentAdmin && !$user->hasRole('Staff')) {
            return back()->with('error', 'Unauthorized action. You can only delete Staff accounts.');
        }

        // Staff cannot delete anyone
        if (!$isCurrentSuperAdmin && !$isCurrentAdmin) {
            return back()->with('error', 'Unauthorized action. You do not have permission to delete users.');
        }

        $user->delete();

        return redirect()->route('management.users.index')
            ->with('success', 'User deleted successfully.');
    }
}

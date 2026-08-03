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
        $roles = Role::all();

        return view('backend.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
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
        $isCurrentSuperAdmin = method_exists($currentUser, 'hasRole') && $currentUser->hasRole('super-admin');

        // Prevent non-super-admins from creating a super-admin user
        if ($validated['role'] === 'super-admin' && !$isCurrentSuperAdmin) {
            return back()->withInput()->with('error', 'Unauthorized action. Only the System Developer (Super Admin) can assign Super Admin privileges.');
        }

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['phone']), // Password becomes the phone number
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')
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
        $isCurrentSuperAdmin = method_exists($currentUser, 'hasRole') && $currentUser->hasRole('super-admin');
        $isTargetSuperAdmin = method_exists($user, 'hasRole') && $user->hasRole('super-admin');

        // Prevent modifying a Super Admin account unless the current user is a Super Admin
        if ($isTargetSuperAdmin && !$isCurrentSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action. You cannot modify a Super Admin account.'
            ], 403);
        }

        // Prevent assigning Super Admin role unless the current user is a Super Admin
        if ($validated['role'] === 'super-admin' && !$isCurrentSuperAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action. Only the System Developer can assign Super Admin privileges.'
            ], 403);
        }

        $user->syncRoles([$validated['role']]);

        return response()->json([
            'success' => true,
            'message' => "Role updated successfully to {$validated['role']}."
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = method_exists($currentUser, 'hasRole') && $currentUser->hasRole('super-admin');
        $isTargetSuperAdmin = method_exists($user, 'hasRole') && $user->hasRole('super-admin');

        if ($isTargetSuperAdmin && !$isCurrentSuperAdmin) {
            return redirect()->route('users.index')->with('error', 'Unauthorized action. You cannot edit a Super Admin account.');
        }

        $roles = Role::all();
        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        $isCurrentSuperAdmin = method_exists($currentUser, 'hasRole') && $currentUser->hasRole('super-admin');
        $isTargetSuperAdmin = method_exists($user, 'hasRole') && $user->hasRole('super-admin');

        if ($isTargetSuperAdmin && !$isCurrentSuperAdmin) {
            return redirect()->route('users.index')->with('error', 'Unauthorized action. You cannot modify a Super Admin account.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        if ($validated['role'] === 'super-admin' && !$isCurrentSuperAdmin) {
            return back()->withInput()->with('error', 'Unauthorized action. Only the System Developer can assign Super Admin privileges.');
        }

        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')
            ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();
        $isTargetSuperAdmin = method_exists($user, 'hasRole') && $user->hasRole('super-admin');

        if ($isTargetSuperAdmin) {
            return back()->with('error', 'Critical security error: The System Developer account cannot be removed.');
        }

        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot delete your own active administrative account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Staff member deleted successfully.');
    }
}

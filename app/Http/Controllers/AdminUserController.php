<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.adminusers', [
            'admins' => $admins,
            'role' => 'admin',
        ]);
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('admin.createadmin', [
            'role' => 'admin',
        ]);
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'lastname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ], [
            'firstname.regex' => 'First name should only contain letters and spaces.',
            'lastname.regex' => 'Last name should only contain letters and spaces.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 8 characters.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpeg, jpg, png, gif, webp.',
            'avatar.max' => 'The image may not be greater than 5MB.',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $admin = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'avatar' => $avatarPath,
            'verified' => true,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Admin '{$admin->name}' has been created successfully.");
    }

    /**
     * Display the specified admin.
     */
    public function show(User $user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'This user is not an admin.');
        }

        return view('admin.showadmin', [
            'admin' => $user,
            'role' => 'admin',
        ]);
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(User $user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'This user is not an admin.');
        }

        return view('admin.editadmin', [
            'admin' => $user,
            'role' => 'admin',
        ]);
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'This user is not an admin.');
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'lastname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'is_active' => 'boolean',
        ], [
            'firstname.regex' => 'First name should only contain letters and spaces.',
            'lastname.regex' => 'Last name should only contain letters and spaces.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 8 characters.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpeg, jpg, png, gif, webp.',
            'avatar.max' => 'The image may not be greater than 5MB.',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle password update
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "Admin '{$user->name}' has been updated successfully.");
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'This user is not an admin.');
        }

        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Delete avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Admin '{$userName}' has been deleted successfully.");
    }

    /**
     * Toggle admin active status
     */
    public function toggleStatus(User $user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'This user is not an admin.');
        }

        // Prevent deactivating yourself
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot deactivate your own account.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.users.index')
            ->with('success', "Admin '{$user->name}' has been {$status}.");
    }
}


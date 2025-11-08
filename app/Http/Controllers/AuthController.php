<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // -------------------------------
    // LOGIN PAGE
    // -------------------------------
    public function showLogin()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'donor' => redirect()->route('donor.page'),
                'student' => redirect()->route('user.page'),
                default => redirect()->route('loginpage'),
            };
        }

        return view('auth.loginpage');
    }

    // -------------------------------
    // SIGNUP PAGE
    // -------------------------------
    public function showSignup()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'donor' => redirect()->route('donor.page'),
                'student' => redirect()->route('user.page'),
                default => redirect()->route('loginpage'),
            };
        }

        return view('auth.signup');
    }

    // -------------------------------
    // LOGIN FUNCTION
    // -------------------------------
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'donor' => redirect()->route('donor.page'),
                'student' => redirect()->route('user.page'),
                default => redirect()->route('loginpage'),
            };
        }

        // Invalid credentials
        throw ValidationException::withMessages([
            'email' => 'Invalid email or password.',
        ]);
    }

    // -------------------------------
    // LOGOUT FUNCTION
    // -------------------------------
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('loginpage');
    }

    // -------------------------------
    // REGISTER FUNCTION
    // -------------------------------
    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Student,Donor,Admin',
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => strtolower($validated['role']),
        ]);

        Auth::login($user);

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'donor' => redirect()->route('donor.page'),
            'student' => redirect()->route('user.page'),
            default => redirect()->route('loginpage'),
        };
    }
}

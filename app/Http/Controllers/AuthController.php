<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.loginpage');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Update last login
            $user = Auth::user();
            $user->update(['last_login' => now()]);

            return match ($user->role) {
                'admin' => redirect()->route('admin.admindashboard')->with('success', 'Welcome back, ' . $user->firstname . '!'),
                'donor' => redirect()->route('donor.page')->with('success', 'Welcome back, ' . $user->firstname . '!'),
                'student' => redirect()->route('user.page')->with('success', 'Welcome back, ' . $user->firstname . '!'),
                default => redirect()->route('login'),
            };
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'lastname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Student,Donor',
        ], [
            'firstname.regex' => 'First name should only contain letters and spaces.',
            'lastname.regex' => 'Last name should only contain letters and spaces.',
            'role.in' => 'Please select a valid account type (Student or Donor).',
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => strtolower($validated['role']),
        ]);

        Auth::login($user);

        // Only allow Student and Donor roles to register
        return match ($user->role) {
            'donor' => redirect()->route('donor.page'),
            'student' => redirect()->route('user.page'),
            default => redirect()->route('login'),
        };
    }
}

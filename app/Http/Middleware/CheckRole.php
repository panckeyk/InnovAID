<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role The required role (e.g., 'student', 'admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }
        
        // 2. Check if the user's role matches the required role
        if (Auth::user()->role !== $role) {
            // Redirect to the home page or a 403 forbidden page
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
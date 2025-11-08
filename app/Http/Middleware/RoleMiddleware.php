<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // ✅ Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('loginpage');
        }

        $user = Auth::user();
        $currentRoute = $request->route()->getName();

        // ✅ If user’s role matches the required role, continue
        if ($user->role === $role) {
            return $next($request);
        }

        // ✅ Shared routes that everyone can access (prevent redirection loops)
        $sharedRoutes = ['campaign.page'];

        if (in_array($currentRoute, $sharedRoutes)) {
            return $next($request);
        }

        // ✅ Redirect to proper dashboard based on user’s role
        return match ($user->role) {
            'admin' => in_array($currentRoute, ['admin.dashboard', 'admin.page', 'admin.profile'])
                ? $next($request)
                : redirect()->route('admin.page'),

            'donor' => in_array($currentRoute, ['donor.page', 'donor.profile'])
                ? $next($request)
                : redirect()->route('donor.page'),

            'student' => in_array($currentRoute, ['user.page', 'user.profile', 'user.campaign', 'create.page'])
                ? $next($request)
                : redirect()->route('user.page'),

            default => redirect()->route('loginpage'),
        };
    }
}

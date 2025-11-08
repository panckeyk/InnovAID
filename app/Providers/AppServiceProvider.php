<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/'; // ⬅️ You can change this to your default user dashboard path if needed (e.g., '/user/dashboard')

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // Apply a global prefix to all routes defined in your API routes file
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Apply the 'web' middleware group to all routes defined in your web routes file
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        // ✅ Share $role with all Blade views globally
        View::composer('*', function ($view) {
            $role = Auth::check() ? Auth::user()->role : null;
            $view->with('role', $role);
        });
    }
}
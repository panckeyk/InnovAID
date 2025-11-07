<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Share $role with all Blade views globally
        View::composer('*', function ($view) {
            $role = Auth::check() ? Auth::user()->role : null;
            $view->with('role', $role);
        });
    }
}

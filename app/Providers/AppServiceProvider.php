<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; 
use App\Http\Middleware\RoleMiddleware; 
use App\Http\Middleware\AdminMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
    }


    public function boot(): void
    {
        Route::aliasMiddleware('admin', AdminMiddleware::class);
        Route::model('campaign', \App\Models\Campaign::class); 
    }
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ---------- AUTH ROUTES ----------
Route::get('/', [AuthController::class, 'showLogin'])->name('loginpage');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signuppage');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- AUTHENTICATED ROUTES ----------
Route::middleware('auth')->group(function () {

    // ---------- USER ROUTES (General) ----------
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'layout'])->name('user.page');
        Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    });

    // ---------- ADMIN ROUTES ----------
    Route::middleware('role:admin')->group(function () {
        Route::get('/', fn() => view('admin.adminlayoutpage'))->name('admin.page');
        Route::get('/dashboard', fn() => view('admin.admindashboard'))->name('admin.dashboard');
        Route::get('/profile', fn() => view('admin.adminprofilepage'))->name('admin.profile');
    });

    // ---------- DONOR ROUTES ----------
    Route::prefix('donor')->group(function () {
        Route::get('/', fn() => view('donor.donorlayoutpage'))->name('donor.page');
        Route::get('/profile', fn() => view('donor.donorprofilepage'))->name('donor.profile');
    });
    
    // ------------------------------------------------------------------------
    // ---------- CAMPAIGN ROUTES (REVISED BLOCK FOR CRUD) --------------------
    // ------------------------------------------------------------------------
    Route::get('/campaigns/{campaign}', [CampaignsController::class, 'show'])->name('campaigns.show');

    Route::middleware('role:student')->group(function () {
        Route::get('/user/my-campaigns', [UserController::class, 'campaigns'])->name('user.campaign');
        Route::resource('campaigns', CampaignsController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/user/create-campaign', [CampaignsController::class, 'create'])->name('user.createcampaign');
    });

});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\Admin\CampaignReviewController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminUserController;
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
        Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    });

    // ---------- ADMIN ROUTES ----------
    Route::middleware('role:admin')->group(function () {
        // Dashboard & Profile (using your existing method names)
        //Route::get('/', [AdminController::class, 'layout'])->name('admin.page');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.admindashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/admin/campaigns/{campaign}/approve', [AdminController::class, 'approve'])->name('admin.campaigns.approve');
        Route::post('/admin/campaigns/{campaign}/reject', [AdminController::class, 'reject'])->name('admin.campaigns.reject');
        Route::get('/approved', [AdminController::class, 'layout'])->name('approved.index');
        Route::get('/admin/campaigns/{id}', [AdminController::class, 'showCampaignDetails'])->name('admin.campaign.details');

        // Campaign Review Routes - Using different path to avoid conflict
        Route::get('/admin/review/campaigns', [CampaignReviewController::class, 'index'])->name('admin.campaigns.index');
        Route::get('/admin/review/campaigns/{campaign}', [CampaignReviewController::class, 'show'])->name('admin.campaigns.show');

        // Admin User Management Routes
        Route::resource('admin/users', AdminUserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        Route::post('/admin/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    });

    // ---------- DONOR ROUTES ----------
    Route::middleware('role:donor')->group(function () {
        Route::get('/', [DonorController::class, 'index'])->name('donor.page');
        Route::get('/profile', [DonorController::class, 'profile'])->name('donor.profile');
        Route::get('/campaigns/{campaign}/donate', [DonorController::class, 'create'])->name('donor.create');
        Route::post('/campaigns/{campaign}/donate', [DonorController::class, 'store'])->name('donor.store');
        Route::put('/profile/update', [DonorController::class, 'updateProfile'])->name('donor.profile.update'); // ADD THIS LINE

    });

    // ------------------------------------------------------------------------
    // ---------- CAMPAIGN ROUTES (REVISED BLOCK FOR CRUD) --------------------
    // ------------------------------------------------------------------------
    Route::middleware('role:student')->group(function () {
        Route::get('/user/my-campaigns', [UserController::class, 'campaigns'])->name('user.campaign');
        Route::resource('campaigns', CampaignsController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/user/create-campaign', [CampaignsController::class, 'create'])->name('user.createcampaign');
    });
});

// ---------- PUBLIC CAMPAIGN ROUTE (Allow guests to view campaigns) ----------
// This route must be AFTER authenticated routes to avoid conflicts
Route::get('/campaigns/{campaign}', [CampaignsController::class, 'show'])->name('campaigns.show');
Route::post('/campaigns/{campaign}/comments', [CommentController::class, 'store'])->middleware('auth')->name('campaigns.comments.store');

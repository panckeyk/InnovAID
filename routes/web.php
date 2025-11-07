<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignController;

// Auth
Route::get('/', [AuthController::class, 'showLogin'])->name('loginpage');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signuppage');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

 // Campaign Page
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'showCampaignPage'])->name('campaigns.showCampaignPage'); // so campagins will be visible even if not yet logged in

//Middleware
Route::middleware(['auth', 'role:student'])->group(function () {

    // User routes
    Route::get('/user', fn() => view('user.userlayoutpage'))->name('user.page');
    Route::get('/user/mycampaign', fn() => view('user.usermycampaignpage'))->name('user.campaign');
    Route::get('/create', fn() => view('user.usercreatecampaignpage'))->name('create.page');
    Route::get('/profile', fn() => view('user.userprofilepage'))->name('user.profile');
    Route::get('/my-campaigns', [CampaignController::class, 'index'])->name('user.campaign');
    Route::post('/campaign/store', [CampaignController::class, 'store'])->name('campaign.store');

    // Admin routes
    Route::get('/admin', fn() => view('admin.adminlayoutpage'))->name('admin.page');
    Route::get('/admin/dashboard', fn() => view('admin.admindashboard'))->name('admin.dashboard');
    Route::get('/admin/profile', fn() => view('admin.adminprofilepage'))->name('admin.profile');

    // Donor routes
    Route::get('/donor', fn() => view('donor.donorlayoutpage'))->name('donor.page');
    Route::get('/donor/profile', fn() => view('donor.donorprofilepage'))->name('donor.profile');

   


});








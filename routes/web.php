<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('loginpage');
})->name('loginpage');


Route::get('/user', function () {
    return view('user.userlayoutpage');
})->name('user.page');

Route::get('/admin', function () {
    return view('admin.adminlayoutpage');
})->name('admin.page');


Route::get('/admin/dashboard', function () {
    return view('admin.admindashboard');
})->name('admin.dashboard');


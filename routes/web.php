<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('loginpage');
})->name('loginpage');


Route::get('/user', function () {
    return view('user.userlayoutpage');
})->name('user.page');

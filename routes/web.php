<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::get('/auth/signup', function () {
    return view('auth.signup');
});

Route::get('/dashboard', function () {
    return view('dashboard.overview');
});

Route::get('/dashboard/transfer', function () {
    return view('dashboard.transfer');
});

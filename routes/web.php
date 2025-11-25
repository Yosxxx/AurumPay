<?php

use App\Http\Controllers\RecipientController;
use App\Http\Controllers\TransactionController;
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

Route::get('/dashboard/recipients', [RecipientController::class, 'index'])
    ->name('recipients.index');

Route::get('/dashboard/qrscan', function () {
    return view('dashboard.qrscan');
})->name('dashboard.qrscan');

Route::get('/dashboard/activity', [TransactionController::class, 'index'])
    ->name('activity.index');

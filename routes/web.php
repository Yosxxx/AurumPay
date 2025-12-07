<?php

use App\Http\Controllers\RecipientController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// guest route for people not logged in
Route::middleware('guest')->group(function() {
    Route::get('/auth/login', function () { return view('auth.login'); })->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/auth/signup', function () { return view('auth.signup'); })->name('signup');
    Route::post('/auth/signup', [AuthController::class, 'register'])->name('signup.post');
});

// auth route for people who are logged in
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/dashboard/funds', [TransactionController::class, 'handleFunds'])->name('funds.update');

    Route::get('/', function () {
        return redirect()->route('dashboard.overview');
    });

    Route::get('/dashboard', [TransactionController::class, 'overview'])
        ->name('dashboard.overview');

    Route::get('/dashboard/transfer', function () {
        return view('dashboard.transfer');
    })->name('transfer.view');

    Route::post('/dashboard/transfer', [TransactionController::class, 'transfer'])
        ->name('transfer.post');

    Route::get('/dashboard/recipients', [RecipientController::class, 'index'])
        ->name('recipients.index');

    Route::get('/dashboard/qrscan', function () {
        return view('dashboard.qrscan');
    })->name('dashboard.qrscan');

    Route::get('/dashboard/activity', [TransactionController::class, 'index'])
        ->name('activity.index');

    Route::get('/dashboard/profile', function () {
        return view('dashboard.profile');
    })->name('profile.view');

    Route::post('/dashboard/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/dashboard/recipients', [RecipientController::class, 'store'])
        ->name('recipients.store');

    Route::post('/dashboard/recipients/verify', [RecipientController::class, 'verify'])
        ->name('recipients.verify');
    
});
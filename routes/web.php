<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('applications.index');
    })->name('dashboard');

    Route::resource('applications', ApplicationController::class)->except(['show']);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
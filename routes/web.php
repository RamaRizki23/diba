<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Models\Application;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $stats = [
            'total' => Application::count(),
            'active' => Application::where('status', 'Aktif')->count(),
            'development' => Application::where('status', 'Dalam Pengembangan')->count(),
            'owners' => Application::whereNotNull('owner')->distinct('owner')->count('owner'),
        ];

        $latestApplications = Application::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'latestApplications'));
    })->name('dashboard');

    Route::resource('applications', ApplicationController::class)->except(['show']);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
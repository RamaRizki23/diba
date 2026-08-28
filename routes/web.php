<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MasterDataController;

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
    Route::get('/applications/pdf', [ApplicationController::class, 'pdfIndex'])->name('applications.pdf.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::get('/applications/{application}/pdf', [ApplicationController::class, 'pdf'])->name('applications.pdf');
    Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');
    Route::get('/master-data/{type}/create', [MasterDataController::class, 'create'])->name('master-data.create');
    Route::get('/master-data/{type}', [MasterDataController::class, 'category'])->name('master-data.category');
    Route::post('/master-data/{type}', [MasterDataController::class, 'store'])->name('master-data.store');
    Route::get('/master-data/{type}/{masterDatum}/edit', [MasterDataController::class, 'edit'])->name('master-data.edit');
    Route::put('/master-data/{type}/{masterDatum}', [MasterDataController::class, 'update'])->name('master-data.update');
    Route::delete('/master-data/{type}/{masterDatum}', [MasterDataController::class, 'destroy'])->name('master-data.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
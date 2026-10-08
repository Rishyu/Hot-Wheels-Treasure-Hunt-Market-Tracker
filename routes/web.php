<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAdministrator;
use App\Http\Controllers\CarController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::view('/admin', 'admin.index')
    ->middleware(['auth', EnsureUserIsAdministrator::class])
    ->name('admin.index');

require __DIR__.'/settings.php';

Route::middleware('auth')->group(function () {
    Route::get('/cars', [CarController::class, 'index'])
        ->name('cars.index');

    Route::get('/cars/{car}', [CarController::class, 'show'])
        ->name('cars.show');
});
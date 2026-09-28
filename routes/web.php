<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAdministrator;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::view('/admin', 'admin.index')
    ->middleware(['auth', EnsureUserIsAdministrator::class])
    ->name('admin.index');

require __DIR__.'/settings.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsAdministrator;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PriceSubmissionController;
use App\Http\Controllers\AdminPricingController;
use App\Http\Controllers\AdminCarController;
use App\Http\Controllers\AdminLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');
});

Route::get(
    '/admin',
    [AdminDashboardController::class, 'index']
)
    ->middleware(['auth', EnsureUserIsAdministrator::class])
    ->name('admin.index');

require __DIR__.'/settings.php';


/*
|--------------------------------------------------------------------------
| Collector Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/cars', [CarController::class, 'index'])
        ->name('cars.index');

    Route::get('/cars/{car}', [CarController::class, 'show'])
        ->name('cars.show');

    Route::post('/cars/{car}/favorite', [CarController::class, 'favorite'])
        ->name('cars.favorite');

    Route::delete('/cars/{car}/favorite', [CarController::class, 'unfavorite'])
        ->name('cars.unfavorite');

    Route::post(
        '/cars/{car}/pricing',
        [PriceSubmissionController::class, 'store']
    )->name('cars.pricing.store');
});


/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    EnsureUserIsAdministrator::class,
])->prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Pricing Approval
    |--------------------------------------------------------------------------
    */

    Route::get('/pricing', [AdminPricingController::class, 'index'])
        ->name('pricing.index');

    Route::patch(
        '/pricing/{submission}/approve',
        [AdminPricingController::class, 'approve']
    )->name('pricing.approve');

    Route::patch(
        '/pricing/{submission}/reject',
        [AdminPricingController::class, 'reject']
    )->name('pricing.reject');


    /*
    |--------------------------------------------------------------------------
    | Car Management
    |--------------------------------------------------------------------------
    */

    Route::get('/cars', [AdminCarController::class, 'index'])
        ->name('cars.index');

    Route::get('/cars/create', [AdminCarController::class, 'create'])
        ->name('cars.create');

    Route::post('/cars', [AdminCarController::class, 'store'])
        ->name('cars.store');

    Route::get('/cars/{car}/edit', [AdminCarController::class, 'edit'])
        ->name('cars.edit');

    Route::put('/cars/{car}', [AdminCarController::class, 'update'])
        ->name('cars.update');

    Route::delete('/cars/{car}', [AdminCarController::class, 'destroy'])
        ->name('cars.destroy');

    /*
    |--------------------------------------------------------------------------
    | Error Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/logs', [AdminLogController::class, 'index'])
    ->name('logs.index');
});
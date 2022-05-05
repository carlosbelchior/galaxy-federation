<?php

use App\Http\Controllers\AddController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TravelsController;
use Illuminate\Support\Facades\Route;

// Add routers
Route::prefix('add')->group(function () {
    // Add pilots
    Route::post('/pilot', [AddController::class, 'pilots']);
    // Add ships
    Route::post('/ship', [AddController::class, 'ships']);
    // Publish contracts
    Route::post('/contracts', [AddController::class, 'contracts']);
});

// Travels routers
Route::prefix('travels')->group(function () {
    // New travel
    Route::post('/new', [TravelsController::class, 'new']);

    /*
     * For more routers travels controller add here
     */
});

// Contracts routers
Route::prefix('contracts')->group(function () {
    // List all contracts
    Route::get('/all', [ContractsController::class, 'all']);
    // Accept new contracts
    Route::post('/new', [ContractsController::class, 'new']);

    /*
     * For more routers contracts controller add here
     */
});

// Credits routers
Route::prefix('credits')->group(function () {
    // New travel
    Route::post('/pay', [CreditsController::class, 'pay']);

    /*
     * For more routers credits controller add here
     */
});

// Fuel routers
Route::prefix('fuel')->group(function () {
    // New travel
    Route::post('/buy', [FuelController::class, 'buy']);

    /*
     * For more routers fuel controller add here
     */
});

// Reports routers
Route::prefix('reports')->group(function () {
    // New travel
    Route::get('/all', [ReportsController::class, 'all']);

    /*
     * For more routers reports controller add here
     */
});
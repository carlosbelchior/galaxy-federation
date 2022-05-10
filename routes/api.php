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
    // Accept new contract
    Route::get('/accept/{id}', [ContractsController::class, 'accept']);
    // Complete contract
    Route::get('/finish/{id}', [ContractsController::class, 'finish']);

    /*
     * For more routers contracts controller add here
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
    // Resource by planet
    Route::get('/resource-planet', [ReportsController::class, 'resourcePlanet']);
    // Resource by pilot
    Route::get('/resource-pilot', [ReportsController::class, 'resourcePilot']);
    // Transactions log
    Route::get('/transactions', [ReportsController::class, 'transactions']);
    // Pilots
    Route::get('/pilots', [ReportsController::class, 'pilots']);
    // Ships
    Route::get('/ships', [ReportsController::class, 'ships']);
    // Travels
    Route::get('/travels', [ReportsController::class, 'travels']);
    // Routers available
    Route::get('/routers', [ReportsController::class, 'routers']);
    // Contracts finish
    Route::get('/contracts', [ReportsController::class, 'contracts']);
    // Contracts by pilot
    Route::get('/contracts-pilot/{pilot_certification}', [ReportsController::class, 'contracts_pilot']);

    /*
     * For more routers reports controller add here
     */
});

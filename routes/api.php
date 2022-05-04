<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Add routers
Route::prefix('add')->group(function () {
    // Add pilots
    Route::post('/pilots', 'AddController@pilots');
    // Add ships
    Route::post('/ships', 'AddController@ships');
    // Publish contracts
    Route::post('/contracts', 'AddController@contracts');
});

// Travels routers
Route::prefix('travels')->group(function () {
    // New travel
    Route::post('/new', 'TravelsController@new');

    /*
     * For more routers travels controller add here
     */
});

// Contracts routers
Route::prefix('contracts')->group(function () {
    // List all contracts
    Route::get('/all', 'ContractsController@all');
    // Accept new contracts
    Route::post('/new', 'ContractsController@new');

    /*
     * For more routers contracts controller add here
     */
});

// Credits routers
Route::prefix('credits')->group(function () {
    // New travel
    Route::post('/pay', 'CreditsController@pay');

    /*
     * For more routers credits controller add here
     */
});

// Fuel routers
Route::prefix('fuel')->group(function () {
    // New travel
    Route::post('/buy', 'FuelController@buy');

    /*
     * For more routers fuel controller add here
     */
});

// Reports routers
Route::prefix('reports')->group(function () {
    // New travel
    Route::post('/new', 'ReportsController@new');

    /*
     * For more routers reports controller add here
     */
});

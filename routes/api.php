<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\SatelliteController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/satellites', [SatelliteController::class, 'index']);
Route::get('/satellites/{id}', [SatelliteController::class, 'show']);
Route::post('/satellites', [SatelliteController::class, 'store']);
Route::put('/satellites/{id}', [SatelliteController::class, 'update']);
Route::delete('/satellites/{id}', [SatelliteController::class, 'destroy']);




// List all planets (index method)
Route::get('/planets', [PlanetController::class, 'index']);
// Show a specific planet by ID (show method)
Route::get('/planets/{id}', [PlanetController::class, 'show']);
// Create a new planet (store method)
Route::post('/planets', [PlanetController::class, 'store']);
// Update a planet by ID (update method)
Route::put('/planets/{id}', [PlanetController::class, 'update']);
// Delete a planet by ID (destroy method)
Route::delete('/planets/{id}', [PlanetController::class, 'destroy']);







Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
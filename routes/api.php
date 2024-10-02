<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ExplorerController;
use App\Http\Controllers\ExpeditionController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RenovationController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\SatelliteController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

Route::apiResource('employees', controller: EmployeeController::class);

Route::apiResource('contracts', ContractController::class);

Route::apiResource('explorers', controller: ExplorerController::class);

Route::apiResource('expeditions', controller: ExpeditionController::class);

Route::apiResource('chefs', controller: ChefController::class);

Route::apiResource('recipes', controller: RecipeController::class);

Route::apiResource('buildings', controller: BuildingController::class);

Route::apiResource('renovations', controller: RenovationController::class);

Route::apiResource('planets', controller: PlanetController::class);

Route::apiResource('satellites', controller: SatelliteController::class);

Route::apiResource('asset_types', controller: AssetTypeController::class);

Route::apiResource('assets', controller: AssetController::class);

Route::apiResource('teams', controller: TeamController::class);

Route::apiResource('players', controller: PlayerController::class);

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FuelSaleController;
use App\Http\Controllers\Api\FuelTypeController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('fuels', FuelTypeController::class)->parameters(['fuels' => 'fuelType']);
    Route::apiResource('sales', FuelSaleController::class)->parameters(['sales' => 'fuelSale'])->only(['index', 'store', 'show']);
    Route::get('/reports', [ReportController::class, 'index']);
});

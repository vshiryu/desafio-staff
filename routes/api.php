<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LocationsController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);    // Restricted to admin/manager via policy
    Route::get('/users/{user}', [UserController::class, 'show']);  // Self or admin can view details
    Route::put('/users/{user}', [UserController::class, 'update']);  // Self update or admin update
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // Only admin (or self if allowed) may delete

    Route::get('/locations', [LocationsController::class, 'getLocations']);
});

Route::post('/login', [AuthController::class, 'login']);

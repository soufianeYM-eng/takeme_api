<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('login')->group(function () {
    Route::post('', [LoginController::class, 'submit']);
    Route::post('/verify', [LoginController::class, 'verify']);
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'me']);
    });

    Route::prefix('driver')->group(function () {
        Route::get('', [DriverController::class, 'show']);
        Route::post('', [DriverController::class, 'update']);
    });

    Route::prefix('trip')->group(function () {
        Route::post('', [TripController::class, 'store']);
        Route::get('/{trip}', [TripController::class, 'show']);
        Route::get('/{trip}/accept', [TripController::class, 'accept']);
        Route::get('/{trip}/start', [TripController::class, 'start']);
        Route::get('/{trip}/end', [TripController::class, 'end']);
        Route::get('/{trip}/location', [TripController::class, 'location']);
    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\ResourceController;

Route::group([
    'middleware' => 'throttle:60,1',
], function () {
    Route::apiResource('resources', ResourceController::class);
    Route::apiResource('bookings', BookingController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

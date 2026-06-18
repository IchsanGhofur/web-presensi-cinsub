<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\DeviceController;

Route::get(
    '/events/active',
    [EventApiController::class, 'active']
);

Route::get(
    '/attendances/latest',
    [DashboardApiController::class, 'latest']
);

//Route::middleware('iot.key')->group(function () {

//    Route::post(
//        '/attendance',
//        [AttendanceApiController::class, 'store']
//    );

//});

Route::middleware('iot.key')->get('/test-key', function () {
    return response()->json([
        'success' => true
    ]);
});



Route::post('/device/ping', [DeviceController::class, 'ping'])
    ->middleware(\App\Http\Middleware\VerifyIotApiKey::class);
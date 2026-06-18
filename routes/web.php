<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ScannerController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\DeviceController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/test', function () {
    return 'Laravel OK';
});
Route::get('/layout-test', function () {
    return view('layouts.app');
});
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/events', [EventController::class, 'index']);
Route::resource('users', UserController::class);
Route::get('/events/create', [EventController::class, 'create']);
Route::post('/events', [EventController::class, 'store']);
// Route::get('/attendance', function () {
//    $data = \App\Models\Attendance::with('user')->latest()->get();
//    return view('attendance.attendance', compact('data'));
//});
Route::get('/users/{id}/edit', [UserController::class, 'edit']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/events/{id}/edit', [EventController::class, 'edit']);
Route::put('/events/{id}', [EventController::class, 'update']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);
Route::post('/events/{id}/activate', [EventController::class, 'activate']);


Route::get('/attendance', [AttendanceController::class, 'index']);
Route::get('/attendance/create', [AttendanceController::class, 'create']);
Route::post('/attendance', [AttendanceController::class, 'store']);

Route::get('/scan', [ScannerController::class, 'index']);
Route::post('/scan', [ScannerController::class, 'store']);

Route::get(
    '/dashboard/stats',
    [DashboardController::class, 'stats']
);

Route::get(
    '/dashboard/latest-attendances',
    [DashboardController::class, 'latestAttendances']
);

Route::get('/test-api-key', function () {

    return Http::withHeaders([
        'X-API-KEY' => 'SALAH'
    ])->post(
        'http://127.0.0.1:8000/api/attendance',
        [
            'nim' => 'A710239999',
            'source' => 'esp32',
            'device_id' => 'ESP32_GATE_01'
        ]
    )->json();

});

Route::post('/device/ping', [DeviceController::class, 'ping'])
    ->middleware(\App\Http\Middleware\VerifyIotApiKey::class);
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DeviceController;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
|
| Dapat diakses tanpa login
|
*/

Route::get('/dashboard', [
    DashboardController::class,
    'index'
])->name('dashboard');

Route::get('/dashboard/stats', [
    DashboardController::class,
    'stats'
]);

Route::get('/dashboard/latest-attendances', [
    DashboardController::class,
    'latestAttendances'
]);

Route::get('/users', [
    UserController::class,
    'index'
])->name('users.index');

Route::get('/events', [
    EventController::class,
    'index'
])->name('events.index');


/*
|--------------------------------------------------------------------------
| PANITIA & ADMIN
|--------------------------------------------------------------------------
|
| Presensi dan Scanner
|
*/

Route::middleware([
    'auth',
    'role:admin,panitia'
])->group(function () {

    Route::get('/attendance', [
        AttendanceController::class,
        'index'
    ])->name('attendance.index');

    Route::get('/attendance/export', [
            AttendanceController::class,
            'export'
        ])->name('attendance.export');

    Route::get('/attendance/create', [
        AttendanceController::class,
        'create'
    ])->name('attendance.create');

    Route::post('/attendance', [
        AttendanceController::class,
        'store'
    ])->name('attendance.store');

    Route::get('/scan', [
        ScannerController::class,
        'index'
    ])->name('scan.index');

    Route::post('/scan', [
        ScannerController::class,
        'store'
    ])->name('scan.store');

});


/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
|
| CRUD Peserta, Event dan Aktivasi Event
|
*/

Route::middleware([
    'auth',
    'role:admin'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)
        ->except(['index']);

    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    Route::resource('events', EventController::class)
        ->except(['index']);

    Route::post('/events/{id}/activate', [
        EventController::class,
        'activate'
    ])->name('events.activate');
});


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
|
| Semua pengguna yang login
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| IoT Testing
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Device Ping
|--------------------------------------------------------------------------
*/

Route::post('/device/ping', [
    DeviceController::class,
    'ping'
])->middleware(
    \App\Http\Middleware\VerifyIotApiKey::class
);


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
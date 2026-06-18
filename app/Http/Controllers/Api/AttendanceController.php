<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'qr_data'   => 'required|string',
            'event_id'  => 'required|uuid',
            'device_id' => 'required|string',
        ]);

        // 2. CARI USER BERDASARKAN QR (NIM / CODE)
        $user = User::where('nim', $request->qr_data)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // 3. CEK SUDAH PRESENSI ATAU BELUM (ANTI DUPLIKAT)
        $exists = Attendance::where('user_id', $user->id)
            ->where('event_id', $request->event_id)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User sudah melakukan presensi'
            ], 409);
        }

        // 4. SIMPAN DATA PRESENSI
        $attendance = Attendance::create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'event_id' => $request->event_id,
            'device_id' => $request->device_id,
            'qr_data' => $request->qr_data,
            'check_in_time' => now()
        ]);

        // 5. RESPONSE SUKSES
        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil',
            'data' => [
                'name' => $user->name,
                'nim' => $user->nim,
                'time' => $attendance->check_in_time
            ]
        ], 200);
    }
}
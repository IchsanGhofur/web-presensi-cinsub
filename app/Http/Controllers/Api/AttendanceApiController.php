<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'source' => 'required|string',
            'device_id' => 'required|string',
        ]);

        $event = Event::where('is_active', true)->first();

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada event aktif'
            ], 404);
        }

        $user = User::where('nim', $request->nim)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Mahasiswa ' . $request->nim,
                'nim' => $request->nim,
            ]);
        }

        $already = Attendance::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($already) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi sudah dilakukan'
            ], 409);
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'source' => $request->source,
            'device_id' => $request->device_id,
            'qr_data' => $request->nim,
            'check_in_time' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil',
            'data' => $attendance
        ]);
    }
}
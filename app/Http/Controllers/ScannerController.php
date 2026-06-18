<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index()
    {
        return view('scanner.index');
    }

    public function store(Request $request)
    {
        $rawData = trim($request->nim);
        $parts = explode(';', $rawData);
        $nim = trim($parts[0]);

        $user = User::firstOrCreate(
            [
                'nim' => $nim
            ],
            [
                'name' => 'Mahasiswa '.$nim
            ]
        );

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta tidak ditemukan'
            ]);
        }

        $event = Event::where('is_active', true)->first();

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada event aktif'
            ]);
        }

        $already = Attendance::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($already) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta sudah presensi'
            ]);
        }

        Attendance::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'source' => 'mobile',
            'device_id' => 'MOBILE_WEB',
            'qr_data' => $rawData,
            'check_in_time' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil',
            'name' => $user->name,
            'event' => $event->title
        ]);
    }
}
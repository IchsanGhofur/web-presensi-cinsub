<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with([
            'user',
            'event'
        ])->latest()->get();

        return view(
            'attendance.index',
            compact('attendances')
        );
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();

        return view(
            'attendance.create',
            compact('users', 'events')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);
    
        $already = Attendance::where('user_id', $request->user_id)
            ->where('event_id', $request->event_id)
            ->exists();
    
        if ($already) {
            return back()->with(
                'error',
                'Peserta sudah melakukan presensi pada event ini'
            );
        }
    
        Attendance::create([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'source' => 'manual',
            'device_id' => 'MANUAL_INPUT',
            'qr_data' => null,
            'check_in_time' => now(),
        ]);
    
        return redirect('/attendance')
            ->with(
                'success',
                'Presensi berhasil ditambahkan'
            );
    }
}
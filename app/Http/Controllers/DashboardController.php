<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalAttendances = Attendance::count();
    
        $activeEvent = Event::where('is_active', true)->first();
    
        $latestAttendances = Attendance::with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();
    
        $attendanceByEvent = Attendance::select(
                'events.title',
                DB::raw('count(attendances.id) as total')
            )
            ->join('events', 'attendances.event_id', '=', 'events.id')
            ->groupBy('events.title')
            ->get();
    
        $todayAttendance = Attendance::whereDate(
            'created_at',
            now()->toDateString()
        )->count();

        $attendanceBySource = Attendance::select(
                'source',
                DB::raw('count(id) as total')
            )
            ->groupBy('source')
            ->get();
    
        return view('dashboard.index', compact(
            'totalUsers',
            'totalEvents',
            'totalAttendances',
            'activeEvent',
            'latestAttendances',
            'attendanceByEvent',
            'todayAttendance',
            'attendanceBySource'
        ));
    }
    public function stats()
    {
        $attendanceBySource = Attendance::select(
                'source',
                DB::raw('count(id) as total')
            )
            ->groupBy('source')
            ->get();

        return response()->json([
            'totalUsers' => User::count(),
            'totalEvents' => Event::count(),
            'totalAttendances' => Attendance::count(),

            'todayAttendance' => Attendance::whereDate(
                'created_at',
                now()->toDateString()
            )->count(),

            'activeEvent' => Event::where(
                'is_active',
                true
            )->first()?->title,

            'attendanceBySource' => $attendanceBySource
        ]);
    }
    public function latestAttendances()
    {
        $attendances = Attendance::with([
                'user',
                'event'
            ])
            ->latest()
            ->take(5)
            ->get();
        return response()->json($attendances);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class DashboardApiController extends Controller
{
    public function latest()
    {
        return response()->json(
            Attendance::with([
                'user',
                'event'
            ])
            ->latest()
            ->take(10)
            ->get()
        );
    }
}
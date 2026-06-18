<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventApiController extends Controller
{
    public function active()
    {
        $event = Event::where('is_active', true)->first();

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }
}
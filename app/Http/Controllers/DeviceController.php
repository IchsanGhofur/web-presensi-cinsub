<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function ping(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100',
            'device_name' => 'nullable|string|max:255',
            'device_type' => 'nullable|string|max:100',
            'firmware_version' => 'nullable|string|max:50',
        ]);

        $device = Device::updateOrCreate(
            [
                'device_id' => $validated['device_id']
            ],
            [
                'device_name' => $validated['device_name']
                    ?? $validated['device_id'],

                'device_type' => $validated['device_type']
                    ?? 'ESP32-CAM',

                'firmware_version' => $validated['firmware_version']
                    ?? null,

                'ip_address' => $request->ip(),

                'last_seen' => now(),

                'is_online' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Ping berhasil'
        ]);;
    }
}
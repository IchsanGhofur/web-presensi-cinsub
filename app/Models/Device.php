<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_id',
        'device_name',
        'device_type',
        'firmware_version',
        'ip_address',
        'last_seen',
        'is_online',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
        'is_online' => 'boolean',
    ];
}
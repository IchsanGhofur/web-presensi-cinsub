<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'event_date',
        'is_active'
    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
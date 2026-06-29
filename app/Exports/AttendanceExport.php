<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $no = 1;

        return Attendance::with(['user', 'event'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($attendance) use (&$no) {

                return [

                    'No' => $no++,

                    'Nama Peserta' => $attendance->user->name ?? '-',

                    'NIM' => $attendance->user->nim ?? '-',

                    'Kegiatan' => $attendance->event->title ?? '-',

                    'Waktu Presensi' => $attendance->created_at
                        ->format('d-m-Y H:i:s'),

                ];

            });
    }

    public function headings(): array
    {
        return [

            'No',

            'Nama Peserta',

            'NIM',

            'Kegiatan',

            'Waktu Presensi',

        ];
    }
}
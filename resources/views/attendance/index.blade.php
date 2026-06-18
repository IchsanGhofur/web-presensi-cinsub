@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">
    📊 Data Presensi
</h2>

<a href="/attendance/create"
   class="bg-green-600 text-white px-4 py-2 rounded">
    + Presensi Manual
</a>

<table class="w-full mt-4 bg-white shadow border">

    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-2">Nama</th>
            <th class="p-2">NIM</th>
            <th class="p-2">Event</th>
            <th class="p-2">Waktu Presensi</th>
        </tr>
    </thead>

    <tbody>

    @forelse($attendances as $attendance)

        <tr class="border-b">

            <td class="p-2">
                {{ $attendance->user->name ?? '-' }}
            </td>

            <td class="p-2">
                {{ $attendance->user->nim ?? '-' }}
            </td>

            <td class="p-2">
                {{ $attendance->event->title ?? '-' }}
            </td>

            <td class="p-2">
                {{ $attendance->check_in_time ?? $attendance->created_at }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="4" class="text-center p-4">
                Belum ada data presensi
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

@endsection
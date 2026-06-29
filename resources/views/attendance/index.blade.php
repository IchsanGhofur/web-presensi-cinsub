@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            Data Presensi
        </h1>

        <p class="text-gray-600 mt-2">
            Daftar seluruh data presensi peserta.
        </p>

    </div>

    <div class="flex gap-3">

        {{-- Presensi Manual --}}
        <a href="{{ route('attendance.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2">

            <i class="fa-solid fa-plus"></i>

            Presensi Manual

        </a>

        {{-- Export Excel --}}
        <a href="{{ route('attendance.export') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2">

            <i class="fa-solid fa-file-excel"></i>

            Export Excel

        </a>

    </div>

</div>


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
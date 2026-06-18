@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
    📅 Data Kegiatan
</h1>

<a href="/events/create"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    + Tambah Jadwal Cinta Subuh
</a>

<table class="w-full border mt-4">

    <thead>

        <tr class="bg-gray-200">
            <th class="border p-2">No</th>
            <th class="border p-2">Nama Kegiatan</th>
            <th class="border p-2">Tanggal</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Aksi</th>
        </tr>

    </thead>

    <tbody>

    @foreach($events as $index => $event)

        <tr>

            <td class="border p-2">
                {{ $index + 1 }}
            </td>

            <td class="border p-2">
                {{ $event->title }}
            </td>

            <td class="border p-2">
                {{ $event->event_date }}
            </td>

            <td class="border p-2">

                @if($event->is_active)

                    <span class="text-green-600 font-bold">
                        Aktif
                    </span>

                @else

                    <span class="text-gray-500">
                        Tidak Aktif
                    </span>

                @endif

            </td>

            <td class="border p-2">

                <div class="flex gap-2">

                    <a href="/events/{{ $event->id }}/edit"
                       class="bg-yellow-500 text-white px-2 py-1 rounded">
                        Edit
                    </a>

                    <form action="/events/{{ $event->id }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            class="bg-red-600 text-white px-2 py-1 rounded">
                            Hapus
                        </button>

                    </form>

                    <form action="/events/{{ $event->id }}/activate"
                          method="POST">

                        @csrf

                        <button
                            class="bg-blue-600 text-white px-2 py-1 rounded">
                            Aktifkan
                        </button>

                    </form>

                </div>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

@endsection
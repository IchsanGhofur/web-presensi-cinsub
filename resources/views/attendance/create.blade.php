@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
    Presensi Manual
</h1>

<form method="POST" action="/attendance">

    @csrf

    <div class="mb-4">

        <label>Peserta</label>

        <select
            name="user_id"
            class="border p-2 w-full">

            @foreach($users as $user)

                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-4">

        <label>Event</label>

        <select
            name="event_id"
            class="border p-2 w-full">

            @foreach($events as $event)

                <option value="{{ $event->id }}">
                    {{ $event->title }}
                </option>

            @endforeach

        </select>

    </div>

    <button
        class="bg-blue-600 text-white px-4 py-2 rounded">

        Simpan Presensi

    </button>

</form>

@endsection
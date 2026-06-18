@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
    Edit Event
</h1>

<form method="POST"
      action="/events/{{ $event->id }}">

    @csrf
    @method('PUT')

    <div class="mb-4">

        <label>Nama Event</label>

        <input
            type="text"
            name="title"
            value="{{ $event->title }}"
            class="border p-2 w-full"
            required>

    </div>

    <div class="mb-4">

        <label>Tanggal Event</label>

        <input
            type="date"
            name="event_date"
            value="{{ $event->event_date }}"
            class="border p-2 w-full"
            required>

    </div>

    <button
        class="bg-green-600 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection
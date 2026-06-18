@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">
    Tambah Event
</h1>

<form method="POST" action="/events">

    @csrf

    <div class="mb-4">

        <label>Nama Event</label>

        <input
            type="text"
            name="title"
            class="border p-2 w-full"
            required>

    </div>

    <div class="mb-4">

        <label>Tanggal Event</label>

        <input
            type="date"
            name="event_date"
            class="border p-2 w-full"
            required>

    </div>

    <button
        class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection
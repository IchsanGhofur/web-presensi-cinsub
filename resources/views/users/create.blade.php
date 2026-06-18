@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">➕ Tambah Peserta</h2>

<form method="POST" action="/users">
@csrf

<input name="name" placeholder="Nama" class="border p-2 w-full mb-2">
<input name="nim" placeholder="NIM" class="border p-2 w-full mb-2">

<button class="bg-green-600 text-white px-4 py-2">
    Simpan
</button>

</form>

@endsection
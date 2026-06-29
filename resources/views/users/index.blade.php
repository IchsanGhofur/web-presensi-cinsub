@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold">
        Data Peserta
    </h1>

    <p class="text-gray-600 mt-2">
        Total Peserta: {{ $users->count() }}
    </p>
</div>

{{-- Tombol Tambah hanya Admin --}}
@auth
    @if(auth()->user()->isAdmin())
        <div class="mb-4">
            <a href="{{ route('users.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah Peserta
            </a>
        </div>
    @endif
@endauth

{{-- Notifikasi --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded shadow p-4">

    @if($users->count() > 0)

        <table class="w-full border border-gray-300">

            <thead>

                <tr class="bg-gray-200">

                    <th class="border p-3">No</th>
                    <th class="border p-3 text-left">Nama</th>
                    <th class="border p-3 text-left">NIM</th>
                    <th class="border p-3 text-left">ID</th>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <th class="border p-3 text-center">
                                Aksi
                            </th>
                        @endif
                    @endauth

                </tr>

            </thead>

            <tbody>

                @foreach($users as $index => $u)

                <tr class="hover:bg-gray-100">

                    <td class="border p-3">
                        {{ $index + 1 }}
                    </td>

                    <td class="border p-3">
                        {{ $u->name }}
                    </td>

                    <td class="border p-3">
                        {{ $u->nim }}
                    </td>

                    <td class="border p-3 text-xs">
                        {{ $u->id }}
                    </td>

                    @auth
                        @if(auth()->user()->isAdmin())

                        <td class="border p-3">

                            <div class="flex gap-2 justify-center">

                                <a href="{{ route('users.edit', $u->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('users.destroy', $u->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                        @endif
                    @endauth

                </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <div class="bg-yellow-100 border border-yellow-300 text-yellow-700 p-4 rounded">
            Belum ada data peserta.
        </div>

    @endif

</div>

@endsection
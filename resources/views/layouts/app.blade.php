<!DOCTYPE html>
<html>
<head>
    <title>Cinta Subuh UMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<script>

setTimeout(function () {
    location.reload();
}, 30000);

</script>
<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-blue-900 text-white min-h-screen p-5">

        <h1 class="text-xl font-bold mb-6">
            Cinta Subuh UMS
        </h1>

        <ul class="space-y-3">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/users">Peserta</a></li>
            <li><a href="/events">Kegiatan</a></li>
            <li><a href="/attendance">Presensi</a></li>
            <li><a href="/scan">Scan QR</a>
            </li>
        </ul>

    </div>

    <!-- CONTENT -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>

</div>

</body>
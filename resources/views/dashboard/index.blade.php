@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold">
        <style="color:#153097;">Dashboard Presensi Cinta <em>Subuh</em> UMS</style>
    </h1>

    <p class="text-gray-600">
        <em>Monitoring Kegiatan Cinta Subuh UMS</em>
    </p>
</div>

<!-- CARD STATISTIK -->

<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

    <!-- Total Peserta -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500">
            Total Peserta
        </h3>

        <p id="totalUsers" class="text-3xl font-bold">
            {{ $totalUsers }}
        </p>
    </div>

    <!-- Total Event -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500">
            Total Event
        </h3>

        <p id="totalEvents" class="text-3xl font-bold">
            {{ $totalEvents }}
        </p>
    </div>

    <!-- Total Presensi -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500">
            Total Presensi
        </h3>

        <p id="totalAttendances" class="text-3xl font-bold">
            {{ $totalAttendances }}
        </p>
    </div>

    <!-- Event Aktif -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500">
            Event Aktif
        </h3>

        <p id="activeEvent" class="font-bold">
            {{ $activeEvent->title ?? 'Tidak Ada Event Aktif' }}
        </p>
    </div>

    <!-- Presensi Hari Ini -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500">
            Presensi Hari Ini
        </h3>

        <p id="todayAttendance" class="text-3xl font-bold">
            {{ $todayAttendance }}
        </p>
    </div>

</div>

<!-- STATISTIK SUMBER PRESENSI -->

<div class="bg-white rounded-lg shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">
        Statistik Sumber Presensi
    </h2>

    <div
        id="attendanceSourceContainer"
        class="grid grid-cols-1 md:grid-cols-3 gap-4">

        @foreach($attendanceBySource as $source)

            <div
                class="border rounded-lg p-4">

                <h3 class="font-bold capitalize">
                    {{ $source->source }}
                </h3>

                <p class="text-2xl font-bold">
                    {{ $source->total }}
                </p>

            </div>

        @endforeach

    </div>

</div>

<!-- GRAFIK -->

<div class="bg-white rounded-lg shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">
        Statistik Kehadiran per Event
    </h2>

    <canvas id="attendanceChart"></canvas>

</div>

<!-- PRESENSI TERBARU -->

<div class="bg-white rounded-lg shadow p-6">

    <h2 class="text-xl font-bold mb-4">
        Presensi Terbaru
    </h2>

    <table class="w-full">

        <thead>
            <tr class="border-b bg-gray-50">
                <th class="text-left p-3">Peserta</th>
                <th class="text-left p-3">Event</th>
                <th class="text-left p-3">Waktu Presensi</th>
            </tr>
        </thead>

        <tbody id="latestAttendanceBody">

        @forelse($latestAttendances as $attendance)

            <tr class="border-b">
                <td class="p-3">
                    {{ $attendance->user->name ?? '-' }}
                </td>

                <td class="p-3">
                    {{ $attendance->event->title ?? '-' }}
                </td>

                <td class="p-3">
                    {{ $attendance->created_at->format('d M Y H:i:s') }}
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="3" class="text-center p-4 text-gray-500">
                    Belum ada data presensi
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<!-- CHART JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = [
    @foreach($attendanceByEvent as $item)
        "{{ $item->title }}",
    @endforeach
];

const totals = [
    @foreach($attendanceByEvent as $item)
        {{ $item->total }},
    @endforeach
];

const ctx = document.getElementById('attendanceChart');

new Chart(ctx, {
    type: 'bar',

    data: {
        labels: labels,

        datasets: [{
            label: 'Jumlah Kehadiran',
            data: totals
        }]
    },

    options: {
        responsive: true,

        plugins: {
            legend: {
                display: true
            }
        },

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


// AUTO REFRESH DASHBOARD
setInterval(() => {

    fetch('/dashboard/stats')
    .then(response => response.json())
    .then(data => {

        document.getElementById('totalUsers')
            //.innerText = data.totalUsers;
            let sourceHtml = '';

            data.attendanceBySource.forEach(item => {

                sourceHtml += `
                    <div class="border rounded-lg p-4">

                        <h3 class="font-bold capitalize">
                            ${item.source}
                        </h3>

                        <p class="text-2xl font-bold">
                            ${item.total}
                        </p>

                    </div>
                `;
            });

            document
                .getElementById(
                    'attendanceSourceContainer'
                )
                .innerHTML = sourceHtml;

        document.getElementById('totalEvents')
            .innerText = data.totalEvents;

        document.getElementById('totalAttendances')
            .innerText = data.totalAttendances;

        document.getElementById('todayAttendance')
            .innerText = data.todayAttendance;

        document.getElementById('activeEvent')
            .innerText =
                data.activeEvent ??
                'Tidak Ada Event Aktif';

    });

}, 5000);


// AUTO REFRESH PRESENSI TERBARU
setInterval(() => {

    fetch('/dashboard/latest-attendances')
    .then(response => response.json())
    .then(data => {

        let html = '';

        if(data.length === 0)
        {
            html = `
                <tr>
                    <td colspan="3"
                        class="text-center p-4 text-gray-500">
                        Belum ada data presensi
                    </td>
                </tr>
            `;
        }
        else
        {
            data.forEach(item => {

                let nama =
                    item.user?.name ?? '-';

                let event =
                    item.event?.title ?? '-';

                let waktu =
                    new Date(item.created_at)
                    .toLocaleString('id-ID');

                html += `
                    <tr class="border-b">

                        <td class="p-3">
                            ${nama}
                        </td>

                        <td class="p-3">
                            ${event}
                        </td>

                        <td class="p-3">
                            ${waktu}
                        </td>

                    </tr>
                `;
            });
        }

        document
            .getElementById(
                'latestAttendanceBody'
            )
            .innerHTML = html;

    });

}, 5000);

</script>

@endsection
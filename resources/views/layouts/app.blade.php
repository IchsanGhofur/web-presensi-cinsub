<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cinta Subuh UMS</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<script>

setTimeout(function () {
    location.reload();
}, 30000);

</script>

<body class="bg-gray-100">

    <!-- NAVBAR -->

    <nav class="bg-blue-900 shadow-lg">

        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center justify-between h-16">

                <!-- Logo -->

                <div class="flex items-center gap-3">

                    <div>

                        <h1 class="text-white font-bold text-lg">
                            Cinta Subuh UMS
                        </h1>

                        <p class="text-blue-200 text-xs">
                            Sistem Presensi Digital
                        </p>

                    </div>

                </div>

                <!-- Menu -->

                <div class="flex items-center gap-2">

                    <a href="/dashboard"
                       class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                        Dashboard
                    </a>

                    @guest

                        <a href="/users"
                           class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                            Peserta
                        </a>

                        <a href="/events"
                           class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                            Kegiatan
                        </a>

                        <a href="{{ route('login') }}"
                           class="bg-white text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Login Admin
                        </a>

                    @endguest

                    @auth

                        @if(auth()->user()->isAdmin())

                            <a href="/users"
                               class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                                Peserta
                            </a>

                            <a href="/events"
                               class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                                Kegiatan
                            </a>

                            <a href="/attendance"
                               class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                                Presensi
                            </a>

                            <a href="/scan"
                               class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                                Scan QR
                            </a>

                        @elseif(auth()->user()->isPanitia())

                            <a href="/attendance"
                               class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                                Presensi
                            </a>

                            <a href="/scan"
                               class="px-4 py-2 rounded text-white hover:bg-blue-800 transition">
                                Scan QR
                            </a>

                        @endif

                        <div class="flex items-center gap-3 ml-5 border-l border-blue-700 pl-5">

                            <div class="text-right">

                                <p class="text-white text-sm font-semibold">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-blue-200 text-xs capitalize">
                                    {{ auth()->user()->role }}
                                </p>

                            </div>

                            <form method="POST"
                                  action="{{ route('logout') }}">

                                @csrf

                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">

                                    Logout

                                </button>

                            </form>

                        </div>

                    @endauth

                </div>

            </div>

        </div>

    </nav>

    <!-- CONTENT -->

    <main class="max-w-7xl mx-auto p-6">

        @yield('content')

    </main>

</body>

</html>
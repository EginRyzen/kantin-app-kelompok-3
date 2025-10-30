<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS (biarkan di head) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS (biarkan di head) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <!-- [PERUBAHAN]: Flowbite JS dipindahkan dari sini ke bawah -->

    <title>@yield('title', 'Kantin App')</title>
</head>

<body class="bg-white font-sans">

    <!-- Wrapper Konten Utama -->
    <div class="max-w-4xl mx-auto bg-white min-h-screen">

        @include('user.partials.navbar')

        <!-- Konten diberi padding-bottom (pb-24) -->
        <main class="px-4 py-8 min-h-[70vh] pb-24">
            @yield('content')
        </main>

    </div> <!-- Penutup Div Wrapper Utama -->

    <!-- Menu Navigasi Bawah (BARU) -->
    @include('user.partials.bottomnav')


    <!-- [PERUBAHAN DI SINI] -->
    
    <!-- 1. Muat Flowbite JS di sini (sebelum body ditutup) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <!-- 2. Muat semua skrip kustom (seperti modal Anda) setelah Flowbite -->
    @stack('scripts')

</body>

</html>

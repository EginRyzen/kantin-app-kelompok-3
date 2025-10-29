<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <!-- Viewport ini SUDAH BENAR untuk responsif di HP/Tablet asli -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Menggunakan CDN Tailwind standar -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>@yield('title', 'Kantin App')</title>
</head>

<body class="bg-white font-sans">

    <!-- 
      Wrapper Konten Utama
      Semua konten (kecuali bottom nav) ada di dalam sini
    -->
    <div class="max-w-4xl mx-auto bg-white min-h-screen">

        <!-- 
          Navbar Anda sekarang berfungsi sebagai Header (hanya logo)
          dan tetap berada di dalam wrapper.
        -->
        @include('user.partials.navbar')

        <!-- 
          Konten diberi padding-bottom (pb-24) 
          agar tidak terhalang oleh menu bawah yang fixed.
        -->
        <main class="px-4 py-8 min-h-[70vh] pb-24">
            @yield('content')
        </main>

        <!-- Footer lama Anda dihapus dari sini -->

    </div> <!-- Penutup Div Wrapper Utama -->

    <!-- 
      Menu Navigasi Bawah (BARU)
      Diletakkan di luar wrapper agar bisa fixed ke dasar viewport.
    -->
    @include('user.partials.bottomnav')

</body>
</html>


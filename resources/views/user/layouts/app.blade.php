<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- INI PENTING: Tailwind CDN v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Judul halaman bisa di-override oleh halaman anak -->
    <title>@yield('title', 'Kantin App')</title>
</head>

<body class="bg-white font-sans">

    <!-- Memanggil Navbar User -->
    @include('user.partials.navbar')

    <!-- Konten Utama -->
    <main class="container mx-auto px-4 py-8 min-h-[70vh]">
        @yield('content')
    </main>

    <!-- Memanggil Footer User -->
    @include('user.partials.footer')

</body>
</html>

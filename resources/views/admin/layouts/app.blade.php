<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- INI PENTING: Tailwind CDN v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Judul halaman bisa di-override oleh halaman anak -->
    <title>@yield('title', 'Admin Panel')</title>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Memanggil Navbar Admin -->
    @include('admin.partials.navbar')

    <!-- Konten Utama -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- Memanggil Footer Admin -->
    @include('admin.partials.footer')

</body>
</html>

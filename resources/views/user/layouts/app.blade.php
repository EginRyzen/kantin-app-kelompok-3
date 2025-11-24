<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    
    <!-- FontAwesome (Untuk Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <title>@yield('title', 'Kantin App')</title>
</head>

<body class="bg-white font-sans text-gray-900">

    @php
        $mainRoutes = [
            'kasir.home',
            'kasir.products.index',
            'kasir.profile.index',
            'kasir.users.index',
            'kasir.store.report'  
        ];
        
        $isMainPage = request()->routeIs($mainRoutes);
    @endphp

    <!-- Wrapper Konten Utama -->
    <div class="max-w-4xl mx-auto bg-white min-h-screen relative shadow-2xl shadow-gray-100">

        {{-- NAVBAR --}}
        @if ($isMainPage)
            @include('user.partials.navbar')
        @endif

        <main class="px-4 py-6 min-h-[80vh] {{ $isMainPage ? 'pb-24' : 'pb-6' }}">
            @yield('content')
        </main>

    </div> 

    {{-- BOTTOMNAV --}}
    @if ($isMainPage)
        @include('user.partials.bottomnav')
    @endif

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    @stack('scripts')

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <title>@yield('title', 'Kantin App')</title>
</head>

<body class="bg-white font-sans">

    <div class="max-w-4xl mx-auto bg-white min-h-screen">

        @include('user.partials.navbar')

        <main class="px-4 py-8 min-h-[70vh] {{ request()->is('kasir/cart') ? 'pb-0' : 'pb-24' }}">
            @yield('content')
        </main>

    </div> 

    @if (!request()->is('kasir/cart'))
        @include('user.partials.bottomnav')
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    @stack('scripts')

</body>
</html>
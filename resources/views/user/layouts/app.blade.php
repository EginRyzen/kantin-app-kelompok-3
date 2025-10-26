<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>@yield('title', 'Kantin App')</title>
</head>

<body class="bg-white font-sans">

    @include('user.partials.navbar')

    <main class="container mx-auto px-4 py-8 min-h-[70vh]">
        @yield('content')
    </main>

    @include('user.partials.footer')

</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <title>@yield('title', 'Admin Panel')</title>
</head>

<body class="bg-gray-100 font-sans">

    @include('admin.partials.navbar')

    <main class="p-6">
        @yield('content')
    </main>

    @include('admin.partials.footer')

</body>
</html>

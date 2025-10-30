<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <title>@yield('title', 'Admin Panel')</title>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen bg-gray-200">
        
        <div class="w-64 bg-white shadow-md">
            <div class="py-4 px-6 bg-gray-800 text-white">
                <span class="font-bold text-xl">POS Kantin Admin</span>
            </div>
            
            @include('admin.partials.sidebar') 
            
        </div>
        
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                
                @yield('content')

            </main>

            @include('admin.partials.footer')
        </div>
        
    </div>

    @stack('scripts')
</body>
</html> 
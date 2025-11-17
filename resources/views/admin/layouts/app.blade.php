<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <title>@yield('title', 'Admin Panel')</title>
</head>
<body class="bg-gray-100 font-sans" x-data="{ isSidebarOpen: true }">

    <div class="flex h-screen bg-gray-200">
        
        <div :class="isSidebarOpen ? 'w-64' : 'w-20'" class="flex flex-col justify-between bg-white shadow-md transition-all duration-300 ease-in-out">
            <div>
                <div class="py-4 px-6 bg-green-800 text-white">
                    <span x-show="isSidebarOpen" class="font-bold text-xl transition-opacity">POS Kantin Admin</span>
                    <span x-show="!isSidebarOpen" class="font-bold text-xl transition-opacity">POS</span>
                </div>
                
                <div class="flex-1 overflow-y-auto">
                    @include('admin.partials.sidebar') 
                </div>
            </div>
            
            <div class="px-2 py-4 border-t">
                <button @click="isSidebarOpen = !isSidebarOpen" class="flex items-center w-full px-2 py-2 text-gray-500 hover:bg-gray-100 rounded-md" :class="isSidebarOpen ? '' : 'justify-center'">
                    <svg :class="isSidebarOpen ? '' : 'rotate-180'" class="w-6 h-6 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span x-show="isSidebarOpen" class="ml-3 text-sm font-medium">Minimize</span>
                </button>
            </div>
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <title>@yield('title', 'Admin Panel')</title>
</head>

<body class="bg-gray-100 font-sans">

   {{-- Sidebar --}}
  <aside class="w-64 bg-gray-900 text-white h-screen flex flex-col">
    <div class="p-4 text-lg font-semibold border-b border-gray-700">
      Admin Panel
    </div>
    <nav class="flex-1 p-3 space-y-2">
      <a href="{{ route('dashboard') }}"
         class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-800 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
         <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('users.index') }}"
         class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-800 {{ request()->routeIs('users.*') ? 'bg-gray-700' : '' }}">
         <i class="bi bi-people"></i> Manajemen User
      </a>
      <a href="{{ route('outlet.index') }}"
         class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-800 {{ request()->routeIs('outlet.*') ? 'bg-gray-700' : '' }}">
         <i class="bi bi-shop"></i> Daftar Outlet
      </a>
      <a href="{{ route('laporan.index') }}"
         class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-800 {{ request()->routeIs('laporan.*') ? 'bg-gray-700' : '' }}">
         <i class="bi bi-bar-chart"></i> Laporan
      </a>
    </nav>
    <form action="{{ route('logout') }}" method="POST" class="p-4 border-t border-gray-700">
      @csrf
      <button type="submit" class="flex items-center gap-2 text-red-400 hover:text-red-500">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </aside>

  {{-- Konten utama --}}
  <main class="flex-1 p-6 overflow-y-auto">
    @yield('content')
  </main>

</body>
</html>
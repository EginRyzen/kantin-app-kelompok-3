<!-- resources/views/admin/partials/navbar.blade.php -->
<aside class="sidebar bg-white shadow-md h-screen w-64 fixed">
    <div class="p-4 border-b">
        <h2 class="text-lg font-bold text-gray-700">Admin Panel</h2>
    </div>
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 p-2 rounded-md hover:bg-green-100 {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-600' : 'text-gray-600' }}">
           <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('outlet.index') }}"
           class="flex items-center gap-3 p-2 rounded-md hover:bg-green-100 {{ request()->routeIs('outlet.*') ? 'bg-green-50 text-green-600' : 'text-gray-600' }}">
           <i class="bi bi-shop"></i> Daftar Outlet
        </a>
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 p-2 rounded-md hover:bg-green-100 {{ request()->routeIs('users.*') ? 'bg-green-50 text-green-600' : 'text-gray-600' }}">
           <i class="bi bi-people"></i> Manajemen User
        </a>
        <a href="{{ route('laporan.index') }}"
           class="flex items-center gap-3 p-2 rounded-md hover:bg-green-100 {{ request()->routeIs('laporan.*') ? 'bg-green-50 text-green-600' : 'text-gray-600' }}">
           <i class="bi bi-bar-chart"></i> Laporan
        </a>
    </nav>
</aside>

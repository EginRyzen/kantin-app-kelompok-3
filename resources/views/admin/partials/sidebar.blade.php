<nav class="mt-5 flex-1 px-2 space-y-1">
    
    <a href="{{ route('admin.dashboard') }}" 
       class="{{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }} 
              group flex items-center px-2 py-2 text-sm font-medium rounded-md"
       :class="isSidebarOpen ? '' : 'justify-center'">
        
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6-4a1 1 0 001-1v-1a1 1 0 10-2 0v1a1 1 0 001 1zm5-6a1 1 0 001-1v-3a1 1 0 10-2 0v3a1 1 0 001 1z" />
        </svg>
        <span x-show="isSidebarOpen" class="ml-3">Dashboard</span>
    </a>

    <a href="{{ route('admin.outlets.index') }}" 
       class="{{ request()->routeIs('admin.outlets.*') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }} 
              group flex items-center px-2 py-2 text-sm font-medium rounded-md"
       :class="isSidebarOpen ? '' : 'justify-center'">
        
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('admin.outlets.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m6-4h1m-1 4h1m-1 4h1m-6-4h1m-1 4h1m-1 4h1" />
        </svg>
        <span x-show="isSidebarOpen" class="ml-3">Daftar Outlet</span>
    </a>
    
    <a href="{{ route('admin.reports.transactions') }}" 
       class="{{ request()->routeIs('admin.reports.*') ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }} 
              group flex items-center px-2 py-2 text-sm font-medium rounded-md"
       :class="isSidebarOpen ? '' : 'justify-center'">
        
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-500' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span x-show="isSidebarOpen" class="ml-3">Laporan Transaksi</span>
    </a>
    
</nav>
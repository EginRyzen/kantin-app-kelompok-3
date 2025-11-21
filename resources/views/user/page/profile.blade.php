@extends('user.layouts.app')

@section('title', 'Profil Kasir')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto space-y-6">

    {{-- Header Profil --}}
    <div class="bg-white rounded-3xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 relative overflow-hidden flex flex-col md:flex-row items-center gap-6">
      <div class="absolute top-0 right-0 w-64 h-64 bg-gray-50 rounded-full blur-3xl -mr-16 -mt-16 z-0 pointer-events-none"></div>
      
      <div class="relative z-10 shrink-0">
        <div class="relative inline-block">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar" class="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-gray-50 shadow-lg object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_lengkap }}&background=0F172A&color=fff&size=128" alt="Avatar" class="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-gray-50 shadow-lg object-cover">
            @endif
            <span class="absolute bottom-1 right-1 bg-gray-800 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white shadow-sm uppercase">{{ Auth::user()->role }}</span>
        </div>
      </div>

      <div class="relative z-10 text-center md:text-left flex-1">
        <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">{{ Auth::user()->nama_lengkap }}</h2>
        <p class="text-gray-500 font-medium text-sm">{{ Auth::user()->email }}</p>
        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-lg border border-gray-200">
            <i class="fa-solid fa-store text-gray-500 text-xs"></i>
            <span class="text-xs font-bold text-gray-600">{{ Auth::user()->outlet->nama_outlet ?? 'Outlet Tidak Diketahui' }}</span>
        </div>
      </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pendapatan</span>
            <p class="text-lg font-extrabold text-gray-800">Rp 1.2jt</p> 
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Transaksi</span>
            <p class="text-lg font-extrabold text-gray-800">142</p>
        </div>
    </div>

    {{-- MENU PINTAS --}}
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4 px-2">Pengaturan Akun</h3>
        <div class="flex flex-col space-y-3">
            
            {{-- ITEM 1: Link ke File Baru (profile-edit) --}}
            {{-- PASTIKAN ROUTE DI WEB.PHP SESUAI YA, misal: kasir.profile.edit --}}
            <a href="{{ route('kasir.profile.edit') }}" 
               class="group flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Edit Data Diri & Keamanan</h4>
                        <p class="text-xs text-gray-500">Update foto, bio, & kata sandi</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-gray-500 transition-colors text-sm"></i>
            </a>

            {{-- ITEM 2: Kelola Produk --}}
            <a href="{{ route('kasir.products.index') }}" class="group flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Kelola Produk</h4>
                        <p class="text-xs text-gray-500">Menu & Stok barang</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-gray-500 transition-colors text-sm"></i>
            </a>

            {{-- ITEM 3: Laporan --}}
            <a href="#" class="group flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Laporan</h4>
                        <p class="text-xs text-gray-500">Statistik penjualan</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-gray-500 transition-colors text-sm"></i>
            </a>

            {{-- ITEM 4: Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                @csrf
                <button type="submit" class="w-full group flex items-center justify-between p-4 bg-white rounded-2xl border border-red-100 shadow-sm hover:bg-red-50 hover:border-red-200 transition-all duration-200 text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-600 text-sm">Keluar Aplikasi</h4>
                            <p class="text-xs text-red-400">Akhiri sesi</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-red-200 group-hover:text-red-400 transition-colors text-sm"></i>
                </button>
            </form>

        </div>
    </div>
  </div>
</div>
@endsection
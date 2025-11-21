@extends('user.layouts.app')

@section('title', 'Profil Kasir')

@section('content')
{{-- 1. Container Utama: Dibuat lebar (max-w-6xl) agar full di layar laptop/PC --}}
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-6xl mx-auto space-y-8">

    {{-- 2. Header Profil (Desain Banner Lebar) --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 relative overflow-hidden flex flex-col md:flex-row items-center gap-6">
      {{-- Dekorasi Background Abstrak --}}
      <div class="absolute top-0 left-0 w-full h-24 md:h-full md:w-1/3 bg-gradient-to-r from-green-400 to-emerald-600 md:rounded-r-[100px] rounded-b-[50%] opacity-10 md:opacity-100 z-0"></div>
      
      {{-- Foto Avatar --}}
      <div class="relative z-10 shrink-0">
        <div class="relative inline-block">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_lengkap }}&background=random&size=128" 
                 alt="Avatar" 
                 class="w-28 h-28 md:w-32 md:h-32 rounded-full border-4 border-white shadow-xl object-cover bg-white">
            {{-- Badge Role --}}
            <span class="absolute bottom-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full border-2 border-white shadow-sm">
                {{ Auth::user()->role === 'kasir' ? 'KASIR' : 'ADMIN' }}
            </span>
        </div>
      </div>

      {{-- Info User --}}
      <div class="relative z-10 text-center md:text-left md:ml-4 flex-1">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">{{ Auth::user()->nama_lengkap }}</h2>
        <p class="text-gray-500 font-medium">{{ Auth::user()->email }}</p>
        <p class="text-gray-400 text-sm mt-1 flex items-center justify-center md:justify-start gap-1">
            <i class="fa-solid fa-store"></i>
            {{ Auth::user()->outlet->nama_outlet ?? 'Outlet Tidak Diketahui' }}
        </p>
      </div>
    </div>

    {{-- 3. Statistik Ringkas (Grid 2 Kolom di HP, 4 di PC) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between transition hover:-translate-y-1 hover:shadow-md duration-300 group">
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-green-100 p-2.5 rounded-full text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-wallet text-lg"></i>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan</span>
            </div>
            <p class="text-xl font-bold text-gray-800">Rp 1.2jt</p> {{-- Nanti bisa diganti data dinamis --}}
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between transition hover:-translate-y-1 hover:shadow-md duration-300 group">
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-100 p-2.5 rounded-full text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-receipt text-lg"></i>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Transaksi</span>
            </div>
            <p class="text-xl font-bold text-gray-800">142</p>
        </div>
    </div>

    {{-- 4. MENU UTAMA (Grid Kotak Terpisah Warna-warni) --}}
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 pl-1">
            <i class="fa-solid fa-grid-2 text-green-600"></i> Menu Pintas
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            
            {{-- KOTAK 1: Edit Profil (Warna Orange) --}}
            <a href="{{ route('kasir.users.edit', Auth::id()) }}" 
               class="relative overflow-hidden block p-6 rounded-2xl bg-orange-50 border border-orange-100 hover:bg-orange-100 hover:shadow-md hover:border-orange-200 transition-all duration-300 group">
                {{-- Ikon Besar Transparan di Background --}}
                <div class="absolute -top-2 -right-2 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 group-hover:rotate-12">
                    <i class="fa-solid fa-user-pen text-8xl text-orange-500"></i>
                </div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-orange-500 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-pen text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Edit Data Diri</h4>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Perbarui nama, email, & informasi akun Anda.</p>
                </div>
            </a>

            {{-- KOTAK 2: Keamanan (Warna Ungu) --}}
            <a href="#" 
               class="relative overflow-hidden block p-6 rounded-2xl bg-purple-50 border border-purple-100 hover:bg-purple-100 hover:shadow-md hover:border-purple-200 transition-all duration-300 group">
                <div class="absolute -top-2 -right-2 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 group-hover:rotate-12">
                    <i class="fa-solid fa-lock text-8xl text-purple-500"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-purple-500 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-lock text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Keamanan</h4>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Ubah password & pengaturan privasi akun.</p>
                </div>
            </a>

            {{-- KOTAK 3: Kelola Produk (Warna Hijau/Emerald) --}}
            <a href="{{ route('kasir.products.index') }}" 
               class="relative overflow-hidden block p-6 rounded-2xl bg-emerald-50 border border-emerald-100 hover:bg-emerald-100 hover:shadow-md hover:border-emerald-200 transition-all duration-300 group">
                <div class="absolute -top-2 -right-2 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 group-hover:rotate-12">
                    <i class="fa-solid fa-box-open text-8xl text-emerald-600"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-box-open text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Kelola Produk</h4>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Tambah, edit, atau hapus menu outlet Anda.</p>
                </div>
            </a>

            {{-- KOTAK 4: Laporan (Warna Biru Muda/Cyan) --}}
            <a href="#" 
               class="relative overflow-hidden block p-6 rounded-2xl bg-cyan-50 border border-cyan-100 hover:bg-cyan-100 hover:shadow-md hover:border-cyan-200 transition-all duration-300 group">
                <div class="absolute -top-2 -right-2 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 group-hover:rotate-12">
                    <i class="fa-solid fa-chart-line text-8xl text-cyan-600"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-cyan-600 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">Laporan</h4>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Lihat grafik penjualan & performa outlet.</p>
                </div>
            </a>

            {{-- KOTAK 5: Logout (Warna Merah) --}}
            <form action="{{ route('logout') }}" method="POST" class="block h-full">
                @csrf
                <button type="submit" class="w-full h-full text-left relative overflow-hidden block p-6 rounded-2xl bg-red-50 border border-red-100 hover:bg-red-100 hover:shadow-md hover:border-red-200 transition-all duration-300 group cursor-pointer">
                    <div class="absolute -top-2 -right-2 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 group-hover:rotate-12">
                        <i class="fa-solid fa-right-from-bracket text-8xl text-red-500"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-red-500 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-right-from-bracket text-xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800">Keluar Aplikasi</h4>
                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">Akhiri sesi dan kembali ke login.</p>
                    </div>
                </button>
            </form>

        </div>
    </div>

  </div>
</div>
@endsection
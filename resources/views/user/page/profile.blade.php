@extends('user.layouts.app')

@section('title', 'Profil Kasir')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
  <div class="container mx-auto max-w-4xl">

    {{-- Header Profil --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden flex flex-col md:flex-row items-center gap-6 mb-6">
      <div class="absolute top-0 right-0 w-64 h-64 bg-gray-50 rounded-full blur-3xl -mr-16 -mt-16 z-0 pointer-events-none"></div>
      
      <div class="relative z-10 shrink-0">
        <div class="relative inline-block">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar" class="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-white shadow-md object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_lengkap }}&background=0F172A&color=fff&size=128" alt="Avatar" class="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-white shadow-md object-cover">
            @endif
            <span class="absolute bottom-1 right-1 bg-gray-900 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white shadow-sm uppercase tracking-wide">{{ Auth::user()->role }}</span>
        </div>
      </div>

      <div class="relative z-10 text-center md:text-left flex-1">
        <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->nama_lengkap }}</h2>
        <p class="text-gray-500 font-medium text-sm mt-1">{{ Auth::user()->email }}</p>
        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg border border-gray-200">
            <i class="fa-solid fa-store text-gray-400 text-xs"></i>
            <span class="text-xs font-bold text-gray-600">{{ Auth::user()->outlet->nama_outlet ?? 'Outlet Tidak Diketahui' }}</span>
        </div>
      </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-5 mb-8">
        {{-- Pendapatan (Teks Diubah & Tidak Capslock) --}}
        <a href="{{ route('kasir.profile.income') }}" class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center hover:border-green-200 hover:shadow-md transition-all cursor-pointer">
            <span class="text-xs font-bold text-gray-400 tracking-wider mb-2">Pendapatan kasir</span>
            <p class="text-xl font-extrabold text-green-600 group-hover:scale-105 transition-transform">
                Rp {{ number_format($userIncomeToday ?? 0, 0, ',', '.') }}
            </p> 
        </a>

        {{-- Transaksi (Teks Diubah & Tidak Capslock) --}}
        <a href="{{ route('kasir.profile.transactions') }}" class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center hover:border-blue-200 hover:shadow-md transition-all cursor-pointer">
            <span class="text-xs font-bold text-gray-400 tracking-wider mb-2">Transaksi kasir</span>
            <p class="text-xl font-extrabold text-blue-600 group-hover:scale-105 transition-transform">
                {{ $userTxToday ?? 0 }}
            </p>
        </a>
    </div>

    {{-- Menu Pintas --}}
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4 px-1">Pengaturan Akun</h3>
        <div class="space-y-4">
            
            <a href="{{ route('kasir.profile.edit') }}" 
               class="group flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Edit Data Diri</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Update foto & kata sandi</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-gray-400 transition-colors text-xs"></i>
            </a>

            <a href="{{ route('kasir.users-outlets.index') }}" 
               class="group flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Kelola Kasir / User</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Tambah atau edit akses staff</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-gray-400 transition-colors text-xs"></i>
            </a>

            <a href="{{ route('kasir.products.index') }}" class="group flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Kelola Produk</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Atur menu & stok barang</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-gray-400 transition-colors text-xs"></i>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                @csrf
                <button type="submit" class="w-full group flex items-center justify-between p-4 bg-white rounded-2xl border border-red-100 shadow-sm hover:bg-red-50 hover:border-red-200 transition-all duration-300 text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-600 text-sm">Keluar Aplikasi</h4>
                            <p class="text-xs text-red-400 mt-0.5">Akhiri sesi kasir</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-red-200 group-hover:text-red-300 transition-colors text-xs"></i>
                </button>
            </form>

        </div>
    </div>
  </div>
</section>
@endsection
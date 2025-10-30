@extends('user.layouts.app')

@section('title', 'Profil Kasir')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 via-emerald-50 to-white py-10 px-6 flex justify-center">
  <div class="w-full max-w-md bg-white rounded-3xl shadow-lg overflow-hidden">

    <div class="bg-gradient-to-r from-emerald-700 via-green-600 to-emerald-400 text-white p-8 text-center relative">
      <div class="flex flex-col items-center">
        <img src="https://placehold.co/100x100/png?text=Kasir" alt="Kasir" class="w-24 h-24 rounded-full border-4 border-white shadow-md mb-3">
        <h2 class="text-xl font-semibold">Kasir Kantin Kampus</h2>
        <p class="text-emerald-100 text-sm mb-6">kasir@kantin.com</p>
      </div>
    </div>

    <div class="flex justify-around bg-white shadow-sm rounded-2xl p-4 mx-5 -mt-4 relative z-10">
      <div class="text-center">
        <p class="text-emerald-600 font-semibold text-lg">Rp 3.214.000</p>
        <p class="text-gray-500 text-sm">Pendapatan</p>
      </div>
      <div class="text-center border-l border-gray-200"></div>
      <div class="text-center">
        <p class="text-red-600 font-semibold text-lg">Rp 1.640.000</p>
        <p class="text-gray-500 text-sm">Pengeluaran</p>
      </div>
    </div>

    <div class="mt-10 px-6">
      <h3 class="text-gray-700 text-sm font-semibold mb-3">MENU KASIR</h3>
      <div class="bg-white divide-y divide-gray-100 rounded-2xl shadow-sm overflow-hidden">

        <a href="#" class="flex items-center justify-between px-4 py-4 hover:bg-emerald-50 transition">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-cash-register text-emerald-600 text-lg"></i>
            <span class="text-gray-800 font-medium">Kasir</span>
          </div>
          <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-4 hover:bg-emerald-50 transition">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-utensils text-emerald-600 text-lg"></i>
            <span class="text-gray-800 font-medium">Daftar Menu</span>
          </div>
          <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-4 hover:bg-emerald-50 transition">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-chart-line text-emerald-600 text-lg"></i>
            <span class="text-gray-800 font-medium">Laporan Penjualan</span>
          </div>
          <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-4 hover:bg-emerald-50 transition">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-bell text-emerald-600 text-lg"></i>
            <span class="text-gray-800 font-medium">Notifikasi</span>
          </div>
          <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-4 hover:bg-emerald-50 transition">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-gear text-emerald-600 text-lg"></i>
            <span class="text-gray-800 font-medium">Pengaturan Akun</span>
          </div>
          <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
        </a>

        <a href="{{ route('logout') }}" class="flex items-center justify-between px-4 py-4 hover:bg-red-50 transition">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-right-from-bracket text-red-600 text-lg"></i>
            <span class="text-red-600 font-medium">Keluar</span>
          </div>
          <i class="fa-solid fa-chevron-right text-red-400 text-sm"></i>
        </a>

      </div>
    </div>

  </div>
</div>
@endsection

@extends('user.layouts.app')

@section('title', 'Profil Kasir')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white flex justify-center py-10 px-6">
  <div class="w-full max-w-sm">

   {{-- Header dengan warna hijau muda polos --}}
    <div class="relative bg-green-200 rounded-3xl p-8 shadow-md text-center">
      <div class="flex flex-col items-center">
        <div class="relative">
          <img src="https://placehold.co/100x100/png?text=Kasir" alt="Kasir" class="w-24 h-24 rounded-full border-4 border-white shadow-md">
          <button class="absolute bottom-1 right-1 bg-emerald-500 hover:bg-emerald-600 text-white text-xs p-2 rounded-full shadow">
            <i class="fa-solid fa-pen"></i>
          </button>
        </div>
        <h2 class="mt-3 text-lg font-semibold text-gray-800">Kasir Kantin Kampus</h2>
        <p class="text-gray-600 text-sm">kasir@kantin.com</p>
      </div>
    </div>


    {{-- Ringkasan Keuangan --}}
    <div class="bg-white shadow-md rounded-2xl mt-6 p-4">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-gray-700 font-semibold text-sm">Oktober 2025</h3>
        <i class="fa-solid fa-calendar text-emerald-500"></i>
      </div>
      <div class="grid grid-cols-3 text-center">
        <div>
          <p class="text-emerald-600 font-semibold">Rp500.000</p>
          <p class="text-gray-500 text-xs">Total</p>
        </div>
        <div>
          <p class="text-green-600 font-semibold">Rp1.000.000</p>
          <p class="text-gray-500 text-xs">Pendapatan</p>
        </div>
        <div>
          <p class="text-red-500 font-semibold">Rp500.000</p>
          <p class="text-gray-500 text-xs">Pengeluaran</p>
        </div>
      </div>
    </div>

    {{-- Menu Utama --}}
    <div class="bg-white rounded-2xl shadow-md mt-6 divide-y divide-gray-100 overflow-hidden">

      <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-green-50 transition">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-user-pen text-green-500"></i>
          <span class="text-gray-700 font-medium">Edit Profil</span>
        </div>
        <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
      </a>

      <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-green-50 transition">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-user-plus text-green-500"></i>
          <span class="text-gray-700 font-medium">Tambah Akun</span>
        </div>
        <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
      </a>

      <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-green-50 transition">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-utensils text-green-500"></i>
          <span class="text-gray-700 font-medium">Daftar Menu</span>
        </div>
        <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
      </a>

      <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-green-50 transition">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-chart-line text-green-500"></i>
          <span class="text-gray-700 font-medium">Laporan Penjualan</span>
        </div>
        <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
      </a>

      <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-green-50 transition">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-gear text-green-500"></i>
          <span class="text-gray-700 font-medium">Pengaturan Akun</span>
        </div>
        <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
      </a>

      <a href="{{ route('logout') }}" class="flex items-center justify-between px-5 py-4 hover:bg-red-50 transition">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-right-from-bracket text-red-500"></i>
          <span class="text-red-600 font-medium">Logout</span>
        </div>
        <i class="fa-solid fa-chevron-right text-red-400 text-sm"></i>
      </a>
    </div>

  </div>
</div>
@endsection

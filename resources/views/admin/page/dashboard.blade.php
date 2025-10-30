@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
  <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

  <div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-gray-600 text-sm">Outlet Terdaftar</h2>
      <p class="text-2xl font-bold">{{ $totalOutlet ?? 15 }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-gray-600 text-sm">Outlet Aktif</h2>
      <p class="text-2xl font-bold text-green-500">{{ $outletAktif ?? 12 }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-gray-600 text-sm">Outlet Tidak Aktif</h2>
      <p class="text-2xl font-bold text-red-500">{{ $outletNonAktif ?? 3 }}</p>
    </div>
  </div>

  <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="font-semibold mb-2">Grafik Penjualan (30 Hari Terakhir)</h2>
    <div class="h-64 flex items-center justify-center text-gray-400">
      [Grafik Placeholder]
    </div>
  </div>
@endsection

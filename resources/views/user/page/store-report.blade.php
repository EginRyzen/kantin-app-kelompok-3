@extends('user.layouts.app')

@section('title', 'Laporan Toko')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="text-2xl font-extrabold text-gray-800">Laporan Toko 🏪</h1>
        <p class="text-sm text-gray-500">Pantau omzet outlet secara keseluruhan.</p>
    </div>

    {{-- Grid Ringkasan (KLIK UNTUK DETAIL) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        {{-- Kartu 1: Hari Ini --}}
        {{-- PERBAIKAN: route('kasir.store.report.today') --}}
        <a href="{{ route('kasir.store.report.today') }}" class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-green-500 flex justify-between items-center hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer group">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-1 group-hover:text-green-600 transition-colors">Hari Ini</p>
                <h3 class="text-xl font-extrabold text-gray-800">Rp {{ number_format($incomeToday, 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </a>

        {{-- Kartu 2: Minggu Ini --}}
        {{-- PERBAIKAN: route('kasir.store.report.week') --}}
        <a href="{{ route('kasir.store.report.week') }}" class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-blue-500 flex justify-between items-center hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer group">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-1 group-hover:text-blue-600 transition-colors">Minggu Ini</p>
                <h3 class="text-xl font-extrabold text-gray-800">Rp {{ number_format($incomeThisWeek, 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-calendar-week"></i>
            </div>
        </a>

        {{-- Kartu 3: Bulan Ini --}}
        {{-- PERBAIKAN: route('kasir.store.report.month') --}}
        <a href="{{ route('kasir.store.report.month') }}" class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-purple-500 flex justify-between items-center hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer group">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase mb-1 group-hover:text-purple-600 transition-colors">Bulan Ini</p>
                <h3 class="text-xl font-extrabold text-gray-800">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-calendar"></i>
            </div>
        </a>
    </div>

    {{-- Riwayat 7 Hari Terakhir --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-gray-600"></i>
                Performa 7 Hari Terakhir
            </h3>
            {{-- PERBAIKAN: route('kasir.store.report.performance') --}}
            <a href="{{ route('kasir.store.report.performance') }}" class="text-xs font-bold text-green-600 hover:text-green-800 bg-green-50 px-3 py-1.5 rounded-full transition-colors">
                Lihat Lebih Lengkap &rarr;
            </a>
        </div>

        @if($last7Days->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <p>Belum ada data penjualan minggu ini.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($last7Days as $day)
                @php
                    $isToday = $day->date == \Carbon\Carbon::today()->format('Y-m-d');
                @endphp
                <div class="flex items-center justify-between p-4 rounded-2xl border {{ $isToday ? 'bg-green-50 border-green-200' : 'bg-white border-gray-100' }}">
                    <div class="flex items-center gap-4">
                        <div class="text-center min-w-[50px]">
                            <span class="block text-xs font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($day->date)->translatedFormat('M') }}</span>
                            <span class="block text-xl font-extrabold {{ $isToday ? 'text-green-600' : 'text-gray-700' }}">
                                {{ \Carbon\Carbon::parse($day->date)->format('d') }}
                            </span>
                        </div>
                        <div class="h-8 w-px bg-gray-200"></div>
                        <div>
                            <p class="font-bold text-sm {{ $isToday ? 'text-green-800' : 'text-gray-800' }}">
                                {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l') }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $day->count }} Transaksi</p>
                        </div>
                    </div>
                    <span class="font-bold text-sm {{ $isToday ? 'text-green-700' : 'text-gray-600' }}">
                        Rp {{ number_format($day->total, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

  </div>
</div>
@endsection
@extends('user.layouts.app')

@section('title', 'Laporan Toko')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
  <div class="container mx-auto max-w-6xl">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Toko</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau omzet outlet secara keseluruhan.</p>
    </div>

    {{-- Grid Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        
        {{-- Kartu 1: Hari Ini (HIJAU) --}}
        <a href="{{ route('kasir.store.report.today') }}" class="group bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex justify-between items-center cursor-pointer">
            <div>
                {{-- Hapus 'uppercase', ganti jadi 'capitalize' atau biarkan normal --}}
                <p class="text-xs font-bold text-gray-400 mb-1 group-hover:text-green-600 transition-colors">Hari ini</p>
                <h3 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($incomeToday, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-calendar-day text-lg"></i>
            </div>
        </a>

        {{-- Kartu 2: Minggu Ini (UBAH JADI HIJAU) --}}
        <a href="{{ route('kasir.store.report.week') }}" class="group bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex justify-between items-center cursor-pointer">
            <div>
                <p class="text-xs font-bold text-gray-400 mb-1 group-hover:text-green-600 transition-colors">Minggu ini</p>
                <h3 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($incomeThisWeek, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-calendar-week text-lg"></i>
            </div>
        </a>

        {{-- Kartu 3: Bulan Ini (UBAH JADI HIJAU) --}}
        <a href="{{ route('kasir.store.report.month') }}" class="group bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex justify-between items-center cursor-pointer">
            <div>
                <p class="text-xs font-bold text-gray-400 mb-1 group-hover:text-green-600 transition-colors">Bulan ini</p>
                <h3 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-calendar text-lg"></i>
            </div>
        </a>
    </div>

    {{-- Riwayat 7 Hari Terakhir --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-gray-500"></i>
                Performa 7 Hari Terakhir
            </h3>
            <a href="{{ route('kasir.store.report.performance') }}" class="text-xs font-bold text-green-600 hover:text-green-800 bg-green-50 px-4 py-2 rounded-full transition-colors">
                Lihat Detail &rarr;
            </a>
        </div>

        @if($last7Days->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <p class="font-medium">Belum ada data penjualan minggu ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($last7Days as $day)
                @php
                    $isToday = $day->date == \Carbon\Carbon::today()->format('Y-m-d');
                @endphp
                <div class="flex items-center justify-between p-4 rounded-xl border transition-all duration-200 {{ $isToday ? 'bg-green-50 border-green-200 ring-1 ring-green-200' : 'bg-white border-gray-100 hover:border-gray-200' }}">
                    <div class="flex items-center gap-5">
                        <div class="text-center min-w-[50px]">
                            {{-- Hapus uppercase di sini juga jika mau, tapi biasanya bulan singkatan bagus kapital (misal: OCT) --}}
                            {{-- Saya biarkan uppercase untuk singkatan bulan agar rapi, tapi bisa dihapus class 'uppercase' jika mau --}}
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">{{ \Carbon\Carbon::parse($day->date)->translatedFormat('M') }}</span>
                            <span class="block text-2xl font-extrabold {{ $isToday ? 'text-green-600' : 'text-gray-800' }}">
                                {{ \Carbon\Carbon::parse($day->date)->format('d') }}
                            </span>
                        </div>
                        <div class="h-10 w-px bg-gray-100"></div>
                        <div>
                            <p class="font-bold text-sm {{ $isToday ? 'text-green-800' : 'text-gray-800' }}">
                                {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $day->count }} Transaksi</p>
                        </div>
                    </div>
                    <span class="font-extrabold text-sm {{ $isToday ? 'text-green-700' : 'text-gray-700' }}">
                        Rp {{ number_format($day->total, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

  </div>
</section>
@endsection
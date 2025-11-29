@extends('user.layouts.app')

@section('title', 'Laporan Toko')

@section('content')
    <section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
        <div class="container mx-auto max-w-6xl">

            {{-- Header & Filter --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Laporan Toko</h1>
                    <p class="text-sm text-gray-500 mt-1">Pantau omzet outlet secara keseluruhan.</p>
                </div>

                {{-- FORM FILTER BULAN --}}
                <form action="{{ route('kasir.store.report') }}" method="GET"
                    class="flex items-center bg-white p-1.5 rounded-lg border border-gray-200 shadow-sm">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-regular fa-calendar text-gray-400"></i>
                        </div>
                        <input type="month" name="filter_month" value="{{ $filterDate->format('Y-m') }}"
                            onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2">
                    </div>
                    <span class="text-xs text-gray-400 mx-2 hidden sm:block">Pilih Bulan</span>
                </form>
            </div>

            {{-- Grid Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

                {{-- Kartu 1: Hari Ini --}}
                {{-- LOGIKA: Jika Bulan Ini (True) -> Tampilkan Link. Jika False -> Tampilkan Div Disabled --}}
                @if ($isCurrentMonth)
                    <a href="{{ route('kasir.store.report.today') }}"
                        class="group bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex justify-between items-center cursor-pointer">
                    @else
                        {{-- Tambahkan 'pointer-events-none' dan 'grayscale' agar terlihat jelas mati --}}
                        <div
                            class="group bg-gray-50 p-5 rounded-2xl shadow-sm border border-gray-200 flex justify-between items-center opacity-50 cursor-not-allowed pointer-events-none select-none">
                @endif
                <div>
                    <p class="text-xs font-bold text-gray-400 mb-1">Hari ini</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">
                        {{-- Jika disabled, Anda bisa menampilkan strip (-) atau tetap angkanya --}}
                        {{ $isCurrentMonth ? 'Rp ' . number_format($incomeToday, 0, ',', '.') : '-' }}
                    </h3>
                </div>
                <div
                    class="w-12 h-12 rounded-full {{ $isCurrentMonth ? 'bg-green-50 text-green-600' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center">
                    <i class="fa-solid fa-calendar-day text-lg"></i>
                </div>
                @if ($isCurrentMonth)
                    </a>
                @else
            </div>
            @endif


            {{-- Kartu 2: Minggu Ini --}}
            @if ($isCurrentMonth)
                <a href="{{ route('kasir.store.report.week') }}"
                    class="group bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex justify-between items-center cursor-pointer">
                @else
                    <div
                        class="group bg-gray-50 p-5 rounded-2xl shadow-sm border border-gray-200 flex justify-between items-center opacity-50 cursor-not-allowed pointer-events-none select-none">
            @endif
            <div>
                <p class="text-xs font-bold text-gray-400 mb-1">Minggu ini</p>
                <h3 class="text-2xl font-extrabold text-gray-800">
                    {{ $isCurrentMonth ? 'Rp ' . number_format($incomeThisWeek, 0, ',', '.') : '-' }}
                </h3>
            </div>
            <div
                class="w-12 h-12 rounded-full {{ $isCurrentMonth ? 'bg-blue-50 text-blue-600' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center">
                <i class="fa-solid fa-calendar-week text-lg"></i>
            </div>
            @if ($isCurrentMonth)
                </a>
            @else
        </div>
        @endif


        {{-- Kartu 3: Bulan Terpilih (Selalu Aktif) --}}
        <div
            class="group bg-white p-5 rounded-2xl shadow-sm border border-green-200 ring-1 ring-green-100 flex justify-between items-center relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold text-green-600 mb-1 uppercase">Total {{ $currentMonthName }}</p>
                <h3 class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($incomeSelectedMonth, 0, ',', '.') }}
                </h3>
            </div>
            <div
                class="w-12 h-12 rounded-full bg-green-600 flex items-center justify-center text-white relative z-10 shadow-lg shadow-green-200">
                <i class="fa-solid fa-filter text-lg"></i>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-green-50 rounded-full opacity-50"></div>
        </div>

        </div>

        {{-- List Riwayat Harian (Sesuai Filter Bulan) --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-gray-500"></i>
                    Rincian Harian: <span class="text-green-600 ml-1">{{ $currentMonthName }}</span>
                </h3>
            </div>

            @if ($dailyReports->isEmpty())
                <div class="text-center py-12 text-gray-400 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                        <i class="fa-regular fa-folder-open text-2xl text-gray-400"></i>
                    </div>
                    <p class="font-medium">Tidak ada transaksi pada bulan {{ $currentMonthName }}.</p>
                </div>
            @else
                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach ($dailyReports as $day)
                        @php
                            // Cek apakah tanggal list sama dengan hari ini (untuk highlight)
                            $isToday = $day->date == \Carbon\Carbon::today()->format('Y-m-d');
                        @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-xl border transition-all duration-200 {{ $isToday ? 'bg-green-50 border-green-200 ring-1 ring-green-200' : 'bg-white border-gray-100 hover:border-gray-200' }}">
                            <div class="flex items-center gap-5">
                                <div class="text-center min-w-[50px]">
                                    <span
                                        class="block text-xs font-bold text-gray-400 uppercase tracking-wide">{{ \Carbon\Carbon::parse($day->date)->translatedFormat('M') }}</span>
                                    <span
                                        class="block text-2xl font-extrabold {{ $isToday ? 'text-green-600' : 'text-gray-800' }}">
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

    {{-- Style Scrollbar Tambahan --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
@endsection

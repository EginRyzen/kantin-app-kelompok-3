@extends('user.layouts.app')

@section('title', 'Detail Pendapatan')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
  <div class="container mx-auto max-w-5xl">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('kasir.profile.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Laporan Keuangan</h1>
    </div>

    {{-- Layout Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Kartu Uang Hari Ini --}}
        <div class="lg:col-span-1">
            {{-- PERUBAHAN WARNA: from-green-400 to-green-600 (Lebih Cerah) --}}
            <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-3xl p-6 text-white shadow-lg shadow-green-100 relative overflow-hidden sticky top-6">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-20 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                
                <div class="relative z-10 text-center py-4 lg:py-8">
                    <div class="w-12 h-12 bg-white/25 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 border border-white/20">
                        <i class="fa-solid fa-wallet text-xl"></i>
                    </div>
                    <p class="text-green-50 text-sm font-medium mb-2">Pendapatan Hari Ini</p>
                    <h2 class="text-4xl font-extrabold tracking-tight drop-shadow-sm">
                        Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                    </h2>
                    <p class="text-xs text-green-100 mt-2">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: List Bulanan --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 min-h-[300px]">
                <h3 class="font-bold text-gray-800 mb-5 text-lg flex items-center gap-2">
                    <i class="fa-solid fa-history text-green-500"></i>
                    Riwayat Bulanan
                </h3>

                @if($monthlyRecap->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-regular fa-calendar-xmark text-2xl"></i>
                        </div>
                        <p>Belum ada data keuangan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($monthlyRecap as $month)
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-50 hover:border-green-100 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-white text-green-500 flex items-center justify-center font-bold text-xs shadow-sm group-hover:bg-green-500 group-hover:text-white transition-colors">
                                    {{ substr($month->month_name, 0, 3) }}
                                </div>
                                <span class="font-bold text-gray-700 text-sm group-hover:text-green-800">{{ $month->month_name }}</span>
                            </div>
                            <span class="font-bold text-green-600 text-sm">
                                Rp {{ number_format($month->total_revenue, 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

  </div>
</section>
@endsection
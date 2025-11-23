@extends('user.layouts.app')

@section('title', 'Detail Pendapatan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('kasir.profile.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Laporan Keuangan</h1>
    </div>

    {{-- Kartu Uang Hari Ini --}}
    <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-3xl p-6 text-white shadow-lg shadow-green-200 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
        
        <div class="relative z-10 text-center py-4">
            <p class="text-green-100 text-sm font-medium mb-2">Pendapatan Hari Ini</p>
            <h2 class="text-4xl font-extrabold tracking-tight">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </h2>
            <p class="text-xs text-green-200 mt-2">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
    </div>

    {{-- List Bulanan --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-5 text-lg">Riwayat Bulanan</h3>

        @if($monthlyRecap->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <p>Belum ada data keuangan.</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($monthlyRecap as $month)
                <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold text-xs">
                            {{ substr($month->month_name, 0, 3) }}
                        </div>
                        <span class="font-bold text-gray-700 text-sm">{{ $month->month_name }}</span>
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
@endsection
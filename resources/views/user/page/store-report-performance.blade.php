@extends('user.layouts.app')

@section('title', 'Performa Toko')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        {{-- PERBAIKAN: route('kasir.store.report') --}}
        <a href="{{ route('kasir.store.report') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Performa Penjualan</h1>
            <p class="text-xs text-gray-500">Ringkasan 30 hari terakhir</p>
        </div>
    </div>

    {{-- List Rekap Harian --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        @if($dailyReports->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <p>Belum ada data penjualan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($dailyReports as $day)
                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-green-50 transition-colors border border-gray-100 group">
                    <div class="flex items-center gap-4">
                        {{-- Tanggal Besar --}}
                        <div class="text-center min-w-[50px] bg-gray-50 rounded-xl p-2 group-hover:bg-white transition-colors">
                            <span class="block text-[10px] font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($day->date)->translatedFormat('M') }}</span>
                            <span class="block text-lg font-extrabold text-gray-700 group-hover:text-green-600">
                                {{ \Carbon\Carbon::parse($day->date)->format('d') }}
                            </span>
                        </div>
                        
                        <div>
                            <p class="font-bold text-sm text-gray-800">
                                {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l, d F Y') }}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                    {{ $day->count }} Transaksi
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <span class="font-bold text-sm text-green-600">
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
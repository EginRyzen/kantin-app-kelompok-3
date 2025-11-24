@extends('user.layouts.app')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto space-y-6">

    {{-- Header & Navigasi --}}
    <div class="flex items-center gap-4 mb-6">
        {{-- PERBAIKAN: route('kasir.store.report') --}}
        <a href="{{ route('kasir.store.report') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ $title }}</h1>
            <p class="text-xs text-gray-500">{{ $dateLabel }}</p>
        </div>
    </div>

    {{-- Ringkasan Total Periode Ini --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center mb-6">
        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
        <h2 class="text-3xl font-extrabold text-green-600">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </h2>
        <p class="text-xs text-gray-400 mt-2">{{ count($transactions) }} Transaksi Berhasil</p>
    </div>

    {{-- List Transaksi --}}
    <h3 class="font-bold text-gray-700 mb-3 ml-1">Rincian Transaksi</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($transactions as $trx)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                
                <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-50">
                    <div>
                        <p class="text-xs font-bold text-gray-900">#{{ $trx->nomor_invoice }}</p>
                        <p class="text-[10px] text-gray-400 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i> {{ $trx->created_at->format('d M, H:i') }}
                        </p>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <span class="text-xs text-gray-600">{{ $trx->user->nama_lengkap ?? 'Kasir' }}</span>
                    </div>
                    <span class="text-[10px] font-bold text-blue-500 uppercase bg-blue-50 px-2 py-0.5 rounded">
                        {{ $trx->paymentMethod->nama_metode ?? 'Tunai' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
                <i class="fa-solid fa-inbox text-3xl mb-2 opacity-50"></i>
                <p>Tidak ada transaksi pada periode ini.</p>
            </div>
        @endforelse
    </div>

  </div>
</div>
@endsection
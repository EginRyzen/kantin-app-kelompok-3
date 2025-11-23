@extends('user.layouts.app')

@section('title', 'Detail Transaksi Hari Ini')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('kasir.profile.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Transaksi Hari Ini</h1>
            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
    </div>

    {{-- Ringkasan Item Terjual --}}
    <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 flex justify-between items-center">
        <span class="text-blue-800 font-medium text-sm">Total Item Terjual</span>
        <span class="text-blue-600 font-extrabold text-xl">{{ $totalItemsSold }} pcs</span>
    </div>

    {{-- List Transaksi --}}
    <div class="space-y-4">
        @forelse($todaysTransactions as $trx)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                
                {{-- Header Struk --}}
                <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-50">
                    <div>
                        <p class="text-xs font-bold text-gray-900">#{{ $trx->nomor_invoice }}</p>
                        <p class="text-[10px] text-gray-400">{{ $trx->created_at->format('H:i') }} WIB</p>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                {{-- List Barang dalam Struk --}}
                <div class="space-y-2">
                    @foreach($trx->details as $detail)
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-500 text-xs bg-gray-100 px-1.5 py-0.5 rounded">{{ $detail->quantity }}x</span>
                                <span class="text-gray-700 truncate max-w-[150px]">{{ $detail->product->nama_produk ?? 'Produk Terhapus' }}</span>
                            </div>
                            <span class="text-gray-400 text-xs">
                                Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Footer Struk --}}
                <div class="mt-3 pt-2 border-t border-gray-50 flex justify-between items-center">
                    <span class="text-[10px] text-gray-400">Pelanggan: {{ $trx->customer->nama_pelanggan ?? 'Umum' }}</span>
                    <span class="text-[10px] font-bold text-blue-500 uppercase">{{ $trx->paymentMethod->nama_metode ?? 'CASH' }}</span>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-300">
                    <i class="fa-solid fa-basket-shopping text-2xl"></i>
                </div>
                <p class="text-gray-500 font-medium text-sm">Belum ada penjualan hari ini.</p>
                <p class="text-xs text-gray-400 mt-1">Semangat jualan!</p>
            </div>
        @endforelse
    </div>

  </div>
</div>
@endsection
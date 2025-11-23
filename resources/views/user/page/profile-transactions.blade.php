@extends('user.layouts.app')

@section('title', 'Detail Transaksi Hari Ini')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  {{-- Ubah container jadi lebar --}}
  <div class="max-w-6xl mx-auto space-y-6">

    {{-- Header & Summary Wrapper --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        {{-- Kiri: Judul --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('kasir.profile.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-gray-50 transition-colors shrink-0">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Transaksi Hari Ini</h1>
                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            </div>
        </div>

        {{-- Kanan: Ringkasan Item Terjual --}}
        <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 flex items-center justify-between md:w-auto w-full gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-box"></i>
                </div>
                <span class="text-blue-800 font-medium text-sm">Total Item Terjual</span>
            </div>
            <span class="text-blue-600 font-extrabold text-xl">{{ $totalItemsSold }} <span class="text-xs font-normal">pcs</span></span>
        </div>
    </div>

    {{-- List Transaksi (Grid Responsif) --}}
    {{-- HP: 1 Kolom, Tablet: 2 Kolom, Laptop: 3 Kolom --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($todaysTransactions as $trx)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all h-full flex flex-col">
                
                {{-- Header Struk --}}
                <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-50">
                    <div>
                        <p class="text-xs font-bold text-gray-900">#{{ $trx->nomor_invoice }}</p>
                        <p class="text-[10px] text-gray-400 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i> {{ $trx->created_at->format('H:i') }} WIB
                        </p>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-100">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                {{-- List Barang dalam Struk --}}
                <div class="space-y-2 flex-1">
                    @foreach($trx->details as $detail)
                        <div class="flex justify-between items-start text-sm">
                            <div class="flex items-start gap-2">
                                <span class="font-bold text-gray-500 text-[10px] bg-gray-100 px-1.5 py-0.5 rounded mt-0.5 shrink-0">{{ $detail->quantity }}x</span>
                                <span class="text-gray-700 text-xs leading-snug line-clamp-2">{{ $detail->product->nama_produk ?? 'Produk Terhapus' }}</span>
                            </div>
                            <span class="text-gray-400 text-xs shrink-0 ml-2">
                                Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Footer Struk --}}
                <div class="mt-4 pt-3 border-t border-gray-50 flex justify-between items-center bg-gray-50/50 -mx-5 -mb-5 px-5 py-3 rounded-b-2xl">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 uppercase font-bold">Pelanggan</span>
                        <span class="text-xs text-gray-700 font-medium truncate max-w-[100px]" title="{{ $trx->customer->nama_pelanggan ?? 'Umum' }}">
                            {{ $trx->customer->nama_pelanggan ?? 'Umum' }}
                        </span>
                    </div>
                    <div class="flex flex-col text-right">
                        <span class="text-[10px] text-gray-400 uppercase font-bold">Metode</span>
                        <span class="text-xs font-bold text-blue-500 uppercase bg-blue-50 px-2 py-0.5 rounded">
                            {{ $trx->paymentMethod->nama_metode ?? 'CASH' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                    <i class="fa-solid fa-basket-shopping text-3xl"></i>
                </div>
                <p class="text-gray-600 font-bold text-lg">Belum ada penjualan hari ini.</p>
                <p class="text-sm text-gray-400 mt-1">Transaksi baru akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

  </div>
</div>
@endsection
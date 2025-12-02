@extends('user.layouts.app')

@section('title', 'Riwayat Stok')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.manajemen.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Riwayat Stok</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Pantau keluar masuk barang.</p>
                </div>
            </div>
        </div>

        {{-- List Movement (Pengganti Tabel) --}}
        <div class="space-y-4">
            @forelse($movements as $item)
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    
                    {{-- Bagian Kiri: Info Produk --}}
                    <div class="flex items-start gap-4">
                        {{-- Gambar Produk Kecil --}}
                        <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                            <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/100?text=IMG' }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 text-base leading-tight">
                                {{ $item->product->nama_produk ?? 'Produk Dihapus' }}
                            </h3>
                            
                            <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-medium">
                                    {{ $item->product->category->nama_kategori ?? 'Umum' }}
                                </span>
                                <span>•</span>
                                <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            {{-- Keterangan User / Supplier --}}
                            <div class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                                <i class="fa-regular fa-user text-gray-400"></i>
                                <span>{{ $item->user->nama_lengkap ?? 'Sistem' }}</span>
                                
                                @if($item->product && $item->product->supplier)
                                    <span class="text-gray-300">|</span>
                                    <i class="fa-solid fa-truck text-gray-400"></i>
                                    <span>{{ $item->product->supplier->nama_supplier }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Bagian Kanan: Indikator Stok --}}
                    <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center border-t sm:border-0 border-gray-100 pt-3 sm:pt-0 gap-2">
                        
                        {{-- Badge Movement --}}
                        @if(in_array($item->tipe_gerakan, ['restock', 'retur_penjualan']))
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-100">
                                    <i class="fa-solid fa-arrow-down transform rotate-180"></i>
                                    Masuk: {{ $item->jumlah }}
                                </span>
                                <p class="text-[10px] text-green-600 mt-1 font-medium capitalize text-right">
                                    {{ str_replace('_', ' ', $item->tipe_gerakan) }}
                                </p>
                            </div>
                        @else
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                    <i class="fa-solid fa-arrow-down"></i>
                                    Keluar: {{ $item->jumlah }}
                                </span>
                                <p class="text-[10px] text-red-500 mt-1 font-medium capitalize text-right">
                                    {{ str_replace('_', ' ', $item->tipe_gerakan) }}
                                </p>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Catatan (Footer Card) --}}
                @if($item->catatan)
                <div class="mt-3 pt-3 border-t border-gray-50">
                    <p class="text-xs text-gray-500 italic bg-gray-50 px-3 py-2 rounded-lg border border-dashed border-gray-200 inline-block w-full">
                        <i class="fa-regular fa-note-sticky mr-1"></i> "{{ $item->catatan }}"
                    </p>
                </div>
                @endif
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-16 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                    <i class="fa-solid fa-clipboard-list text-3xl"></i>
                </div>
                <p class="text-gray-600 font-bold">Belum ada riwayat stok.</p>
                <p class="text-sm text-gray-400 mt-1">Transaksi atau restock barang akan muncul di sini.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $movements->links() }}
        </div>

    </div>
</section>
@endsection
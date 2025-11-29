@extends('user.layouts.app')

@section('title', 'Metode Pembayaran')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-4xl">

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm flex items-center">
                <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.manajemen.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Metode Pembayaran</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Atur opsi pembayaran untuk pelanggan.</p>
                </div>
            </div>

            <a href="{{ route('kasir.payment-methods.create') }}" class="bg-green-600 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 transition flex items-center gap-2 text-sm font-bold">
                <i class="fa-solid fa-plus"></i> <span class="hidden sm:inline">Tambah Metode</span>
            </a>
        </div>

        {{-- List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($paymentMethods->isEmpty())
                <div class="text-center py-12 px-6">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Belum Ada Metode</h3>
                    <p class="text-gray-500 text-sm mt-1 mb-4">Tambahkan metode seperti Tunai, QRIS, atau Transfer.</p>
                    <a href="{{ route('kasir.payment-methods.create') }}" class="text-green-600 font-bold hover:underline text-sm">Tambah Sekarang</a>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($paymentMethods as $method)
                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between hover:bg-gray-50 transition duration-150 gap-4">
                        
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg shrink-0">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-base">{{ $method->nama_metode }}</h3>
                                
                                <div class="mt-1">
                                    @if($method->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span> Non-Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('kasir.payment-methods.edit', $method->id) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-yellow-50 hover:text-yellow-600 transition border border-transparent hover:border-yellow-200">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('kasir.payment-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Hapus metode {{ $method->nama_metode }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-600 transition border border-transparent hover:border-red-200">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</section>
@endsection
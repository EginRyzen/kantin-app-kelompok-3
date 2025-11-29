@extends('user.layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-4xl">

        {{-- Notifikasi Sukses/Error --}}
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
                {{-- Tombol Kembali ke Menu Manajemen --}}
                <a href="{{ route('kasir.manajemen.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Supplier</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola pemasok stok barang Anda.</p>
                </div>
            </div>

            {{-- Tombol Tambah --}}
            <a href="{{ route('kasir.suppliers.create') }}" class="bg-green-600 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 transition flex items-center gap-2 text-sm font-bold">
                <i class="fa-solid fa-plus"></i> <span class="hidden sm:inline">Tambah Supplier</span>
            </a>
        </div>

        {{-- List Supplier --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($suppliers->isEmpty())
                <div class="text-center py-12 px-6">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fa-solid fa-truck-fast text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Belum Ada Supplier</h3>
                    <p class="text-gray-500 text-sm mt-1 mb-4">Tambahkan data supplier agar stok lebih terorganisir.</p>
                    <a href="{{ route('kasir.suppliers.create') }}" class="text-green-600 font-bold hover:underline text-sm">Tambah Supplier Sekarang</a>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($suppliers as $supplier)
                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between hover:bg-gray-50 transition duration-150 gap-4">
                        
                        {{-- Info Utama --}}
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center font-bold text-lg shrink-0 mt-1">
                                {{ strtoupper(substr($supplier->nama_supplier, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-base">{{ $supplier->nama_supplier }}</h3>
                                
                                <div class="flex flex-col sm:flex-row gap-1 sm:gap-4 mt-1 text-sm text-gray-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-phone text-xs text-gray-400"></i> {{ $supplier->no_telp }}
                                    </span>
                                    @if($supplier->alamat)
                                    <span class="hidden sm:inline text-gray-300">|</span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-map-pin text-xs text-gray-400"></i> {{ Str::limit($supplier->alamat, 30) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex items-center justify-end gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('kasir.suppliers.edit', $supplier->id) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-yellow-50 hover:text-yellow-600 transition border border-transparent hover:border-yellow-200">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('kasir.suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier {{ $supplier->nama_supplier }}?');">
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
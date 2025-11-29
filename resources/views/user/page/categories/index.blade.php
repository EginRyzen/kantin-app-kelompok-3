@extends('user.layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-4xl">

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Header dengan Tombol Kembali --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali ke Menu Manajemen --}}
                <a href="{{ route('kasir.manajemen.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Kategori Produk</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Atur pengelompokan menu Anda.</p>
                </div>
            </div>

            {{-- Tombol Tambah --}}
            <a href="{{ route('kasir.categories.create') }}" class="bg-green-600 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 transition flex items-center gap-2 text-sm font-bold">
                <i class="fa-solid fa-plus"></i> <span class="hidden sm:inline">Tambah Baru</span>
            </a>
        </div>

        {{-- List Kategori --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($categories->isEmpty())
                <div class="text-center py-12 px-6">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fa-solid fa-layer-group text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Belum Ada Kategori</h3>
                    <p class="text-gray-500 text-sm mt-1 mb-4">Mulai tambahkan kategori untuk merapikan menu Anda.</p>
                    <a href="{{ route('kasir.categories.create') }}" class="text-green-600 font-bold hover:underline text-sm">Tambah Kategori Sekarang</a>
                </div>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                    <li class="p-4 sm:p-5 flex items-center justify-between hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr($category->nama_kategori, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">{{ $category->nama_kategori }}</h3>
                                <p class="text-xs text-gray-400">{{ $category->products->count() }} Produk</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('kasir.categories.edit', $category->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-yellow-100 hover:text-yellow-600 transition">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('kasir.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-600 transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</section>
@endsection
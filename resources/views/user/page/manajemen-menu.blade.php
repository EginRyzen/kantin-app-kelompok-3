@extends('user.layouts.app')

@section('title', 'Manajemen Data')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Data</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data master toko Anda di sini.</p>
            </div>
            {{-- Ikon Dekorasi --}}
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <i class="fa-solid fa-database"></i>
            </div>
        </div>

        {{-- Grid Menu --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- 1. MENU PRODUK --}}
            {{-- Mengarah ke route produk yang sudah ada --}}
            <a href="{{ route('kasir.products.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-green-200 hover:-translate-y-1 transition-all duration-300 cursor-pointer flex items-start gap-5">
                {{-- Ikon --}}
                <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl group-hover:bg-green-600 group-hover:text-white transition-colors duration-300 shrink-0">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                
                {{-- Teks --}}
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-700 transition-colors">Produk</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        Tambah, edit, dan atur stok produk yang dijual di outlet.
                    </p>
                    <span class="inline-flex items-center gap-1 mt-3 text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                        Kelola Produk <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            {{-- 2. MENU KATEGORI --}}
            {{-- Link sementara pagar (#) --}}
            <a href="{{ route('kasir.categories.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 cursor-pointer flex items-start gap-5">
                {{-- Ikon --}}
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shrink-0">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                
                {{-- Teks --}}
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-700 transition-colors">Kategori</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        Atur pengelompokan menu (Makanan, Minuman, Snack, dll).
                    </p>
                    <span class="inline-flex items-center gap-1 mt-3 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        Kelola Kategori <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            {{-- 3. MENU SUPPLIER --}}
            {{-- Link sementara pagar (#) --}}
            <a href="{{ route('kasir.suppliers.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-orange-200 hover:-translate-y-1 transition-all duration-300 cursor-pointer flex items-start gap-5 md:col-span-2 lg:col-span-1">
                {{-- Ikon --}}
                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300 shrink-0">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                
                {{-- Teks --}}
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-orange-700 transition-colors">Supplier</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        Data pemasok bahan baku atau produk jadi.
                    </p>
                    <span class="inline-flex items-center gap-1 mt-3 text-xs font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full">
                        Kelola Supplier <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

        </div>

    </div>
</section>
@endsection
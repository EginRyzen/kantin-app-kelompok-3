@extends('user.layouts.app')

{{-- Mengganti title halaman --}}
@section('title', 'Manajemen Produk')

@section('content')

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <!-- Header: Judul Halaman dan Tombol Tambah Produk -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manajemen Produk</h1>
            <p class="text-sm text-gray-500">Atur produk yang tersedia di kantin Anda.</p>
        </div>
        <a href="{{ route('kasir.products.create') }}"
            class="bg-green-600 text-white p-3 rounded-full shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mb-4 relative">
        <input name="nama_product" type="text" placeholder="Cari produk (misal: Nasi Goreng...)"
            class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
        <!-- Ikon search di dalam input -->
        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </div>

    <!-- Filter Kategori (Bisa di-scroll horizontal) -->
    <div class="mb-5">
        <div class="flex space-x-3 overflow-x-auto pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- Scrollbar disembunyikan -->
            <a href="#"
                class="px-4 py-2 rounded-full bg-green-600 text-white text-sm font-semibold whitespace-nowrap">
                Semua Produk
            </a>
            <a href="#"
                class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-semibold whitespace-nowrap hover:bg-gray-200">
                Makanan
            </a>
            <a href="#"
                class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-semibold whitespace-nowrap hover:bg-gray-200">
                Minuman
            </a>
            <a href="#"
                class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-semibold whitespace-nowrap hover:bg-gray-200">
                Snack
            </a>
            <a href="#"
                class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold whitespace-nowrap hover:bg-red-200">
                Stok Habis
            </a>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="space-y-4">

        <!-- CONTOH CARD PRODUK 1 (Available) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="flex">
                <!-- Gambar Produk -->
                <div class="w-1/3 flex-shrink-0">
                    <img src="https://placehold.co/150x150/a0eec0/333?text=Nasi+Goreng" alt="Nasi Goreng"
                        class="h-full w-full object-cover">
                </div>

                <!-- Info Produk -->
                <div class="w-2/3 p-4 relative">
                    <!-- Badge Status -->
                    <span
                        class="absolute top-4 right-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Available
                    </span>

                    <h3 class="text-lg font-bold text-gray-800 mb-1 truncate">Nasi Goreng Spesial</h3>
                    <p class="text-gray-500 text-sm mb-2">Makanan Utama</p>

                    <!-- Harga -->
                    <p class="text-xl font-extrabold text-green-700 mb-3">Rp 15.000</p>

                    <!-- Info Stok & Tombol Edit -->
                    <div class="flex justify-between items-center text-sm">
                        <p class="text-gray-600">
                            Stok: <span class="font-bold text-gray-900">50</span>
                        </p>

                        <!-- Tombol Kebab Menu (Edit/Delete) -->
                        <button class="text-gray-500 hover:text-gray-800 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTOH CARD PRODUK 2 (Stok Habis / Unavailable) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="flex">
                <!-- Gambar Produk -->
                <div class="w-1/3 flex-shrink-0">
                    <img src="https://placehold.co/150x150/c0e0ff/333?text=Es+Teh" alt="Es Teh"
                        class="h-full w-full object-cover">
                </div>

                <!-- Info Produk -->
                <div class="w-2/3 p-4 relative">
                    <!-- Badge Status -->
                    <span
                        class="absolute top-4 right-4 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Stok Habis
                    </span>

                    <h3 class="text-lg font-bold text-gray-800 mb-1 truncate">Es Teh Manis</h3>
                    <p class="text-gray-500 text-sm mb-2">Minuman</p>

                    <!-- Harga -->
                    <p class="text-xl font-extrabold text-green-700 mb-3">Rp 5.000</p>

                    <!-- Info Stok & Tombol Edit -->
                    <div class="flex justify-between items-center text-sm">
                        <p class="text-gray-600">
                            Stok: <span class="font-bold text-red-600">0</span>
                        </p>

                        <!-- Tombol Kebab Menu (Edit/Delete) -->
                        <button class="text-gray-500 hover:text-gray-800 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTOH CARD PRODUK 3 (Available) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="flex">
                <!-- Gambar Produk -->
                <div class="w-1/3 flex-shrink-0">
                    <img src="https://placehold.co/150x150/fff0b3/333?text=Keripik" alt="Keripik"
                        class="h-full w-full object-cover">
                </div>

                <!-- Info Produk -->
                <div class="w-2/3 p-4 relative">
                    <!-- Badge Status -->
                    <span
                        class="absolute top-4 right-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Available
                    </span>

                    <h3 class="text-lg font-bold text-gray-800 mb-1 truncate">Keripik Kentang Original</h3>
                    <p class="text-gray-500 text-sm mb-2">Snack</p>

                    <!-- Harga -->
                    <p class="text-xl font-extrabold text-green-700 mb-3">Rp 8.000</p>

                    <!-- Info Stok & Tombol Edit -->
                    <div class="flex justify-between items-center text-sm">
                        <p class="text-gray-600">
                            Stok: <span class="font-bold text-gray-900">120</span>
                        </p>

                        <!-- Tombol Kebab Menu (Edit/Delete) -->
                        <button class="text-gray-500 hover:text-gray-800 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

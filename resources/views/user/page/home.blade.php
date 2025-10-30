@extends('user.layouts.app')

@section('title', 'Menu Kantin App')

@section('content')
<section class="min-h-screen bg-white text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-6xl">
        
        {{-- Header User --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-green-800">
                    Halo, {{ Auth::user()->name ?? 'Pengunjung' }} 👋
                </h2>
                <p class="text-sm text-green-700">Mau makan apa hari ini?</p>
            </div>
            <img src="https://placehold.co/40x40?text=U"
                 class="w-10 h-10 rounded-full border-2 border-green-400"
                 alt="User">
        </div>

        {{-- Search Bar --}}
        <div class="relative mb-8">
            <input
                type="text"
                placeholder="Cari makanan..."
                class="w-full bg-gray-50 text-gray-700 placeholder-gray-400 rounded-full py-3 pl-5 pr-10 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:bg-white transition-all duration-300">
            <i class="fas fa-search absolute right-4 top-3.5 text-green-500"></i>
        </div>

        {{-- Category Buttons --}}
        <div class="flex gap-3 mb-10 overflow-x-auto scrollbar-hide">
            <button class="bg-green-500 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition">Makanan</button>
            <button class="bg-white text-green-600 border border-green-400 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-50 transition">Minuman</button>
            <button class="bg-white text-green-600 border border-green-400 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-50 transition">Snack</button>
            <button class="bg-white text-green-600 border border-green-400 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-50 transition">Favorit</button>
        </div>

        {{-- Produk Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 transition-all duration-500 ease-in-out">

            {{-- Produk 1 --}}
            <div class="relative bg-white rounded-2xl p-4 shadow-md hover:shadow-lg hover:scale-[1.03] transition-transform duration-300 border border-green-100">
                <img src="https://placehold.co/150x120/FACC15/333?text=Nasi+Goreng" class="w-full rounded-xl mb-3" alt="Nasi Goreng">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Nasi Goreng Spesial</h3>
                <p class="text-xs text-gray-500 mb-2">Stok: 10</p>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-bold text-green-700">Rp 25.000</p>
                    <button class="text-green-600 hover:text-green-700 transition transform hover:scale-110">
                        <i class="fas fa-plus text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Produk 2 --}}
            <div class="relative bg-white rounded-2xl p-4 shadow-md hover:shadow-lg hover:scale-[1.03] transition-transform duration-300 border border-green-100">
                <img src="https://placehold.co/150x120/FACC15/333?text=Mie+Ayam" class="w-full rounded-xl mb-3" alt="Mie Ayam">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Mie Ayam Bakso</h3>
                <p class="text-xs text-gray-500 mb-2">Stok: 8</p>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-bold text-green-700">Rp 20.000</p>
                    <button class="text-green-600 hover:text-green-700 transition transform hover:scale-110">
                        <i class="fas fa-plus text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Produk 3 --}}
            <div class="relative bg-white rounded-2xl p-4 shadow-md hover:shadow-lg hover:scale-[1.03] transition-transform duration-300 border border-green-100">
                <img src="https://placehold.co/150x120/FACC15/333?text=Ayam+Bakar" class="w-full rounded-xl mb-3" alt="Ayam Bakar">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Ayam Bakar Madu</h3>
                <p class="text-xs text-gray-500 mb-2">Stok: 6</p>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-bold text-green-700">Rp 30.000</p>
                    <button class="text-green-600 hover:text-green-700 transition transform hover:scale-110">
                        <i class="fas fa-plus text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Produk 4 --}}
            <div class="relative bg-white rounded-2xl p-4 shadow-md hover:shadow-lg hover:scale-[1.03] transition-transform duration-300 border border-green-100">
                <img src="https://placehold.co/150x120/FACC15/333?text=Es+Teh+Manis" class="w-full rounded-xl mb-3" alt="Es Teh Manis">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Es Teh Manis</h3>
                <p class="text-xs text-gray-500 mb-2">Stok: 15</p>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-bold text-green-700">Rp 5.000</p>
                    <button class="text-green-600 hover:text-green-700 transition transform hover:scale-110">
                        <i class="fas fa-plus text-lg"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

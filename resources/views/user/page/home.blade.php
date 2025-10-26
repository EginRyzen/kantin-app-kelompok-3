@extends('user.layouts.app')

@section('title', 'Selamat Datang di Kantin App')

@section('content')
    <h1 class="text-4xl font-bold text-gray-900 mb-6 text-center">
        Pesan Makanan Favoritmu
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
            <img src="https://placehold.co/600x400/FACC15/333?text=Nasi+Goreng" alt="Nasi Goreng" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-xl mb-2">Nasi Goreng Spesial</h3>
                <p class="text-gray-700 text-sm mb-4">
                    Nasi goreng spesial dengan telur, ayam, dan sayuran.
                </p>
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Pesan Sekarang
                </button>
            </div>
        </div>
    </div>
@endsection

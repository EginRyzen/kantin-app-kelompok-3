@extends('user.layouts.app')

@section('title', 'Tambah Metode Pembayaran')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6">
    <div class="container mx-auto max-w-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('kasir.payment-methods.index') }}" class="text-gray-600 hover:text-green-700 flex items-center transition-colors text-sm font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-800">Tambah Metode</h1>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form action="{{ route('kasir.payment-methods.store') }}" method="POST">
                @csrf

                {{-- Nama Metode --}}
                <div class="mb-5">
                    <label for="nama_metode" class="block mb-2 text-sm font-bold text-gray-700">Nama Metode <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_metode" name="nama_metode" value="{{ old('nama_metode') }}"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3.5 transition"
                        placeholder="Contoh: Tunai, QRIS BCA, Transfer Mandiri" required autofocus>
                    @error('nama_metode')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-6">
                    <label for="is_active" class="block mb-2 text-sm font-bold text-gray-700">Status</label>
                    <select id="is_active" name="is_active" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3.5 transition">
                        <option value="1" selected>Aktif (Tampil di Kasir)</option>
                        <option value="0">Non-Aktif (Sembunyikan)</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md shadow-green-200">
                    Simpan Metode
                </button>
            </form>
        </div>

    </div>
</section>
@endsection
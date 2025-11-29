@extends('user.layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6">
    <div class="container mx-auto max-w-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('kasir.suppliers.index') }}" class="text-gray-600 hover:text-green-700 flex items-center transition-colors text-sm font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-800">Edit Supplier</h1>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form action="{{ route('kasir.suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Supplier --}}
                <div class="mb-5">
                    <label for="nama_supplier" class="block mb-2 text-sm font-bold text-gray-700">Nama Supplier <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3.5 transition"
                        placeholder="Contoh: PT. Sembako Jaya" required>
                    @error('nama_supplier')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div class="mb-5">
                    <label for="no_telp" class="block mb-2 text-sm font-bold text-gray-700">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', $supplier->no_telp) }}"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3.5 transition"
                        placeholder="Contoh: 081234567890" required>
                    @error('no_telp')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-6">
                    <label for="alamat" class="block mb-2 text-sm font-bold text-gray-700">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block p-3.5 transition"
                        placeholder="Masukkan alamat supplier (opsional)...">{{ old('alamat', $supplier->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('kasir.suppliers.index') }}" 
                       class="w-1/2 text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-1/2 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-md shadow-green-200">
                        Update
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection
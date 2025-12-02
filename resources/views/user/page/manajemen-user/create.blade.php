@extends('user.layouts.app')

@section('title', 'Tambah User')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6">
    <div class="container mx-auto max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('kasir.users.index') }}" class="text-gray-600 hover:text-green-700 flex items-center transition-colors text-sm font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-800">Tambah User Baru</h1>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form action="{{ route('kasir.users-outlets.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required placeholder="Contoh: Kasir Pagi">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Username</label>
                        <input type="text" name="username" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required placeholder="kasirpagi">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                        <input type="email" name="email" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required placeholder="email@contoh.com">
                    </div>
                    
                    {{-- Input Role Dihilangkan (Default Kasir di Controller) --}}

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Password</label>
                            <input type="password" name="password" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="mt-6 w-full text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3.5 transition-all shadow-md shadow-green-200">
                    Simpan User
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
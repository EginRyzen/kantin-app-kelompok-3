@extends('user.layouts.app')

@section('title', 'Edit User')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6">
    <div class="container mx-auto max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('kasir.users.index') }}" class="text-gray-600 hover:text-green-700 flex items-center transition-colors text-sm font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-800">Edit User</h1>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form action="{{ route('kasir.users-outlets.update', $userToEdit->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $userToEdit->nama_lengkap) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Username</label>
                        <input type="text" name="username" value="{{ old('username', $userToEdit->username) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $userToEdit->email) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>

                    {{-- Input Role Dihilangkan --}}
                    
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-3 font-bold">Ganti Password (Opsional)</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="password" name="password" placeholder="Password Baru" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="mt-6 w-full text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3.5 transition-all shadow-md shadow-green-200">
                    Update User
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
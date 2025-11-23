@extends('admin.layouts.app')

@section('title', 'Edit Kasir')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Data Kasir</h2>
            
            <form action="{{ route('admin.cashiers.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti password.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Tugaskan di Outlet</label>
                    <select name="outlet_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2 bg-white">
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ $user->outlet_id == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->nama_outlet }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.cashiers.index') }}" class="mr-3 px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Update Kasir</button>
                </div>
            </form>
        </div>
    </div>
@endsection
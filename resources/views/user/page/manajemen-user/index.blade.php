@extends('user.layouts.app')

@section('title', 'Kelola User')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6">
    <div class="container mx-auto max-w-4xl">

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.profile.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm border border-gray-100 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Daftar User</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola akses staf untuk outlet ini.</p>
                </div>
            </div>

            <a href="{{ route('kasir.users.create') }}" class="bg-green-600 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 transition flex items-center gap-2 text-sm font-bold">
                <i class="fa-solid fa-plus"></i> <span class="hidden sm:inline">Tambah User</span>
            </a>
        </div>

        <div class="grid gap-4">
            @foreach($users as $u)
                @php
                    $isMaster = ($u->id === $masterUser->id);
                    $isMe = (Auth::id() === $u->id);
                @endphp
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 {{ $isMaster ? 'ring-2 ring-yellow-100 bg-yellow-50/30' : '' }}">
                    
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ $u->nama_lengkap }}&background=random" class="w-12 h-12 rounded-full">
                            @if($isMaster)
                                <span class="absolute -top-1 -right-1 bg-yellow-400 text-white text-[10px] p-1 rounded-full shadow-sm" title="Master User">
                                    <i class="fa-solid fa-crown"></i>
                                </span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                {{ $u->nama_lengkap }}
                                @if($isMe) <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Anda</span> @endif
                            </h3>
                            <p class="text-xs text-gray-500">{{ '@'.$u->username }} • {{ ucfirst($u->role) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        {{-- Tombol Edit --}}
                        {{-- Logic: Master hanya bisa diedit oleh Master sendiri --}}
                        @if(!$isMaster || ($isMaster && $isMe))
                            <a href="{{ route('kasir.users-outlets.edit', $u->id) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-yellow-50 hover:text-yellow-600 transition">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                        @endif

                        {{-- Tombol Hapus --}}
                        {{-- Logic: Master tidak bisa dihapus, Diri sendiri tidak bisa dihapus --}}
                        @if(!$isMaster && !$isMe)
                            <form action="{{ route('kasir.users-outlets.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user {{ $u->username }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-600 transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
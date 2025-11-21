@extends('user.layouts.app')

@section('title', 'Edit Profil')

@section('content')

{{-- Form Wrapper --}}
<div class="min-h-screen bg-gray-50 pb-32 -mx-4 -mt-6"> 
    
    {{-- HEADER KHUSUS HALAMAN INI --}}
    {{-- Sticky top agar header tetap terlihat saat scroll --}}
    <div class="bg-white px-5 py-4 sticky top-0 z-30 flex items-center gap-3 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.1)]">
        {{-- TOMBOL BACK --}}
        <a href="{{ route('kasir.profile.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        
        <div>
            <h1 class="text-lg font-bold text-gray-800 leading-tight">Edit Profil</h1>
            <p class="text-xs text-gray-500">Perbarui informasi akun Anda</p>
        </div>
    </div>

    {{-- KONTEN FORM --}}
    <div class="max-w-2xl mx-auto px-5 py-6 space-y-6">
        
        <form action="{{ route('kasir.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
            @csrf
            @method('PUT')

            {{-- KARTU 1: FOTO & BIODATA --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Informasi Dasar</h3>

                {{-- Upload Foto --}}
                <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        {{-- Preview Gambar --}}
                        @if(Auth::user()->foto)
                            <img id="avatar-preview" src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg group-hover:brightness-90 transition">
                        @else
                            <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_lengkap }}&background=0F172A&color=fff&size=128" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg group-hover:brightness-90 transition">
                        @endif
                        
                        {{-- Tombol Kamera (Overlay) --}}
                        <label for="foto-input" class="absolute bottom-1 right-1 bg-green-600 text-white w-9 h-9 rounded-full flex items-center justify-center cursor-pointer hover:bg-green-700 border-4 border-white shadow-sm transition transform active:scale-90">
                            <i class="fa-solid fa-camera text-sm"></i>
                        </label>
                        <input type="file" name="foto" id="foto-input" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <p class="text-xs text-gray-400 mt-3">Ketuk ikon kamera untuk ubah foto</p>
                </div>

                {{-- Input Fields --}}
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm font-medium transition bg-gray-50 focus:bg-white placeholder-gray-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm font-medium transition bg-gray-50 focus:bg-white placeholder-gray-300">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor HP / WhatsApp</label>
                        <div class="relative">
                            <i class="fa-brands fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp ?? '') }}" placeholder="0812xxxx" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm font-medium transition bg-gray-50 focus:bg-white placeholder-gray-300">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 2: KEAMANAN --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ganti Password</h3>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="password" placeholder="Min. 8 karakter" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm transition bg-gray-50 focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ulangi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 text-sm transition bg-gray-50 focus:bg-white">
                        <p class="text-[10px] text-gray-400 mt-2">*Kosongkan jika tidak ingin mengganti password</p>
                    </div>
                </div>
            </div>

        </form>
    </div>

    {{-- FOOTER KHUSUS TOMBOL SIMPAN --}}
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-4 z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
        <div class="max-w-2xl mx-auto">
            <button type="submit" form="profile-form" class="w-full bg-green-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-200 hover:bg-green-700 transition active:scale-[0.98] flex items-center justify-center gap-2">
                <i class="fa-regular fa-floppy-disk"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush

@endsection
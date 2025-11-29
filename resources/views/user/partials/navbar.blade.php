<nav class="bg-white shadow-sm fixed top-0 left-0 w-full z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            {{-- Logo Kiri --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('kasir.home') }}" class="text-2xl font-extrabold text-green-700 tracking-tight">
                    Kantin<span class="text-green-500">App</span>
                </a>
            </div>

            {{-- Menu Kanan (Keranjang & Profil Kecil) --}}
            <div class="flex items-center space-x-4">
                
                {{-- Tombol Keranjang --}}
                {{-- PERBAIKAN DISINI: Gunakan 'kasir.cart.index' --}}
                <a href="{{ route('kasir.cart.index') }}" class="relative p-2 text-gray-600 hover:text-green-600 transition group">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        
                        {{-- Badge Merah (Angka) --}}
                        <span id="cart-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center hidden border-2 border-white shadow-sm">
                            0
                        </span>
                    </div>
                </a>

                {{-- Avatar User (Opsional) --}}
                <a href="{{ route('kasir.profile.index') }}" class="hidden md:block">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_lengkap }}&background=random" 
                         alt="User" class="w-9 h-9 rounded-full border border-gray-200 shadow-sm">
                </a>

            </div>
        </div>
    </div>
</nav>
{{-- Spacer agar konten tidak ketutupan navbar --}}
<div class="h-16"></div>
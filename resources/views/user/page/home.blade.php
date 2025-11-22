@extends('user.layouts.app')

@section('title', 'Menu Kantin App')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-6xl">
        
        {{-- Header User (Tanpa Keranjang lagi) --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Halo, <span class="text-green-600">{{ Auth::user()->nama_lengkap ?? 'Pengunjung' }}</span> 👋
            </h2>
            <p class="text-sm text-gray-500 mt-1">Mau makan enak apa hari ini?</p>
        </div>

        {{-- Search Bar --}}
        <div class="relative mb-8">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="search-input" placeholder="Cari makanan favoritmu..." class="w-full bg-white text-gray-700 placeholder-gray-400 rounded-2xl py-3.5 pl-12 pr-4 shadow-sm border border-gray-100 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300">
        </div>

        {{-- Kategori --}}
        <div class="flex gap-3 mb-8 overflow-x-auto scrollbar-hide pb-2">
            <button class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-medium shadow-md shadow-green-200 hover:bg-green-700 transition whitespace-nowrap">Semua</button>
            <button class="bg-white text-gray-600 border border-gray-200 px-5 py-2 rounded-full text-sm font-medium hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition whitespace-nowrap">Makanan Berat</button>
            <button class="bg-white text-gray-600 border border-gray-200 px-5 py-2 rounded-full text-sm font-medium hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition whitespace-nowrap">Minuman</button>
            <button class="bg-white text-gray-600 border border-gray-200 px-5 py-2 rounded-full text-sm font-medium hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition whitespace-nowrap">Snack</button>
        </div>

        {{-- Produk Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 pb-24">
            @foreach ($products as $product)
            <div class="group relative bg-white rounded-2xl p-3 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex flex-col h-full">
                
                {{-- Gambar Produk --}}
                <div class="relative overflow-hidden rounded-xl bg-gray-100 aspect-[4/3] mb-3">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Menu' }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         alt="{{ $product->nama_produk }}">
                    
                    {{-- Stok Badge --}}
                    @if($product->stok <= 0)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Habis</span>
                        </div>
                    @elseif($product->stok < 5)
                        <span class="absolute top-2 left-2 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">
                            Sisa {{ $product->stok }}
                        </span>
                    @endif
                </div>

                {{-- Info Produk --}}
                <div class="flex flex-col flex-grow">
                    <h3 class="text-sm font-bold text-gray-800 mb-1 leading-snug line-clamp-2">{{ $product->nama_produk }}</h3>
                    <p class="text-[10px] text-gray-400 mb-3 line-clamp-1">{{ $product->category->nama_kategori ?? 'Umum' }}</p>
                    
                    <div class="mt-auto flex items-end justify-between">
                        <div class="flex flex-col">
                            @if($product->diskon_nilai > 0)
                                <span class="text-[10px] text-gray-400 line-through">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                <span class="text-sm font-extrabold text-green-700">Rp {{ number_format($product->harga_akhir, 0, ',', '.') }}</span>
                            @else
                                <span class="text-sm font-extrabold text-green-700">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        {{-- Tombol Tambah ke Keranjang (+) --}}
                        @if($product->stok > 0 && $product->status == 'available')
                            <button onclick="addToCart({{ $product->id }}, '{{ $product->nama_produk }}', {{ $product->harga_akhir }}, '{{ $product->image }}')" 
                                    class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-600 hover:text-white transition-all active:scale-90 shadow-sm"
                                    title="Tambah ke Keranjang">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        @else
                            <button disabled class="bg-gray-100 text-gray-300 w-8 h-8 rounded-full flex items-center justify-center cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
    // 1. Inisialisasi Badge Keranjang
    document.addEventListener('DOMContentLoaded', function() {
        updateCartBadge();
    });

    // 2. Fungsi Tambah ke Keranjang
    function addToCart(id, name, price, image) {
        // Ambil data keranjang dari LocalStorage
        let cart = JSON.parse(localStorage.getItem('kantin_cart')) || [];
        
        // Cek produk duplikat
        let existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.qty += 1;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                image: image,
                qty: 1
            });
        }

        // Simpan kembali ke LocalStorage
        localStorage.setItem('kantin_cart', JSON.stringify(cart));
        
        // Update Tampilan Badge
        updateCartBadge();

        // Efek visual sederhana (bisa diganti Toast)
        // alert('Berhasil menambahkan ' + name);
        
        // Animasi kecil pada badge (opsional)
        const badge = document.getElementById('cart-badge');
        badge.classList.add('scale-125');
        setTimeout(() => badge.classList.remove('scale-125'), 200);
    }

    // 3. Update Angka di Navbar
    function updateCartBadge() {
        let cart = JSON.parse(localStorage.getItem('kantin_cart')) || [];
        let totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
        let badge = document.getElementById('cart-badge');

        if (badge) {
            if (totalQty > 0) {
                badge.innerText = totalQty;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }
</script>
@endpush
@endsection
@extends('user.layouts.app')

@section('title', 'Menu Kantin App')

@section('content')
<section class="min-h-screen bg-gray-50 text-gray-900 py-8 px-4 sm:px-6 transition-all duration-500 ease-in-out">
    <div class="container mx-auto max-w-6xl">
        
        {{-- Header User --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Halo, <span class="text-green-600">{{ Auth::user()->nama_lengkap ?? 'Pengunjung' }}</span> 👋
            </h2>
            <p class="text-sm text-gray-500 mt-1">Mau makan enak apa hari ini?</p>
        </div>

        {{-- FORM UTAMA (Search & Filter) --}}
        {{-- Kita gunakan ID agar mudah dikontrol via JS --}}
        <form id="filter-form" action="{{ route('kasir.home') }}" method="GET" class="w-full">
            
            {{-- Input Hidden untuk Kategori --}}
            <input type="hidden" id="category-id-input" name="category_id" value="{{ $selectedCategoryId ?? '' }}">

            {{-- Search Bar --}}
            <div class="relative mb-8">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" 
                       id="search-input"
                       name="search" 
                       value="{{ $searchQuery }}" 
                       placeholder="Cari makanan favoritmu..." 
                       class="w-full bg-white text-gray-700 placeholder-gray-400 rounded-2xl py-3.5 pl-12 pr-4 shadow-sm border border-gray-100 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300"
                       autocomplete="off">
            </div>
        </form>

        {{-- Kategori (Menggunakan OnClick JS) --}}
        <div class="flex gap-3 mb-8 overflow-x-auto scrollbar-hide pb-2">
            {{-- Tombol SEMUA --}}
            <a href="#" onclick="event.preventDefault(); filterCategory('');" 
               class="{{ !$selectedCategoryId ? 'bg-green-600 text-white shadow-md shadow-green-200' : 'bg-white text-gray-600 border border-gray-200 hover:bg-green-50 hover:text-green-600 hover:border-green-200' }} px-5 py-2 rounded-full text-sm font-medium transition whitespace-nowrap">
                Semua
            </a>

            {{-- Looping Kategori --}}
            @foreach($categories as $category)
                <a href="#" onclick="event.preventDefault(); filterCategory('{{ $category->id }}');" 
                   class="{{ $selectedCategoryId == $category->id ? 'bg-green-600 text-white shadow-md shadow-green-200' : 'bg-white text-gray-600 border border-gray-200 hover:bg-green-50 hover:text-green-600 hover:border-green-200' }} px-5 py-2 rounded-full text-sm font-medium transition whitespace-nowrap">
                    {{ $category->nama_kategori }}
                </a>
            @endforeach
        </div>

        {{-- Produk Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 pb-24">
            @forelse ($products as $product)
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
                    @elseif($product->stok <= 10)
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
            @empty
                {{-- State Kosong --}}
                <div class="col-span-full flex flex-col items-center justify-center py-12 text-center bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Produk tidak ditemukan</h3>
                    <p class="text-gray-500 text-sm mt-1">Coba cari dengan kata kunci lain atau pilih kategori 'Semua'.</p>
                    @if($searchQuery || $selectedCategoryId)
                        <a href="{{ route('kasir.home') }}" class="mt-4 text-green-600 font-medium hover:underline">Reset Pencarian</a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    {{-- MODAL ALERT STOK (Sama seperti sebelumnya) --}}
    <div id="stock-alert-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeStockModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-sm transform rounded-2xl bg-white p-6 text-center shadow-xl transition-all">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold leading-6 text-gray-900" id="stock-alert-title">Stok Tidak Cukup</h3>
                <p class="mt-2 text-sm text-gray-500" id="stock-alert-message">Mohon maaf, stok produk ini sudah habis.</p>
                <div class="mt-6">
                    <button type="button" onclick="closeStockModal()" class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // --- LOGIC 1: SEARCH & FILTER (Seperti Manajemen Produk) ---
    const filterForm = document.getElementById('filter-form');
    const searchInput = document.getElementById('search-input');
    const categoryInput = document.getElementById('category-id-input');
    let debounceTimer;

    // Fungsi Submit Form
    function submitFilterForm() {
        filterForm.submit();
    }

    // Fungsi Filter Kategori
    function filterCategory(categoryId) {
        categoryInput.value = categoryId;
        submitFilterForm();
    }

    // Event Listener Search dengan Debounce (Jeda waktu)
    searchInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            submitFilterForm();
        }, 500); // Tunggu 500ms setelah selesai mengetik baru submit
    });


    // --- LOGIC 2: CART & BADGE ---
    document.addEventListener('DOMContentLoaded', function() {
        let totalQty = {{ array_sum(array_column(session('cart', []), 'qty')) }};
        updateBadgeUI(totalQty);
    });

    // Modal Logic
    function showStockModal(message) {
        document.getElementById('stock-alert-message').innerText = message;
        document.getElementById('stock-alert-modal').classList.remove('hidden');
    }

    function closeStockModal() {
        document.getElementById('stock-alert-modal').classList.add('hidden');
    }

    // Add to Cart Logic
    function addToCart(id, name, price, image) {
        fetch('{{ route("kasir.cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id,
                name: name,
                price: price,
                image: image
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                updateBadgeUI(data.total_qty);
                const badge = document.getElementById('cart-badge');
                if(badge) {
                    badge.classList.add('scale-125');
                    setTimeout(() => badge.classList.remove('scale-125'), 200);
                }
            } else if (data.status === 'error_stock') {
                showStockModal(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function updateBadgeUI(totalQty) {
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
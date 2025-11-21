@extends('user.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
{{-- Padding bottom (pb-32) disiapkan agar konten terakhir tidak tertutup footer checkout --}}
<div class="min-h-screen bg-gray-50 pt-4 pb-32">
    <div class="container mx-auto px-4 max-w-3xl">
        
        {{-- Header Halaman --}}
        <div class="flex items-center mb-6">
            <a href="{{ route('kasir.home') }}" class="mr-4 bg-white p-2.5 rounded-full shadow-sm border border-gray-100 text-gray-600 hover:text-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Keranjang Saya</h1>
            
            {{-- Tombol Hapus Semua --}}
            <button onclick="clearCart()" class="ml-auto text-xs text-red-500 hover:text-red-700 font-medium">
                Hapus Semua
            </button>
        </div>

        {{-- Kontainer Item Keranjang --}}
        <div id="cart-list" class="space-y-4">
            {{-- Item akan dirender di sini via JS --}}
        </div>

        {{-- State Kosong --}}
        <div id="empty-state" class="hidden flex-col items-center justify-center py-16 text-center">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-4 text-green-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Keranjang Kosong</h3>
            <p class="text-gray-500 text-sm mb-6">Belum ada menu yang dipilih nih.</p>
            <a href="{{ route('kasir.home') }}" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-green-700 transition">
                Pesan Sekarang
            </a>
        </div>

    </div>

    {{-- Footer Fixed Checkout (Desktop) --}}
    <div id="checkout-footer" class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] p-4 z-40 hidden md:block">
        <div class="max-w-3xl mx-auto md:mb-4 md:rounded-2xl md:border md:border-gray-100 md:bg-white md:p-2 md:shadow-xl">
            <div class="flex items-center justify-between p-2">
                <div class="pl-2">
                    <p class="text-xs text-gray-500 font-medium">Total Pembayaran</p>
                    <p id="total-price" class="text-xl font-extrabold text-green-700">Rp 0</p>
                </div>
                <button onclick="checkout()" class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-200 flex items-center gap-2">
                    Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Footer Mobile (Full width) --}}
    {{-- PERUBAHAN: bottom-0 agar nempel paling bawah --}}
    <div id="checkout-footer-mobile" class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] p-4 z-40 block md:hidden">
         <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium">Total</p>
                <p id="total-price-mobile" class="text-lg font-extrabold text-green-700">Rp 0</p>
            </div>
            <button onclick="checkout()" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-md flex items-center gap-2">
                Checkout
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Saat halaman load
    document.addEventListener('DOMContentLoaded', renderCart);

    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('kantin_cart')) || [];
        const container = document.getElementById('cart-list');
        const emptyState = document.getElementById('empty-state');
        const footer = document.getElementById('checkout-footer');
        const footerMobile = document.getElementById('checkout-footer-mobile');
        
        // Reset HTML
        container.innerHTML = '';
        let grandTotal = 0;

        if (cart.length === 0) {
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            footer.classList.add('hidden');
            footerMobile.classList.add('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        footer.classList.remove('hidden');
        footerMobile.classList.remove('hidden');

        cart.forEach((item, index) => {
            let subtotal = item.price * item.qty;
            grandTotal += subtotal;

            // HTML untuk setiap item
            let html = `
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-center transition hover:shadow-md">
                    <div class="w-20 h-20 shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                        <img src="${item.image ? '/storage/' + item.image : 'https://placehold.co/150'}" 
                             class="w-full h-full object-cover" 
                             alt="${item.name}">
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 truncate pr-2">${item.name}</h3>
                        <p class="text-green-600 font-bold text-sm mt-0.5">Rp ${item.price.toLocaleString('id-ID')}</p>
                        
                        <div class="flex items-center justify-between mt-3">
                            <button onclick="removeItem(${index})" class="text-gray-400 hover:text-red-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>

                            <div class="flex items-center bg-gray-50 rounded-lg border border-gray-200 h-8">
                                <button onclick="updateQty(${index}, -1)" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-red-500 rounded-l-lg transition font-bold text-sm">-</button>
                                <input type="text" readonly value="${item.qty}" class="w-10 h-full text-center bg-transparent text-sm font-bold text-gray-800 border-none p-0 focus:ring-0">
                                <button onclick="updateQty(${index}, 1)" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-green-600 rounded-r-lg transition font-bold text-sm">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        // Update Total Harga di Footer
        const formattedTotal = 'Rp ' + grandTotal.toLocaleString('id-ID');
        document.getElementById('total-price').innerText = formattedTotal;
        document.getElementById('total-price-mobile').innerText = formattedTotal;
    }

    function updateQty(index, change) {
        let cart = JSON.parse(localStorage.getItem('kantin_cart')) || [];
        
        if (cart[index]) {
            cart[index].qty += change;
            
            // Jika qty 0, hapus
            if (cart[index].qty <= 0) {
                if(confirm("Hapus produk ini?")) {
                    cart.splice(index, 1);
                } else {
                    cart[index].qty = 1; 
                }
            }
        }
        
        localStorage.setItem('kantin_cart', JSON.stringify(cart));
        renderCart();
    }

    function removeItem(index) {
        let cart = JSON.parse(localStorage.getItem('kantin_cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('kantin_cart', JSON.stringify(cart));
        renderCart();
    }

    function clearCart() {
        if(confirm("Kosongkan semua keranjang?")) {
            localStorage.removeItem('kantin_cart');
            renderCart();
        }
    }

    function checkout() {
        alert("Fitur Checkout (Simpan Transaksi) akan dikerjakan selanjutnya!");
    }
</script>
@endpush
@endsection
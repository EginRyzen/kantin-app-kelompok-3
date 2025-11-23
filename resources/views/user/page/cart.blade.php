@extends('user.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="min-h-screen bg-gray-50 pt-4 pb-32">
        <div class="container mx-auto px-4 max-w-3xl">

            {{-- Header --}}
            <div class="flex items-center mb-6">
                <a href="{{ route('kasir.home') }}"
                    class="mr-4 bg-white p-2.5 rounded-full shadow-sm border border-gray-100 text-gray-600 hover:text-green-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-800">Keranjang Saya</h1>

                @if (session('cart') && count(session('cart')) > 0)
                    <form action="{{ route('kasir.cart.clear') }}" method="POST" class="ml-auto">
                        @csrf
                        <button type="submit" onclick="return confirm('Hapus semua?')"
                            class="text-xs text-red-500 hover:text-red-700 font-medium">
                            Hapus Semua
                        </button>
                    </form>
                @endif
            </div>

            {{-- Cek jika Cart Kosong --}}
            @if (session('cart') && count(session('cart')) > 0)
                {{-- List Item --}}
                <div id="cart-list" class="space-y-4">
                    @php $grandTotal = 0; @endphp
                    @foreach (session('cart') as $id => $details)
                        @php
                            $subtotal = $details['price'] * $details['qty'];
                            $grandTotal += $subtotal;
                        @endphp

                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-center transition hover:shadow-md item-row"
                            id="row-{{ $id }}">
                            {{-- Gambar --}}
                            <div class="w-20 h-20 shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                <img src="{{ $details['image'] ? asset('storage/' . $details['image']) : 'https://placehold.co/150' }}"
                                    class="w-full h-full object-cover" alt="{{ $details['name'] }}">
                            </div>

                            {{-- Detail --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-800 truncate pr-2">{{ $details['name'] }}</h3>
                                <p class="text-green-600 font-bold text-sm mt-0.5">Rp
                                    {{ number_format($details['price'], 0, ',', '.') }}</p>

                                <div class="flex items-center justify-between mt-3">
                                    {{-- Hapus --}}
                                    <button onclick="removeItem({{ $id }})"
                                        class="text-red-400 hover:text-red-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>

                                    {{-- Counter QTY --}}
                                    <div class="flex items-center bg-gray-50 rounded-lg border border-gray-200 h-8">
                                        <button onclick="updateQty({{ $id }}, -1)"
                                            class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-red-500 rounded-l-lg transition font-bold text-sm">-</button>

                                        <input type="text" id="qty-{{ $id }}" readonly
                                            value="{{ $details['qty'] }}"
                                            class="w-10 h-full text-center bg-transparent text-sm font-bold text-gray-800 border-none p-0 focus:ring-0">

                                        <button onclick="updateQty({{ $id }}, 1)"
                                            class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-green-600 rounded-r-lg transition font-bold text-sm">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Footer Fixed --}}
                <div id="checkout-footer"
                    class="fixed bottom-16 left-0 w-full md:w-full md:left-1/2 md:-translate-x-1/2 md:max-w-3xl z-40 p-4">
                    <div
                        class="bg-white w-full border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] rounded-2xl p-4 flex items-center justify-between">
                        <div class="pl-2">
                            <p class="text-xs text-gray-500 font-medium">Total Pembayaran</p>
                            <p id="total-price" class="text-xl font-extrabold text-green-700">Rp
                                {{ number_format($grandTotal, 0, ',', '.') }}</p>
                        </div>
                        <button onclick="checkout()"
                            class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-200 flex items-center gap-2">
                            Checkout
                        </button>
                    </div>
                </div>
            @else
                {{-- State Kosong --}}
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-4 text-green-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Keranjang Kosong</h3>
                    <p class="text-gray-500 text-sm mb-6">Belum ada menu yang dipilih nih.</p>
                    <a href="{{ route('kasir.home') }}"
                        class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-green-700 transition">Pesan
                        Sekarang</a>
                </div>
            @endif

            {{-- MODAL ALERT STOK (BARU) --}}
            <div id="stock-alert-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeStockModal()"></div>
                <div class="flex min-h-full items-center justify-center p-4">
                    <div
                        class="relative w-full max-w-sm transform rounded-2xl bg-white p-6 text-center shadow-xl transition-all">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="stock-alert-title">Stok Terbatas</h3>
                        <p class="mt-2 text-sm text-gray-500" id="stock-alert-message">Stok produk tidak mencukupi
                            permintaan.</p>
                        <div class="mt-6">
                            <button type="button" onclick="closeStockModal()"
                                class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL CHECKOUT --}}
            <div id="checkout-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeModal()"></div>

                {{-- Modal Content --}}
                <div class="flex min-h-full items-center justify-center p-4">
                    <div
                        class="relative w-full max-w-md transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all">

                        <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4">Konfirmasi Pembayaran</h3>

                        <form id="checkout-form">
                            {{-- Input Nama Pelanggan --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                                <input type="text" id="customer_name" required
                                    class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Masukkan nama pelanggan...">
                            </div>

                            {{-- Select Metode Pembayaran --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach ($paymentMethods as $pm)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="payment_method" value="{{ $pm->id }}"
                                                class="peer sr-only" required>
                                            <div
                                                class="rounded-lg border border-gray-200 p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50 transition">
                                                <span
                                                    class="text-sm font-medium text-gray-700">{{ $pm->nama_metode }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Kalkulator Pembayaran --}}
                            <div class="bg-gray-50 p-4 rounded-xl mb-6 border border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600 text-sm">Total Tagihan</span>
                                    <span id="modal-total-display" class="font-bold text-gray-800">Rp 0</span>
                                    <input type="hidden" id="raw-total-price">
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Uang Diterima
                                        (Bayar)</label>
                                    <div class="relative mb-2">
                                        <span class="absolute left-3 top-2 text-gray-500 font-bold">Rp</span>
                                        <input type="number" id="nominal-bayar" required min="0"
                                            class="w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 font-bold text-gray-800"
                                            placeholder="0">
                                    </div>

                                    {{-- BUTTON PILIHAN UANG (BARU) --}}
                                    <div class="grid grid-cols-3 gap-2">
                                        <button type="button" onclick="setUangPas()"
                                            class="bg-white border border-green-200 text-green-700 hover:bg-green-600 hover:text-white py-1.5 rounded-lg text-xs font-bold transition shadow-sm">
                                            Uang Pas
                                        </button>
                                        <button type="button" onclick="setNominal(5000)"
                                            class="bg-white border border-gray-200 text-gray-600 hover:bg-green-50 hover:border-green-200 hover:text-green-700 py-1.5 rounded-lg text-xs font-bold transition">
                                            5.000
                                        </button>
                                        <button type="button" onclick="setNominal(10000)"
                                            class="bg-white border border-gray-200 text-gray-600 hover:bg-green-50 hover:border-green-200 hover:text-green-700 py-1.5 rounded-lg text-xs font-bold transition">
                                            10.000
                                        </button>
                                        <button type="button" onclick="setNominal(20000)"
                                            class="bg-white border border-gray-200 text-gray-600 hover:bg-green-50 hover:border-green-200 hover:text-green-700 py-1.5 rounded-lg text-xs font-bold transition">
                                            20.000
                                        </button>
                                        <button type="button" onclick="setNominal(50000)"
                                            class="bg-white border border-gray-200 text-gray-600 hover:bg-green-50 hover:border-green-200 hover:text-green-700 py-1.5 rounded-lg text-xs font-bold transition">
                                            50.000
                                        </button>
                                        <button type="button" onclick="setNominal(100000)"
                                            class="bg-white border border-gray-200 text-gray-600 hover:bg-green-50 hover:border-green-200 hover:text-green-700 py-1.5 rounded-lg text-xs font-bold transition">
                                            100.000
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center border-t border-gray-200 pt-2 mt-2">
                                    <span class="text-gray-600 font-medium">Kembalian</span>
                                    <span id="info-kembalian" class="text-xl font-extrabold text-green-700">Rp 0</span>
                                </div>
                            </div>

                            {{-- Tombol Action --}}
                            <div class="flex gap-3">
                                <button type="button" onclick="closeModal()"
                                    class="w-1/2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50">
                                    Batal
                                </button>
                                <button type="submit" id="btn-pay" disabled
                                    class="w-1/2 rounded-xl bg-gray-400 cursor-not-allowed px-4 py-2.5 text-sm font-bold text-white shadow-lg transition-all">
                                    Bayar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
            const idrFormatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            // LOGIC BARU: MODAL ALERT
            function showStockModal(message) {
                document.getElementById('stock-alert-message').innerText = message;
                document.getElementById('stock-alert-modal').classList.remove('hidden');
            }

            function closeStockModal() {
                document.getElementById('stock-alert-modal').classList.add('hidden');
            }

            function updateQty(id, change) {
                let input = document.getElementById('qty-' + id);
                let currentQty = parseInt(input.value);
                let newQty = currentQty + change;

                if (newQty < 1) {
                    if (confirm('Hapus item ini?')) {
                        removeItem(id);
                    }
                    return;
                }

                // AJAX Request
                fetch('{{ route('kasir.cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id,
                            qty: newQty
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // HANYA UPDATE ANGKA JIKA SUKSES
                            input.value = newQty;
                            document.getElementById('total-price').innerText = formatter.format(data.grand_total);
                        } else if (data.status === 'error_stock') {
                            // MUNCULKAN MODAL JIKA STOK ERROR
                            showStockModal(data.message);
                            // JANGAN update input.value, biarkan di angka lama
                        }
                    });
            }

            function removeItem(id) {
                if (!confirm("Yakin hapus produk ini?")) return;
                fetch('{{ route('kasir.cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            document.getElementById('row-' + id).remove();
                            document.getElementById('total-price').innerText = formatter.format(data.grand_total);
                            if (data.grand_total === 0) location.reload();
                        }
                    });
            }

            // --- MODAL & CHECKOUT LOGIC (Sama seperti sebelumnya) ---
            function checkout() {
                let totalText = document.getElementById('total-price').innerText;
                let totalNumeric = parseInt(totalText.replace(/[^0-9]/g, ''));
                document.getElementById('modal-total-display').innerText = totalText;
                document.getElementById('raw-total-price').value = totalNumeric;
                document.getElementById('nominal-bayar').value = '';
                document.getElementById('info-kembalian').innerText = 'Rp 0';
                togglePayButton(false);
                document.getElementById('checkout-modal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('checkout-modal').classList.add('hidden');
            }

            function setNominal(amount) {
                let input = document.getElementById('nominal-bayar');
                input.value = amount;
                input.dispatchEvent(new Event('input'));
            }

            function setUangPas() {
                let total = document.getElementById('raw-total-price').value;
                setNominal(total);
            }

            document.getElementById('nominal-bayar').addEventListener('input', function() {
                let bayar = parseInt(this.value) || 0;
                let total = parseInt(document.getElementById('raw-total-price').value) || 0;
                let kembalian = bayar - total;
                if (kembalian >= 0) {
                    document.getElementById('info-kembalian').innerText = idrFormatter.format(kembalian);
                    document.getElementById('info-kembalian').classList.remove('text-red-600');
                    document.getElementById('info-kembalian').classList.add('text-green-700');
                    togglePayButton(true);
                } else {
                    document.getElementById('info-kembalian').innerText = "Kurang " + idrFormatter.format(Math.abs(
                        kembalian));
                    document.getElementById('info-kembalian').classList.add('text-red-600');
                    document.getElementById('info-kembalian').classList.remove('text-green-700');
                    togglePayButton(false);
                }
            });

            function togglePayButton(enable) {
                let btn = document.getElementById('btn-pay');
                if (enable) {
                    btn.disabled = false;
                    btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    btn.classList.add('bg-green-600', 'hover:bg-green-700');
                } else {
                    btn.disabled = true;
                    btn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                }
            }

            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                e.preventDefault();
                let customerName = document.getElementById('customer_name').value;
                let nominalBayar = document.getElementById('nominal-bayar').value;
                let paymentMethodElement = document.querySelector('input[name="payment_method"]:checked');
                if (!paymentMethodElement) {
                    alert("Pilih metode pembayaran!");
                    return;
                }
                let btnPay = document.getElementById('btn-pay');
                btnPay.innerText = "Memproses...";
                btnPay.disabled = true;

                fetch('{{ route('kasir.transaction.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nama_pelanggan: customerName,
                            payment_method_id: paymentMethodElement.value,
                            total_bayar: nominalBayar
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let printUrl = "{{ route('kasir.transaction.print', ':invoice') }}";
                            printUrl = printUrl.replace(':invoice', data.invoice);
                            window.open(printUrl, '_blank');
                            window.location.href = "{{ route('kasir.home') }}";
                        } else {
                            alert("Gagal: " + data.message);
                            btnPay.innerText = "Bayar";
                            btnPay.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan sistem");
                        btnPay.innerText = "Bayar";
                        btnPay.disabled = false;
                    });
            });
        </script>
    @endpush
@endsection

@extends('user.layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('kasir.products.index') }}"
            class="text-gray-600 hover:text-green-700 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Kembali
        </a>
        <h1 class="text-xl font-bold text-gray-800 text-right">Edit Produk</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Terjadi Kesalahan Validasi!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kasir.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-5 pb-4">
        @csrf
        @method('PUT')

        <input type="hidden" name="outlet_id" value="{{ auth()->user()->outlet_id }}">

        <input type="hidden" id="old_stock" value="{{ $product->stok ?? 0 }}">

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Foto Produk (Opsional: Ganti)</label>
            <div class="flex items-center justify-center w-full">
                <label for="image"
                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                    <div id="image-placeholder"
                        class="flex flex-col items-center justify-center pt-5 pb-6 {{ $product->image ? 'hidden' : '' }}">
                        <svg class="w-10 h-10 mb-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk ganti gambar</span></p>
                        <p class="text-xs text-gray-500">PNG, JPG, atau WEBP (MAX. 2MB)</p>
                    </div>
                    <img id="image-preview" src="{{ $product->image ? asset('storage/' . $product->image) : '#' }}"
                        alt="Preview Produk"
                        class="h-full w-full object-cover rounded-lg {{ $product->image ? '' : 'hidden' }}" />
                    <input id="image" name="image" type="file" class="hidden"
                        accept="image/png, image/jpeg, image/webp" />
                </label>
            </div>
        </div>

        <div>
            <label for="nama_produk" class="block mb-2 text-sm font-medium text-gray-700">Nama Produk <span
                    class="text-red-500">*</span></label>
            <input type="text" id="nama_produk" name="nama_produk"
                value="{{ old('nama_produk', $product->nama_produk) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                placeholder="Contoh: Nasi Goreng Spesial" required>
        </div>

        <div>
            <label for="kode_produk" class="block mb-2 text-sm font-medium text-gray-700">Kode Produk (SKU)</label>
            <input type="text" id="kode_produk" name="kode_produk"
                value="{{ old('kode_produk', $product->kode_produk) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                placeholder="Contoh: MKN-001 (Opsional)">
        </div>

        <div>
            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Singkat</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                placeholder="Deskripsi singkat produk...">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-700">Kategori <span
                        class="text-red-500">*</span></label>
                <select id="category_id" name="category_id" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3">
                    <option value="" disabled>Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-700">Supplier</label>
                <select id="supplier_id" name="supplier_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3">
                    <option value="">Pilih supplier (Opsional)</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            {{ (string) old('supplier_id', $product->supplier_id) === (string) $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- FIELD Catatan Stok --}}
        <div id="catatan-field" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all duration-300">
            <label for="catatan_stok" class="block mb-2 text-sm font-bold text-blue-700">Catatan Stok / No. Nota
                Supplier</label>
            <input type="text" id="catatan_stok" name="catatan_stok" value="{{ old('catatan_stok') }}"
                class="bg-white border border-blue-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                placeholder="Contoh: Restock Faktur #INV-001">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label for="harga_jual" class="block mb-2 text-sm font-medium text-gray-700">Harga Jual <span
                        class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm">Rp</span>
                    <input type="number" id="harga_jual" name="harga_jual"
                        value="{{ old('harga_jual', $product->harga_jual) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3 pl-9"
                        placeholder="15000" required>
                </div>
            </div>

            <div id="restock-container" class="hidden">
                <label for="restock_qty" class="block mb-2 text-sm font-medium text-blue-700">
                    Jumlah Restock (+)
                </label>
                <input type="number" id="restock_qty" name="restock_qty" value=""
                    class="bg-blue-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                    placeholder="0">
                <p class="text-xs text-gray-500 mt-1">Masukkan jumlah barang masuk.</p>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="stok" class="block text-sm font-medium text-gray-700">
                        Stok Total <span id="stok-asterisk" class="text-red-500">*</span>
                    </label>

                    <div class="flex items-center">
                        <input id="is_unlimited" name="is_unlimited" type="checkbox" value="1"
                            {{ old('is_unlimited', is_null($product->stok) ? '1' : '') ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer">
                        <label for="is_unlimited"
                            class="ml-2 text-xs font-medium text-gray-900 cursor-pointer select-none">
                            Stok Unlimited
                        </label>
                    </div>
                </div>

                <input type="number" id="stok" name="stok" value="{{ old('stok', $product->stok) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3 disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed transition-colors"
                    placeholder="0">
                <p id="stok-helper" class="text-xs text-gray-500 mt-1 hidden">Otomatis terhitung (Awal + Restock)</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="diskon_tipe" class="block mb-2 text-sm font-medium text-gray-700">Tipe Diskon</label>
                <select id="diskon_tipe" name="diskon_tipe" onchange="handleDiscountChange()"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3">
                    <option value="" {{ old('diskon_tipe', $product['diskon_tipe']) == '' ? 'selected' : '' }}>Tidak
                        ada diskon</option>
                    <option value="percentage"
                        {{ old('diskon_tipe', $product['diskon_tipe']) == 'percentage' ? 'selected' : '' }}>Persentase (%)
                    </option>
                    <option value="fixed" {{ old('diskon_tipe', $product['diskon_tipe']) == 'fixed' ? 'selected' : '' }}>
                        Potongan Tetap (Rp)</option>
                </select>
            </div>
            <div>
                <label for="diskon_nilai" class="block mb-2 text-sm font-medium text-gray-700">Nilai Diskon</label>
                <input type="number" id="diskon_nilai" name="diskon_nilai"
                    value="{{ old('diskon_nilai', $product->diskon_nilai) }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3 disabled:bg-gray-200 disabled:cursor-not-allowed transition-colors"
                    placeholder="0">
            </div>
        </div>

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status Awal</label>
            <select id="status" name="status"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3">
                <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Tersedia
                </option>
                <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Tidak
                    Tersedia</option>
            </select>
        </div>

        <button type="submit"
            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition-all duration-200">
            Update Produk
        </button>

    </form>

    <script>
        // 1. Logic Image Preview (Tetap sama)
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');

        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        if (imagePlaceholder) imagePlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // 2. LOGIC UTAMA: Supplier, Restock, & Stok Total
        const supplierSelect = document.getElementById('supplier_id');
        const restockContainer = document.getElementById('restock-container');
        const restockInput = document.getElementById('restock_qty');
        const stockInput = document.getElementById('stok');
        const stockHelper = document.getElementById('stok-helper');
        const unlimitedCheckbox = document.getElementById('is_unlimited');
        const catatanField = document.getElementById('catatan-field');
        const oldStockVal = parseInt(document.getElementById('old_stock').value) || 0;

        function updateStockLogic() {
            const hasSupplier = supplierSelect.value !== "";
            const isUnlimited = unlimitedCheckbox.checked;
            const restockVal = parseInt(restockInput.value) || 0;

            if (hasSupplier) {
                // --- KASUS 1: MODE SUPPLIER (SUPPLIER DIPILIH) ---
                // Stok Total WAJIB terkunci dan dihitung otomatis

                restockContainer.classList.remove('hidden');
                catatanField.classList.remove('hidden');

                // Matikan Unlimited
                unlimitedCheckbox.checked = false;
                unlimitedCheckbox.disabled = true;
                unlimitedCheckbox.parentElement.classList.add('opacity-50');

                // Kalkulasi Otomatis (Stok Lama + Input Restock)
                stockInput.value = oldStockVal + restockVal;

                // KUNCI FIELD (TAPI DATA TETAP TERKIRIM)
                stockInput.setAttribute('readonly', true);
                stockInput.disabled = false; // Penting: Jangan disabled agar lolos validasi required

                // VISUAL: Buat terlihat mati (bg-gray-200)
                stockInput.classList.remove('bg-gray-50', 'bg-white');
                stockInput.classList.add('bg-gray-200', 'cursor-not-allowed', 'text-gray-500');

                // Tampilkan Helper Text
                stockHelper.innerText = "Stok terkunci (Otomatis: Stok Lama + Restock)";
                stockHelper.classList.remove('hidden');

            } else {
                // --- KASUS 2: MODE MANUAL (TANPA SUPPLIER) ---

                catatanField.classList.add('hidden');
                unlimitedCheckbox.disabled = false;
                unlimitedCheckbox.parentElement.classList.remove('opacity-50');

                // Tampilkan input restock jika TIDAK unlimited
                if (isUnlimited) {
                    restockContainer.classList.add('hidden');
                    restockInput.value = '';
                } else {
                    restockContainer.classList.remove('hidden');
                }

                // LOGIKA HYBRID:
                // A. Jika user mengetik di Restock -> Stok Total Terkunci & Otomatis
                if (!isUnlimited && restockVal > 0) {
                    stockInput.value = oldStockVal + restockVal;

                    stockInput.setAttribute('readonly', true);
                    stockInput.classList.remove('bg-gray-50', 'bg-white');
                    stockInput.classList.add('bg-gray-200', 'cursor-not-allowed', 'text-gray-500'); // Warna Gelap

                    stockHelper.classList.remove('hidden');
                    stockHelper.innerText = "Otomatis terhitung (Awal + Restock Input)";
                }
                // B. Jika Restock Kosong -> User bebas edit Stok Total (Koreksi Stok)
                else if (!isUnlimited) {
                    stockInput.removeAttribute('readonly');

                    // Kembalikan ke warna normal (putih/terang)
                    stockInput.classList.remove('bg-gray-200', 'cursor-not-allowed', 'text-gray-500');
                    stockInput.classList.add('bg-gray-50'); // Atau bg-white sesuai selera

                    stockHelper.classList.add('hidden');

                    // Kembalikan ke stok lama jika field kosong agar tidak error
                    if (stockInput.value === '') {
                        stockInput.value = oldStockVal;
                    }
                }
            }

            handleUnlimitedCheck();
        }

        function handleUnlimitedCheck() {
            // Jika unlimited dicentang
            if (!unlimitedCheckbox.disabled) {
                if (unlimitedCheckbox.checked) {
                    // Mode Unlimited: Input Stok dimatikan total
                    stockInput.setAttribute('readonly', true);
                    stockInput.placeholder = "∞ (Unlimited)";
                    stockInput.value = "";

                    // Visual Gelap
                    stockInput.classList.remove('bg-gray-50', 'bg-white');
                    stockInput.classList.add('bg-gray-200', 'cursor-not-allowed');

                    // Disabled false agar status unlimited terkirim, tapi validasi stok di-ignore di backend
                    stockInput.disabled = false;

                    restockContainer.classList.add('hidden');
                    restockInput.value = '';
                } else {
                    // Jika di-uncheck, kembalikan ke normal jika tidak ada supplier
                    if (supplierSelect.value === "") {
                        stockInput.setAttribute('readonly', true);
                        stockInput.classList.remove('bg-gray-50', 'bg-white');
                        stockInput.classList.add('bg-gray-200', 'cursor-not-allowed', 'text-gray-500');
                        stockInput.placeholder = "0";
                    }

                    if (restockContainer.classList.contains('hidden') && supplierSelect.value === "") {
                        restockContainer.classList.remove('hidden');
                    }
                }
            }
        }

        // 3. Logic Diskon
        function handleDiscountChange() {
            const typeSelect = document.getElementById('diskon_tipe');
            const valueInput = document.getElementById('diskon_nilai');

            if (typeSelect.value === "") {
                valueInput.disabled = true;
                valueInput.classList.add('bg-gray-200', 'cursor-not-allowed');
            } else {
                valueInput.disabled = false;
                valueInput.classList.remove('bg-gray-200', 'cursor-not-allowed');
            }
        }

        // 4. Init
        document.addEventListener('DOMContentLoaded', function() {
            handleDiscountChange();
            updateStockLogic();

            supplierSelect.addEventListener('change', updateStockLogic);
            restockInput.addEventListener('input', updateStockLogic);
            unlimitedCheckbox.addEventListener('change', function() {
                handleUnlimitedCheck();
                updateStockLogic();
            });
        });
    </script>
@endsection

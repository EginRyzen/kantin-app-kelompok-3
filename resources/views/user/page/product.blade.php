@extends('user.layouts.app')

@section('title', 'Manajemen Produk')

@section('content')

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manajemen Produk</h1>
            <p class="text-sm text-gray-500">Atur produk yang tersedia di kantin Anda.</p>
        </div>
        <a href="{{ route('kasir.products.create') }}"
            class="bg-green-600 text-white p-3 rounded-full shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    </div>

    <form id="product-filter-form" action="{{ route('kasir.products.index') }}" method="GET">

        <div class="mb-4 relative">
            <input id="search-input" name="search" type="text" value="{{ $searchQuery ?? '' }}"
                placeholder="Cari produk (misal: Nasi Goreng...)"
                class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition">

            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>

        <input type="hidden" id="category-id-input" name="category_id" value="{{ $selectedCategoryId ?? '' }}">

        <button type="submit" class="hidden">Filter</button>
    </form>


    <div class="mb-5">
        <div class="flex space-x-3 overflow-x-auto pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">

            <a href="#" onclick="event.preventDefault(); filterCategory('');"
                class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap cursor-pointer
                      {{ !$selectedCategoryId ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua Produk
            </a>

            @foreach ($categories as $category)
                <a href="#" onclick="event.preventDefault(); filterCategory('{{ $category->id }}');"
                    class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap cursor-pointer
                          {{ $selectedCategoryId == $category->id ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $category->nama_kategori }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">

        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="flex">
                    <div class="w-1/3 flex-shrink-0">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/150x150/e2e8f0/333?text=No+Image' }}"
                            alt="{{ $product->nama_produk }}" class="h-full w-full object-cover"
                            onerror="this.src='https://placehold.co/150x150/e2e8f0/333?text=Error'">
                    </div>

                    <div class="w-2/3 p-4 relative">

                        <div class="absolute top-4 right-4 flex flex-col items-end space-y-2 z-2">

                            <div>
                                <button id="dropdownButton-{{ $product->id }}"
                                    data-dropdown-toggle="dropdown-{{ $product->id }}"
                                    class="inline-block text-gray-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm p-1.5"
                                    type="button">
                                    <span class="sr-only">Buka dropdown</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4Zm0 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4Zm0 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z" />
                                    </svg>
                                </button>

                                <div id="dropdown-{{ $product->id }}"
                                    class="hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                    <ul class="py-2" aria-labelledby="dropdownButton-{{ $product->id }}">
                                        <li>
                                            <a href="{{ route('kasir.products.edit', $product->id) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button"
                                                onclick="showDeleteModal('{{ $product->id }}', '{{ $product->nama_produk }}')"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('kasir.products.destroy', $product->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>

                            <div>
                                @if ($product->status == 'available' && (is_null($product->stok) || $product->stok > 0))
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Tersedia
                                </span>
                            @else
                                <span class="bg-red-100  text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Habis / Belum Ready
                                </span>
                            @endif
                            </div>
                        </div>

                        <div class="pr-12">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 truncate">{{ $product->nama_produk }}</h3>
                            <p class="text-gray-500 text-sm mb-2">
                                {{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-xl font-extrabold text-green-700">
                                Rp {{ number_format($product->harga_akhir, 0, ',', '.') }}
                            </span>

                            @if ($product->harga_akhir < $product->harga_jual)
                                <span class="ml-2 text-sm text-gray-400 line-through">
                                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>

                        <div class="text-sm mt-3">
                            <p class="text-gray-600">
                                Stok:
                                @if (is_null($product->stok))
                                    <span class="font-bold text-green-600">
                                        ∞ (Unlimited)
                                    </span>
                                @else
                                    <span class="font-bold {{ $product->stok > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                        {{ $product->stok }}
                                    </span>
                                @endif
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        @empty
            <div class="text-center py-10 px-6 bg-white rounded-lg shadow-md">
                <svg class="w-16 h-16 text-gray-400 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-800">Tidak Ada Produk</h3>
                <p class="mt-2 text-gray-500">
                    @if ($searchQuery)
                        Tidak ada produk yang cocok dengan pencarian "{{ $searchQuery }}".
                    @elseif($selectedCategoryId)
                        Tidak ada produk di kategori ini.
                    @else
                        Anda belum menambahkan produk apapun.
                    @endif
                </p>
            </div>
        @endforelse


    </div>


    <div id="delete-product-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">

                <button id="modal-close-button" type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>

                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">
                        <span id="delete-modal-text">Anda yakin ingin menghapus produk ini?</span>
                    </h3>

                    <button id="confirm-delete-button" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Ya, Hapus
                    </button>

                    <button id="modal-cancel-button" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            // Ambil elemen form dan input
            const filterForm = document.getElementById('product-filter-form');
            const searchInput = document.getElementById('search-input');
            const categoryInput = document.getElementById('category-id-input');
            let debounceTimer; // Timer untuk debounce

            // 1. Fungsi untuk submit form (dipakai oleh search dan filter)
            function submitFilterForm() {
                filterForm.submit();
            }

            // 2. Fungsi untuk filter kategori (dipanggil oleh link <a>)
            function filterCategory(categoryId) {
                // Set nilai hidden input kategori
                categoryInput.value = categoryId;
                // Langsung submit form
                submitFilterForm();
            }

            // 3. Event listener untuk search input (dengan debounce)
            // 'input' event lebih responsif daripada 'change'
            searchInput.addEventListener('input', (e) => {
                // Hapus timer sebelumnya
                clearTimeout(debounceTimer);

                // Set timer baru. Form akan di-submit setelah 500ms tidak mengetik
                debounceTimer = setTimeout(() => {
                    submitFilterForm();
                }, 500); // 500ms delay. Anda bisa kecilkan jika mau lebih cepat.
            });
        </script>

        <script>
            // Ambil elemen DOM statis SATU KALI
            const modalEl = document.getElementById('delete-product-modal');
            const modalText = document.getElementById('delete-modal-text');
            const confirmDeleteButton = document.getElementById('confirm-delete-button');
            const cancelDeleteButton = document.getElementById('modal-cancel-button');
            const closeDeleteButton = document.getElementById('modal-close-button');

            // Buat instance modal SATU KALI
            const deleteModal = new Modal(modalEl);

            // Variabel global untuk menyimpan form yang akan di-submit
            let formToSubmit = null;

            // Fungsi yang dipanggil oleh tombol "Hapus" di dropdown
            function showDeleteModal(productId, productName) {
                // 1. Simpan form yang benar ke variabel global
                formToSubmit = document.getElementById('delete-form-' + productId);

                // 2. Set teks modal
                modalText.textContent = 'Anda yakin ingin menghapus produk "' + productName +
                    '"? Tindakan ini tidak dapat dibatalkan.';

                // 3. Tampilkan modal
                deleteModal.show();
            }

            // Tambahkan event listener permanen SATU KALI

            // Listener untuk Tombol "Ya, Hapus"
            confirmDeleteButton.addEventListener('click', () => {
                if (formToSubmit) { // Cek apakah ada form yang disimpan
                    deleteModal.hide();
                    formToSubmit.submit();
                    formToSubmit = null; // Bersihkan variabel setelah submit
                }
            });

            // Listener untuk Tombol "Batal"
            cancelDeleteButton.addEventListener('click', () => {
                deleteModal.hide();
                formToSubmit = null; // Bersihkan variabel
            });

            // Listener untuk Tombol "X" (Tutup)
            closeDeleteButton.addEventListener('click', () => {
                deleteModal.hide();
                formToSubmit = null; // Bersihkan variabel
            });
        </script>
    @endpush

@endsection

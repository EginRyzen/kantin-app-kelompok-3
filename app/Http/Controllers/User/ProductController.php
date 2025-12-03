<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $outletId = Auth::user()->outlet_id;

        $selectedCategoryId = $request->query('category_id');
        $searchQuery = $request->query('search');

        $productQuery = Product::where('outlet_id', $outletId)
            ->with('category')
            ->latest();

        if ($selectedCategoryId) {
            $productQuery->where('category_id', $selectedCategoryId);
        }

        if ($searchQuery) {
            $productQuery->where('nama_produk', 'LIKE', '%' . $searchQuery . '%');
        }

        $products = $productQuery->get();

        $products = $products->map(function ($product) {
            $hargaAsli = (float) $product->harga_jual;
            $diskonTipe = $product->diskon_tipe;
            $diskonNilai = (float) $product->diskon_nilai;
            $hargaAkhir = $hargaAsli;

            if ($diskonTipe == 'percentage' && $diskonNilai > 0) {
                $potongan = ($hargaAsli * $diskonNilai) / 100;
                $hargaAkhir = $hargaAsli - $potongan;
            } elseif ($diskonTipe == 'fixed' && $diskonNilai > 0) {
                $hargaDiskon = $hargaAsli - $diskonNilai;
                $hargaAkhir = $hargaDiskon > 0 ? $hargaDiskon : 0;
            }
            $product->harga_akhir = $hargaAkhir;
            return $product;
        });

        $categories = Category::where('outlet_id', $outletId)
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('user.page.product', compact(
            'products',
            'categories',
            'selectedCategoryId',
            'searchQuery'
        ));
    }

    public function create()
    {
        $outletId = Auth::user()->outlet_id;

        $categories = Category::where('outlet_id', $outletId)->orderBy('nama_kategori', 'asc')->get();

        // Filter supplier berdasarkan outlet
        $suppliers = Supplier::where('outlet_id', $outletId)->orderBy('nama_supplier', 'asc')->get();

        return view('user.page.product-create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'nama_produk' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kode_produk' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric|min:0',

            // Validasi field bantuan (hanya dipakai jika supplier dipilih)
            'restock_qty' => 'nullable|integer|min:0',

            'stok' => 'required_without:is_unlimited|nullable|integer|min:0',
            'diskon_tipe' => 'nullable|in:percentage,fixed',
            'diskon_nilai' => 'nullable|numeric|min:0|required_with:diskon_tipe',
            'status' => 'required|in:available,unavailable',
            'catatan_stok' => 'nullable|string|max:255',
        ]);

        // Cek Unlimited
        if ($request->has('is_unlimited')) {
            $validatedData['stok'] = null; // Set null untuk unlimited
        }

        // LOGIKA KHUSUS: Jika via Supplier, pakai nilai restock_qty sebagai stok awal
        // Ini untuk memastikan data konsisten walaupun field stok di-disable/readonly di frontend
        if ($request->filled('supplier_id') && $request->filled('restock_qty')) {
            $validatedData['stok'] = (int) $request->restock_qty;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }

        // Bersihkan field bantuan sebelum create
        unset($validatedData['restock_qty']);
        unset($validatedData['catatan_stok']); // Catatan disimpan terpisah di StockMovement

        DB::beginTransaction();
        try {
            // 1. Buat Produk
            $product = Product::create($validatedData);

            // 2. Catat Stock Movement
            $jumlahMove = $product->stok ?? 0;
            $catatan = $request->catatan_stok;

            // Set catatan default jika kosong
            if (empty($catatan)) {
                if ($request->filled('supplier_id')) {
                    $catatan = 'Stok Awal dari Supplier';
                } else {
                    $catatan = 'Stok Awal Produk Baru';
                }
            }

            if ($request->has('is_unlimited')) {
                $catatan .= ' (Status: Unlimited)';
            }

            // Simpan log jika ada stok atau status unlimited
            if ($jumlahMove > 0 || $request->has('is_unlimited')) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => 'restock',
                    'jumlah' => $jumlahMove,
                    'catatan' => $catatan,
                ]);
            }

            DB::commit();
            return redirect()->route('kasir.products.index')
                ->with('success', 'Produk baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->outlet_id != Auth::user()->outlet_id) {
            abort(403, 'Anda tidak diizinkan mengedit produk ini.');
        }

        $outletId = Auth::user()->outlet_id;

        $categories = Category::where('outlet_id', $outletId)->orderBy('nama_kategori', 'asc')->get();

        $suppliers = Supplier::where('outlet_id', $outletId)->orderBy('nama_supplier', 'asc')->get();

        return view('user.page.product-edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->outlet_id != Auth::user()->outlet_id) {
            abort(403, 'Anda tidak diizinkan mengedit produk ini.');
        }

        // 1. Pre-processing Input
        if (empty($request->supplier_id)) {
            $request->merge(['supplier_id' => null]);
        }
        
        // Jika unlimited dicentang, paksa stok jadi null agar validasi integer lolos
        if ($request->filled('is_unlimited')) {
             $request->merge(['stok' => null]);
        }

        // 2. Validasi
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'nama_produk' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            Rule::unique('products')
                ->where(fn ($query) => $query->where('outlet_id', $product->outlet_id))
                ->ignore($product->id),
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric|min:0',
            
            // Validasi Input Mutasi (Restock & Reduction)
            'restock_qty' => 'nullable|integer|min:0',
            'reduction_qty' => 'nullable|integer|min:0', // <--- VALIDASI BARU

            // Validasi Stok Total
            'stok' => 'required_without:is_unlimited|nullable|integer|min:0',
            
            'diskon_tipe' => 'nullable|in:percentage,fixed',
            'diskon_nilai' => 'nullable|numeric|min:0|required_with:diskon_tipe',
            'status' => 'required|in:available,unavailable',
            'catatan_stok' => 'nullable|string|max:255',
        ]);

        // 3. Handle File Image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }

        // Handle Logic Unlimited di Array
        if ($request->has('is_unlimited')) {
            $validatedData['stok'] = null;
        }

        // 4. Bersihkan Field Bantuan (Agar tidak error saat update ke tabel products)
        unset($validatedData['catatan_stok']);
        unset($validatedData['restock_qty']);
        unset($validatedData['reduction_qty']); // <--- CLEANUP BARU

        DB::beginTransaction();
        try {
            $oldStock = $product->stok;
            
            // Ambil value input mutasi
            $restockVal = (int) $request->restock_qty;
            $reductionVal = (int) $request->reduction_qty; // <--- VALUE BARU

            // --- LOGIKA PENENTUAN STOK BARU ---

            // KASUS 1: Jika ada Supplier, ATAU ada input Restock, ATAU ada input Pengurangan
            // (Kita prioritaskan perhitungan mutasi daripada input manual 'stok' jika field ini diisi)
            if ($request->filled('supplier_id') || $restockVal > 0 || $reductionVal > 0) {
                
                $currentStockVal = $oldStock ?? 0;
                
                // RUMUS: Stok Lama + Masuk - Keluar
                $newStock = $currentStockVal + $restockVal - $reductionVal;
                
                // Safety check agar tidak minus di database
                if ($newStock < 0) $newStock = 0; 

                $validatedData['stok'] = $newStock; // Override data stok yang akan diupdate

                // Reset variable generic movement (karena kita akan buat movement spesifik di bawah)
                $jumlahGerakanManual = 0; 
                $tipeGerakanManual = null;
            }
            // KASUS 2: Edit Manual Stok Total (Tanpa mengisi field restock/reduction)
            // Logic lama tetap jalan untuk koreksi cepat
            else {
                $newStock = $request->has('is_unlimited') ? null : (int) $request->stok;
                
                $jumlahGerakanManual = 0;
                $tipeGerakanManual = 'restock'; // default

                if (!is_null($oldStock) && !is_null($newStock)) {
                    $diff = $newStock - $oldStock;
                    $jumlahGerakanManual = abs($diff);
                    $tipeGerakanManual = $diff > 0 ? 'restock' : 'penjualan';
                } elseif (is_null($oldStock) && !is_null($newStock)) {
                    // Dari Unlimited ke Angka
                    $jumlahGerakanManual = $newStock;
                    $tipeGerakanManual = 'restock';
                }
            }

            // --- UPDATE DATABASE ---
            $product->update($validatedData);

            // --- PENCATATAN RIWAYAT (STOCK MOVEMENTS) ---

            // A. Catat Restock (Jika field restock diisi)
            if ($restockVal > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => 'restock',
                    'jumlah' => $restockVal,
                    'catatan' => $request->catatan_stok ?? ($request->filled('supplier_id') ? 'Restock via Supplier' : 'Restock Tambahan'),
                ]);
            }

            // B. Catat Pengurangan (Jika field reduction diisi)
            if ($reductionVal > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => 'rusak', // Masuk sebagai 'rusak' sesuai request
                    'jumlah' => $reductionVal,
                    'catatan' => $request->catatan_stok ?? 'Pengurangan Stok (Rusak/Kadaluwarsa)',
                ]);
            }

            // C. Catat Perubahan Manual (Hanya jika TIDAK ada input restock/reduction)
            // Ini untuk mencegah double recording
            if ($restockVal == 0 && $reductionVal == 0 && ($jumlahGerakanManual > 0 || ($oldStock !== $product->stok))) {
                
                $catatan = $request->catatan_stok;
                if (empty($catatan)) {
                    $catatan = 'Update Stok Manual (Koreksi)';
                }

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => $tipeGerakanManual,
                    'jumlah' => $jumlahGerakanManual,
                    'catatan' => $catatan . ($product->stok === null ? ' (Menjadi Unlimited)' : ''),
                ]);
            }

            DB::commit();
            return redirect()->route('kasir.products.index')->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal update produk: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->outlet_id != Auth::user()->outlet_id) {
            abort(403, 'Anda tidak diizinkan menghapus produk ini.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('kasir.products.index')
            ->with('success', 'Produk "' . $product->nama_produk . '" berhasil dihapus.');
    }
}

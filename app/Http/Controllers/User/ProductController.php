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

        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'nama_produk' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kode_produk' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products')->ignore($product->id),
            ],
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric|min:0',

            // Validasi Restock Qty (Hanya jika supplier dipilih)
            'restock_qty' => 'nullable|integer|min:0',

            // Stok tetap divalidasi, tapi nanti kita hitung ulang di controller jika ada restock
            'stok' => 'required_without:is_unlimited|nullable|integer|min:0',

            'diskon_tipe' => 'nullable|in:percentage,fixed',
            'diskon_nilai' => 'nullable|numeric|min:0|required_with:diskon_tipe',
            'status' => 'required|in:available,unavailable',
            'catatan_stok' => 'nullable|string|max:255',
        ]);

        // Handle Logic Unlimited
        if ($request->has('is_unlimited')) {
            $validatedData['stok'] = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }

        // Hapus field bantuan agar tidak error saat update model
        unset($validatedData['catatan_stok']);
        unset($validatedData['restock_qty']);

        DB::beginTransaction();
        try {
            $oldStock = $product->stok;
            $newStock = null;
            $tipeGerakan = 'restock'; // Default
            $jumlahGerakan = 0;

            // LOGIKA PENENTUAN STOK BARU

            // KASUS 1: Jika Supplier Dipilih & Ada Input Restock -> Tambahkan ke Stok Lama
            if ($request->filled('supplier_id') && $request->filled('restock_qty') && $request->restock_qty > 0) {
                // Pastikan stok lama dianggap 0 jika null (unlimited) agar bisa dijumlah
                $currentStockVal = $oldStock ?? 0;
                $newStock = $currentStockVal + (int) $request->restock_qty;

                $validatedData['stok'] = $newStock; // Override data stok
                $jumlahGerakan = (int) $request->restock_qty;
                $tipeGerakan = 'restock';
            }
            // KASUS 2: Edit Manual (Tanpa Supplier / Tanpa Restock)
            else {
                $newStock = $request->has('is_unlimited') ? null : (int) $request->stok;

                // Hitung selisih untuk mencatat movement
                if (!is_null($oldStock) && !is_null($newStock)) {
                    $diff = $newStock - $oldStock;
                    $jumlahGerakan = abs($diff);
                    $tipeGerakan = $diff > 0 ? 'restock' : 'penjualan';
                } elseif (is_null($oldStock) && !is_null($newStock)) {
                    // Dari Unlimited ke Angka
                    $jumlahGerakan = $newStock;
                    $tipeGerakan = 'restock';
                }
                // Kasus lain (tetap unlimited atau unlimited baru) dianggap gerakan 0/simbolis
            }

            // Update Produk
            $product->update($validatedData);

            // Catat Movement jika ada perubahan atau restock
            if ($jumlahGerakan > 0 || ($oldStock !== $newStock)) {
                $catatan = $request->catatan_stok;

                if (empty($catatan)) {
                    if ($request->filled('restock_qty') && $request->restock_qty > 0) {
                        $catatan = 'Restock via Supplier';
                    } else {
                        $catatan = 'Update Stok Manual';
                    }
                }

                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => $tipeGerakan,
                    'jumlah' => $jumlahGerakan,
                    'catatan' => $catatan . ($newStock === null ? ' (Menjadi Unlimited)' : ''),
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

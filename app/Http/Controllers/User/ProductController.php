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
            // Stok wajib diisi KECUALI checkbox unlimited dicentang
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

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }

        DB::beginTransaction();
        try {
            // 1. Buat Produk
            $product = Product::create($validatedData);

            // 2. Catat Stock Movement (Hanya jika stok tidak null/unlimited dan > 0)
            // Jika unlimited, kita catat sebagai info saja dengan jumlah 0
            $jumlahMove = $product->stok ?? 0;
            $catatan = $request->catatan_stok ?? 'Stok Awal Produk Baru';
            
            if ($request->has('is_unlimited')) {
                $catatan .= ' (Status: Unlimited)';
            }

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

        DB::beginTransaction();
        try {
            $oldStock = $product->stok;
            $newStock = $request->has('is_unlimited') ? null : (int) $request->stok;
            
            // Update Produk
            $product->update($validatedData);

            // Logika Stock Movement yang Lebih Aman
            // 1. Jika keduanya Angka (Normal Update)
            if (!is_null($oldStock) && !is_null($newStock)) {
                $diff = $newStock - $oldStock;
                if ($diff != 0) {
                    $tipe = $diff > 0 ? 'restock' : 'penjualan';
                    
                    if($request->filled('supplier_id') && $diff > 0) {
                         $tipe = 'restock';
                    }
                    
                    $catatan = $request->catatan_stok;
                    if(empty($catatan)) {
                        $catatan = $diff > 0 ? 'Penambahan Stok Manual' : 'Pengurangan Stok Manual';
                    }

                    StockMovement::create([
                        'product_id' => $product->id,
                        'user_id' => Auth::id(),
                        'tipe_gerakan' => $tipe,
                        'jumlah' => abs($diff),
                        'catatan' => $catatan,
                    ]);
                }
            }
            // 2. Transisi: Dari Terbatas ke Unlimited
            elseif (!is_null($oldStock) && is_null($newStock)) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => 'restock',
                    'jumlah' => 0, // Simbolis
                    'catatan' => 'Ubah status ke Stok Unlimited. ' . ($request->catatan_stok ?? ''),
                ]);
            }
            // 3. Transisi: Dari Unlimited ke Terbatas
            elseif (is_null($oldStock) && !is_null($newStock)) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'tipe_gerakan' => 'restock',
                    'jumlah' => $newStock, 
                    'catatan' => 'Ubah dari Unlimited ke Stok Terbatas. ' . ($request->catatan_stok ?? ''),
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
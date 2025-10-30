<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();

        return view('user.page.product-create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'nama_produk' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'kode_produk' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'diskon_tipe' => 'nullable|in:percentage,fixed',
            'diskon_nilai' => 'nullable|numeric|min:0|required_with:diskon_tipe',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');

            $validatedData['image'] = $path;
        }

        Product::create($validatedData);

        return redirect()->route('kasir.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->outlet_id != Auth::user()->outlet_id) {
            abort(403, 'Anda tidak diizinkan mengedit produk ini.');
        }

        $outletId = Auth::user()->outlet_id;
        $categories = Category::where('outlet_id', $outletId)->orderBy('nama_kategori', 'asc')->get();
        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();

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
            'stok' => 'required|integer|min:0',
            'diskon_tipe' => 'nullable|in:percentage,fixed',
            'diskon_nilai' => 'nullable|numeric|min:0|required_with:diskon_tipe',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }

        $product->update($validatedData);

        return redirect()->route('kasir.products.index');
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

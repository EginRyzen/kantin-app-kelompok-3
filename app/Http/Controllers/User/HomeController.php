<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product; // PENTING: Import Model Product
use Illuminate\Support\Facades\Auth; // PENTING: Import Auth

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $outletId = Auth::user()->outlet_id;

        // 1. Ambil parameter dari URL (Search & Filter)
        $selectedCategoryId = $request->query('category_id');
        $searchQuery = $request->query('search');

        // 2. Query Dasar Produk
        $productQuery = Product::where('outlet_id', $outletId)
            ->with('category') // Eager load kategori agar lebih efisien
            ->where('status', 'available') // Tetap filter status available
            ->latest();

        // 3. Terapkan Filter Kategori (Jika ada)
        if ($selectedCategoryId) {
            $productQuery->where('category_id', $selectedCategoryId);
        }

        // 4. Terapkan Pencarian (Jika ada)
        if ($searchQuery) {
            $productQuery->where('nama_produk', 'LIKE', '%' . $searchQuery . '%');
        }

        // 5. Ambil Data Produk
        $products = $productQuery->get();

        // 6. Hitung Harga Akhir (Diskon)
        $products->transform(function ($product) {
            $hargaAsli = (float) $product->harga_jual;
            $hargaAkhir = $hargaAsli;

            if ($product->diskon_tipe == 'percentage' && $product->diskon_nilai > 0) {
                $potongan = ($hargaAsli * $product->diskon_nilai) / 100;
                $hargaAkhir = $hargaAsli - $potongan;
            } elseif ($product->diskon_tipe == 'fixed' && $product->diskon_nilai > 0) {
                $hargaAkhir = $hargaAsli - $product->diskon_nilai;
            }

            // Pastikan harga tidak negatif
            $product->harga_akhir = max($hargaAkhir, 0);

            return $product;
        });

        // 7. Ambil Data Kategori untuk Tombol Filter
        $categories = Category::where('outlet_id', $outletId)
            ->orderBy('nama_kategori', 'asc')
            ->get();

        // 8. Kirim semua variabel ke view
        return view('user.page.home', compact(
            'products',
            'categories',
            'selectedCategoryId',
            'searchQuery'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

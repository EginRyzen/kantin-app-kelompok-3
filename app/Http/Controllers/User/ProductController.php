<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category; // <-- 1. IMPORT MODEL
use App\Models\Supplier; // <-- 1. IMPORT MODEL
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- 1. IMPORT AUTH

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman daftar produk
        return view('user.page.product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // === 2. PERBARUI BAGIAN INI ===
        // Kita perlu mengambil data Kategori & Supplier
        // untuk ditampilkan di dropdown formulir

        // Ambil ID outlet dari user yang sedang login
        $outletId = Auth::user()->outlet_id;

        // Ambil Kategori HANYA dari outlet milik user
        $categories = Category::where('outlet_id', $outletId)->orderBy('nama_kategori', 'asc')->get();

        // Ambil semua supplier (diasumsikan supplier bersifat global)
        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();
        
        // Kirim data categories dan suppliers ke view
        return view('user.page.product-create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // (Logika untuk validasi dan simpan data akan ada di sini)
        // Contoh:
        // $validatedData = $request->validate([ ... validasi ... ]);
        // Product::create($validatedData);

        // Untuk sekarang, kita redirect kembali ke halaman index
        return redirect()->route('kasir.products.index')
                         ->with('success', 'Produk baru berhasil ditambahkan!');
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


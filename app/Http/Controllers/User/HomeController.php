<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // PENTING: Import Model Product
use Illuminate\Support\Facades\Auth; // PENTING: Import Auth

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil Outlet ID dari user yang login
        $outletId = Auth::user()->outlet_id;

        // 2. Ambil produk dari database berdasarkan outlet tersebut
        //    Hanya ambil yang statusnya 'available' (tersedia)
        $products = Product::where('outlet_id', $outletId)
                    ->where('status', 'available')
                    ->latest() // Urutkan dari yang terbaru
                    ->get();

        // 3. Hitung harga akhir (Diskon) agar siap ditampilkan
        //    Ini sama dengan logika di ProductController
        $products->transform(function ($product) {
            $hargaAsli = $product->harga_jual;
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

        // 4. Kirim variabel $products ke view menggunakan compact()
        return view('user.page.home', compact('products'));  
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
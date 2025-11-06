<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlet; // Pastikan Anda sudah membuat model Outlet

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data outlet dari tabel 'outlets'
        $outlets = Outlet::latest()->paginate(10); 

        return view('admin.page.outlets.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // (Nanti untuk halaman tambah outlet)
        return "Halaman Tambah Outlet"; 
    }

    // ... (method store, show, edit, update, destroy lainnya) ...
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlet; // Pastikan Anda sudah membuat model Outlet
use App\Models\Transaction; // Pastikan Anda sudah membuat model Transaction
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // === 1. STATISTIK OUTLET ===
        // Mengambil data dari tabel 'outlets'
        $totalOutlets = Outlet::count();
        $activeOutlets = Outlet::where('is_active', 1)->count(); //
        $inactiveOutlets = Outlet::where('is_active', 0)->count(); //

        // === 2. DATA GRAFIK PENJUALAN (7 Hari Terakhir) ===
        // Mengambil data dari tabel 'transactions'
        $salesData = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_harga) as total_sales') //
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Format data untuk Chart.js
        $chartLabels = $salesData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M'); // Format tanggal (cth: 04 Nov)
        });
        
        $chartData = $salesData->pluck('total_sales');

        // Kirim semua data ke view
        return view('admin.page.dashboard', compact(
            'totalOutlets',
            'activeOutlets',
            'inactiveOutlets',
            'chartLabels',
            'chartData'
        ));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction; //
use App\Models\Outlet;      //
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan transaksi dengan filter.
     */
    public function index(Request $request)
    {
        // Ambil semua outlet untuk dropdown filter
        $outlets = Outlet::orderBy('nama_outlet', 'asc')->get();

        // Mulai query ke tabel 'transactions'
        $query = Transaction::query()
                    ->with(['outlet', 'user', 'customer']) // Ambil relasi
                    ->orderBy('created_at', 'desc'); // Urutkan dari terbaru

        // Filter 1: Berdasarkan Outlet
        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        // Filter 2: Berdasarkan Rentang Tanggal
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        } elseif ($startDate) {
            // Jika hanya tanggal mulai
            $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
        } elseif ($endDate) {
            // Jika hanya tanggal akhir
            $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        // Eksekusi query dengan pagination
        $transactions = $query->paginate(20)->withQueryString(); // withQueryString agar filter tetap ada saat ganti halaman

        // Kirim data ke view
        return view('admin.page.reports.index', [
            'transactions' => $transactions,
            'outlets' => $outlets,
            'filters' => $request->only(['outlet_id', 'start_date', 'end_date']) // Untuk mengisi ulang form filter
        ]);
    }
}
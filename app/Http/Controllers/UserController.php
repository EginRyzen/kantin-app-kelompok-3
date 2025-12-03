<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    // ==========================================
    // 1. MENU UTAMA PROFIL
    // ==========================================
    public function profile()
    {
        // PERBAIKAN: Gunakan outlet_id agar data satu toko tampil semua
        // Jika pakai user_id, cuma tampil data diri sendiri
        $outletId = Auth::user()->outlet_id;

        // Ringkasan Singkat untuk Dashboard (PER OUTLET)
        $userIncomeToday = Transaction::where('outlet_id', $outletId) // Ganti user_id jadi outlet_id
            ->whereDate('created_at', Carbon::today())
            ->sum('total_harga');

        $userTxToday = Transaction::where('outlet_id', $outletId) // Ganti user_id jadi outlet_id
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('user.page.profile', compact('userIncomeToday', 'userTxToday'));
    }

    // ==========================================
    // 2. HALAMAN KHUSUS PENDAPATAN (UANG)
    // ==========================================
    public function income()
    {
        // PERBAIKAN: Gunakan outlet_id
        $outletId = Auth::user()->outlet_id;

        // A. Total Uang Hari Ini (PER OUTLET)
        $todayRevenue = Transaction::where('outlet_id', $outletId)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_harga');

        // B. Rekapan Bulanan (Fokus ke Uang, PER OUTLET)
        $monthlyRecap = Transaction::where('outlet_id', $outletId)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month_year, SUM(total_harga) as total_revenue')
            ->groupBy('month_year')
            ->orderBy('month_year', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($row) {
                $date = Carbon::createFromFormat('Y-m', $row->month_year);
                $row->month_name = $date->translatedFormat('F Y');
                return $row;
            });

        return view('user.page.profile-income', compact('todayRevenue', 'monthlyRecap'));
    }

    // ==========================================
    // 3. HALAMAN KHUSUS TRANSAKSI (BARANG)
    // ==========================================
    public function transactions()
    {
        // PERBAIKAN: Gunakan outlet_id
        $outletId = Auth::user()->outlet_id;

        // Ambil transaksi HARI INI beserta detail barangnya (PER OUTLET)
        $todaysTransactions = Transaction::with(['details.product', 'user']) // Eager load user juga
            ->where('outlet_id', $outletId)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total item terjual hari ini
        $totalItemsSold = 0;
        foreach ($todaysTransactions as $trx) {
            $totalItemsSold += $trx->details->sum('quantity');
        }

        return view('user.page.profile-transactions', compact('todaysTransactions', 'totalItemsSold'));
    }

    // ==========================================
    // 4. FITUR EDIT PROFIL
    // ==========================================
    public function editProfile()
    {
        return view('user.page.profile-edit');
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'     => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email        = $request->email;

        $user->save();

        return redirect()->route('kasir.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function storeReport(Request $request)
    {
        $outletId = Auth::user()->outlet_id;

        // 1. Tangkap Filter Bulan (Format: YYYY-MM)
        // Jika tidak ada filter, gunakan bulan saat ini
        $filterDate = $request->input('filter_month')
            ? Carbon::parse($request->input('filter_month'))
            : Carbon::now();

        // TAMBAHAN FIX: Pastikan variabel ini ada untuk view
        $isCurrentMonth = $filterDate->isCurrentMonth(); 

        $currentMonthName = $filterDate->translatedFormat('F Y');

        // 2. Hitung Pendapatan (Tetap Realtime untuk Hari & Minggu, tapi Bulan ikuti filter)

        // a. Hari Ini (Tetap Realtime)
        $incomeToday = Transaction::where('outlet_id', $outletId)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_harga');

        // b. Minggu Ini (Tetap Realtime)
        $incomeThisWeek = Transaction::where('outlet_id', $outletId)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_harga');

        // c. Bulan Terpilih (Sesuai Filter)
        $incomeSelectedMonth = Transaction::where('outlet_id', $outletId)
            ->whereMonth('created_at', $filterDate->month)
            ->whereYear('created_at', $filterDate->year)
            ->sum('total_harga');

        // 3. List Harian (Menampilkan data harian PADA BULAN TERPILIH)
        $dailyReports = Transaction::where('outlet_id', $outletId)
            ->whereMonth('created_at', $filterDate->month)
            ->whereYear('created_at', $filterDate->year)
            ->selectRaw('DATE(created_at) as date, SUM(total_harga) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('user.page.store-report', compact(
            'incomeToday',
            'incomeThisWeek',
            'incomeSelectedMonth', 
            'dailyReports',
            'filterDate',
            'currentMonthName',
            'isCurrentMonth'
        ));
    }

    // A. Detail Hari Ini
    public function reportToday()
    {
        $outletId = Auth::user()->outlet_id;
        $title = "Laporan Hari Ini";
        $dateLabel = Carbon::today()->translatedFormat('d F Y');

        $transactions = Transaction::with(['user', 'paymentMethod'])
            ->where('outlet_id', $outletId)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $transactions->sum('total_harga');

        // Kita gunakan view yang sama untuk periode, tapi datanya beda
        return view('user.page.store-report-period', compact('title', 'dateLabel', 'transactions', 'totalRevenue'));
    }

    // B. Detail Minggu Ini
    public function reportWeek()
    {
        $outletId = Auth::user()->outlet_id;
        $title = "Laporan Minggu Ini";
        $start = Carbon::now()->startOfWeek()->translatedFormat('d M');
        $end = Carbon::now()->endOfWeek()->translatedFormat('d M Y');
        $dateLabel = "$start - $end";

        $transactions = Transaction::with(['user', 'paymentMethod'])
            ->where('outlet_id', $outletId)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $transactions->sum('total_harga');

        return view('user.page.store-report-period', compact('title', 'dateLabel', 'transactions', 'totalRevenue'));
    }

    // C. Detail Bulan Ini
    public function reportMonth()
    {
        $outletId = Auth::user()->outlet_id;
        $title = "Laporan Bulan Ini";
        $dateLabel = Carbon::now()->translatedFormat('F Y');

        $transactions = Transaction::with(['user', 'paymentMethod'])
            ->where('outlet_id', $outletId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $transactions->sum('total_harga');

        return view('user.page.store-report-period', compact('title', 'dateLabel', 'transactions', 'totalRevenue'));
    }

    // D. Detail Performa (Rekap Harian - 30 Hari)
    public function reportPerformance()
    {
        $outletId = Auth::user()->outlet_id;

        // Ambil data 30 hari terakhir
        $dailyReports = Transaction::where('outlet_id', $outletId)
            ->where('created_at', '>=', Carbon::now()->subDays(30)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total_harga) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('user.page.store-report-performance', compact('dailyReports'));
    }

    // Resource methods (Placeholder)
    public function index()
    {
        return view('user.page.profile');
    }

    // Resource methods (Placeholder)
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
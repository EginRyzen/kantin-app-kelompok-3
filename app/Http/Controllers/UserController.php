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
        $userId = Auth::id();

        // Ringkasan Singkat untuk Dashboard
        $userIncomeToday = Transaction::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_harga');

        $userTxToday = Transaction::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('user.page.profile', compact('userIncomeToday', 'userTxToday'));
    }

    // ==========================================
    // 2. HALAMAN KHUSUS PENDAPATAN (UANG)
    // ==========================================
    public function income()
    {
        $userId = Auth::id();

        // A. Total Uang Hari Ini
        $todayRevenue = Transaction::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_harga');

        // B. Rekapan Bulanan (Fokus ke Uang)
        $monthlyRecap = Transaction::where('user_id', $userId)
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
        $userId = Auth::id();

        // Ambil transaksi HARI INI beserta detail barangnya
        $todaysTransactions = Transaction::with('details.product') // Eager load detail & produk
            ->where('user_id', $userId)
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
            'no_hp'        => 'nullable|string|max:20',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'     => 'nullable|min:8|confirmed',
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }
            $path = $request->file('foto')->store('fotos', 'public');
            $user->foto = $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email        = $request->email;
        $user->no_hp        = $request->no_hp;

        $user->save();

        return redirect()->route('kasir.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function storeReport(Request $request)
{
    $outletId = Auth::user()->outlet_id;

    // 1. Tangkap Filter Bulan (Format: YYYY-MM)
    $filterDate = $request->input('filter_month')
        ? Carbon::parse($request->input('filter_month'))
        : Carbon::now();

    // --- TAMBAHAN BARU: DEFINISIKAN LOGIKA isCurrentMonth ---
    // Cek apakah bulan yang difilter adalah bulan saat ini
    $isCurrentMonth = $filterDate->isCurrentMonth(); 

    $currentMonthName = $filterDate->translatedFormat('F Y');

    // 2. Hitung Pendapatan
    $incomeToday = Transaction::where('outlet_id', $outletId)
        ->whereDate('created_at', Carbon::today())
        ->sum('total_harga');

    $incomeThisWeek = Transaction::where('outlet_id', $outletId)
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->sum('total_harga');

    $incomeSelectedMonth = Transaction::where('outlet_id', $outletId)
        ->whereMonth('created_at', $filterDate->month)
        ->whereYear('created_at', $filterDate->year)
        ->sum('total_harga');

    // 3. List Harian
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
        'isCurrentMonth' // <--- JANGAN LUPA MASUKKAN KE SINI
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
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}

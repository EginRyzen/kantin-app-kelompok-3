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

    // Resource methods (Placeholder)
    public function index() { return view('user.page.profile'); }
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
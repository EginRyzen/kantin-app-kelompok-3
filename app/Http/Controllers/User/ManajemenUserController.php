<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManajemenUserController extends Controller
{
    /**
     * Menampilkan daftar user dalam satu outlet
     */
    public function index()
    {
        $currentUser = Auth::user();
        $outletId = $currentUser->outlet_id;

        // Cari Master User (User pertama yang dibuat di outlet ini)
        $masterUser = User::where('outlet_id', $outletId)
            ->orderBy('created_at', 'asc') // atau orderBy('id', 'asc')
            ->first();

        // Ambil semua user di outlet ini
        $users = User::where('outlet_id', $outletId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.page.manajemen-user.index', compact('users', 'masterUser'));
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        return view('user.page.manajemen-user.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:users,username',
            'email'        => 'required|email|max:255|unique:users,email',
            'password'     => 'required|min:8|confirmed',
        ]);

        User::create([
            'outlet_id'    => Auth::user()->outlet_id,
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'role'         => 'kasir', // <--- DEFAULT OTOMATIS KASIR
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('kasir.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        $currentUser = Auth::user();
        
        // Pastikan user yang diedit satu outlet
        $userToEdit = User::where('id', $id)
            ->where('outlet_id', $currentUser->outlet_id)
            ->firstOrFail();

        // LOGIKA PROTEKSI MASTER:
        // Cari Master User
        $masterUser = User::where('outlet_id', $currentUser->outlet_id)->orderBy('created_at', 'asc')->first();

        // Jika user yang ingin diedit adalah Master, DAN yang login BUKAN Master itu sendiri -> TOLAK
        if ($userToEdit->id === $masterUser->id && $currentUser->id !== $masterUser->id) {
            return redirect()->route('kasir.users.index')->with('error', 'Anda tidak memiliki akses untuk mengedit Master User.');
        }

        return view('user.page.manajemen-user.edit', compact('userToEdit'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $currentUser = Auth::user();
        $userToUpdate = User::where('id', $id)->where('outlet_id', $currentUser->outlet_id)->firstOrFail();
        $masterUser = User::where('outlet_id', $currentUser->outlet_id)->orderBy('created_at', 'asc')->first();

        // Proteksi Edit Master
        if ($userToUpdate->id === $masterUser->id && $currentUser->id !== $masterUser->id) {
            return redirect()->route('kasir.users.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:users,username,' . $id,
            'email'        => 'required|email|max:255|unique:users,email,' . $id,
            'password'     => 'nullable|min:8|confirmed',
        ]);

        $userToUpdate->nama_lengkap = $request->nama_lengkap;
        $userToUpdate->username     = $request->username;
        $userToUpdate->email        = $request->email;
        
        if ($request->filled('password')) {
            $userToUpdate->password = Hash::make($request->password);
        }

        // Role tidak diupdate dari form edit (tetap sesuai aslinya)

        $userToUpdate->save();

        return redirect()->route('kasir.users.index')->with('success', 'Data user diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
        $userToDelete = User::where('id', $id)->where('outlet_id', $currentUser->outlet_id)->firstOrFail();
        $masterUser = User::where('outlet_id', $currentUser->outlet_id)->orderBy('created_at', 'asc')->first();

        // 1. Tidak boleh menghapus diri sendiri
        if ($userToDelete->id === $currentUser->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // 2. Tidak boleh menghapus Master User
        if ($userToDelete->id === $masterUser->id) {
            return back()->with('error', 'Master User tidak dapat dihapus.');
        }

        $userToDelete->delete();

        return redirect()->route('kasir.users.index')->with('success', 'User berhasil dihapus.');
    }
}

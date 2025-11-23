<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;   //
use App\Models\Outlet; //
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan role 'kasir'.
     */
    public function index()
    {
        // Ambil user yang role-nya 'kasir', urutkan terbaru
        $users = User::where('role', 'kasir')->with('outlet')->latest()->paginate(10);
        return view('admin.page.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah kasir baru.
     */
    public function create()
    {
        // Kita butuh data outlet untuk dropdown
        $outlets = Outlet::where('is_active', 1)->get();
        return view('admin.page.users.create', compact('outlets'));
    }

    /**
     * Menyimpan kasir baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'outlet_id' => 'required|exists:outlets,id', // Validasi outlet harus ada
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'outlet_id' => $request->outlet_id,
            'role' => 'kasir', // Otomatis set sebagai kasir
        ]);

        return redirect()->route('admin.cashiers.index')->with('success', 'Kasir berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kasir.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $outlets = Outlet::where('is_active', 1)->get();
        return view('admin.page.users.edit', compact('user', 'outlets'));
    }

    /**
     * Mengupdate data kasir.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'outlet_id' => 'required|exists:outlets,id',
            'password' => 'nullable|string|min:6', // Password opsional saat edit
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'outlet_id' => $request->outlet_id,
        ];

        // Jika password diisi, update password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.cashiers.index')->with('success', 'Data kasir berhasil diperbarui.');
    }

    /**
     * Menghapus kasir.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.cashiers.index')->with('success', 'Kasir berhasil dihapus.');
    }
}
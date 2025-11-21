<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ==========================================
    // KHUSUS FITUR PROFIL KASIR
    // ==========================================

    /**
     * 1. Menampilkan Halaman Menu Profil
     * Route: kasir.profile.index
     */
    public function profile()
    {
        return view('user.page.profile');
    }

    /**
     * 2. Menampilkan Form Edit Profil
     * Route: kasir.profile.edit
     */
    public function editProfile()
    {
        return view('user.page.profile-edit');
    }

    /**
     * 3. Proses Update Data (Foto, Password, Biodata)
     * Route: kasir.profile.update
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id()); // Ambil user yang sedang login

        // A. Validasi Input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'        => 'nullable|string|max:20', // Pastikan nama kolom di database 'no_hp'
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'password'     => 'nullable|min:8|confirmed', // Cek input 'password' & 'password_confirmation'
        ]);

        // B. Update Foto (Jika User Upload Foto Baru)
        if ($request->hasFile('foto')) {
            // Hapus foto lama biar server gak penuh
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }
            
            // Simpan foto baru ke folder 'fotos'
            $path = $request->file('foto')->store('fotos', 'public');
            $user->foto = $path;
        }

        // C. Update Password (Hanya jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // D. Update Data Teks
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email        = $request->email;
        $user->no_hp        = $request->no_hp; 
        
        $user->save();

        // Redirect kembali ke halaman menu profil dengan pesan sukses
        return redirect()->route('kasir.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }


    // ==========================================
    // RESOURCE BAWAAN (ADMIN / STANDAR)
    // Biarkan kode di bawah ini ada agar tidak error 
    // jika route resource('users') masih dipanggil.
    // ==========================================

    public function index()
    {
        // Bisa dikosongkan atau diarahkan ke view lain
        return view('user.page.profile'); 
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
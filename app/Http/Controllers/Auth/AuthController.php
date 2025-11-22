<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            if ($user->role === 'kasir') {
                if ($user->outlet && $user->outlet->is_active) {
                    return redirect()->intended('/kasir/home');
                } else {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'username' => 'Outlet Anda tidak aktif. Silakan hubungi Administrator.',
                    ])->onlyInput('username');
                }
            }

            Auth::logout();
            return back()->withErrors([
                'username' => 'Peran Anda tidak dikenali.',
            ])->onlyInput('username');
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showRegisterStep1()
    {
        return view('register-step-1');
    }

    public function postRegisterStep1(Request $request)
    {
        $validated = $request->validate([
            'nama_outlet' => 'required|string|max:255|unique:outlets,nama_outlet',
            'alamat' => 'required|string|max:255',
        ], [
            'nama_outlet.unique' => 'Nama outlet ini sudah terdaftar.',
        ]);

        $request->session()->put('register_step_1', $validated);

        return redirect()->route('register.step2');
    }

    public function showRegisterStep2(Request $request)
    {
        if (!$request->session()->has('register_step_1')) {
            return redirect()->route('register.step1');
        }

        return view('register-step-2');
    }

    public function postRegisterStep2(Request $request)
    {
        // Cek lagi data step 1
        if (!$request->session()->has('register_step_1')) {
            return redirect()->route('register.step1');
        }

        // Validasi data user
        $validatedUser = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
        ], [
            'username.unique' => 'Username ini sudah digunakan.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        // Ambil data outlet dari session
        $outletData = $request->session()->get('register_step_1');

        try {
            DB::beginTransaction();

            // 1. Buat Outlet
            // Outlet akan otomatis 'is_active' = false (sesuai migration)
            $outlet = Outlet::create([
                'nama_outlet' => $outletData['nama_outlet'],
                'alamat' => $outletData['alamat'],
                'is_active' => true, 
            ]);

            // 2. Buat User (Kasir)
            $user = User::create([
                'nama_lengkap' => $validatedUser['nama_lengkap'],
                'username' => $validatedUser['username'],
                'email' => $validatedUser['email'],
                'password' => Hash::make($validatedUser['password']),
                'outlet_id' => $outlet->id,
                'role' => 'kasir', // Default 'kasir'
            ]);

            DB::commit();

            // Hapus data session setelah berhasil
            $request->session()->forget('register_step_1');

            // Redirect ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Outlet Anda sedang ditinjau. Silakan hubungi admin untuk aktivasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Tampilkan error jika gagal
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi. Error: ' . $e->getMessage()
            ])->withInput();
        }
    }
}

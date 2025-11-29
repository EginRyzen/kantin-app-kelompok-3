<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PaymentMethodController extends Controller
{
    /**
     * Menampilkan daftar metode pembayaran.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::where('outlet_id', Auth::user()->outlet_id)
            ->orderBy('is_active', 'desc') // Yang aktif di atas
            ->orderBy('nama_metode', 'asc')
            ->get();

        return view('user.page.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Menampilkan form tambah.
     */
    public function create()
    {
        return view('user.page.payment-methods.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $outletId = Auth::user()->outlet_id;

        $request->validate([
            'nama_metode' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama unik di outlet yang sama
                Rule::unique('payment_methods')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
            'is_active' => 'required|boolean',
        ], [
            'nama_metode.unique' => 'Metode pembayaran ini sudah ada.',
        ]);

        PaymentMethod::create([
            'outlet_id' => $outletId,
            'nama_metode' => $request->nama_metode,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('kasir.payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Keamanan: Pastikan milik outlet user yang sedang login
        if ($paymentMethod->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Akses ditolak.');
        }

        return view('user.page.payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if ($paymentMethod->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Akses ditolak.');
        }

        $outletId = Auth::user()->outlet_id;

        $request->validate([
            'nama_metode' => [
                'required',
                'string',
                'max:255',
                Rule::unique('payment_methods')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                })->ignore($paymentMethod->id),
            ],
            'is_active' => 'required|boolean',
        ], [
            'nama_metode.unique' => 'Metode pembayaran ini sudah digunakan.',
        ]);

        $paymentMethod->update([
            'nama_metode' => $request->nama_metode,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('kasir.payment-methods.index')
            ->with('success', 'Metode pembayaran diperbarui.');
    }

    /**
     * Hapus data.
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if ($paymentMethod->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Akses ditolak.');
        }

        // Opsional: Cek apakah sudah pernah dipakai transaksi
        if ($paymentMethod->transactions()->exists()) {
            return back()->with('error', 'Gagal hapus! Metode ini ada di riwayat transaksi.');
        }

        $paymentMethod->delete();

        return redirect()->route('kasir.payment-methods.index')
            ->with('success', 'Metode pembayaran dihapus.');
    }
}
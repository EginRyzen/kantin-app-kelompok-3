<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier.
     */
    public function index()
    {
        $suppliers = Supplier::where('outlet_id', Auth::user()->outlet_id)
            ->orderBy('nama_supplier', 'asc')
            ->get();

        return view('user.page.suppliers.index', compact('suppliers'));
    }

    /**
     * Menampilkan form tambah.
     */
    public function create()
    {
        return view('user.page.suppliers.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $outletId = Auth::user()->outlet_id;

        $request->validate([
            'nama_supplier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
            'no_telp' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ], [
            'nama_supplier.unique' => 'Nama supplier ini sudah ada di daftar Anda.',
        ]);

        try {
            Supplier::create([
                'outlet_id' => $outletId,
                'nama_supplier' => $request->nama_supplier,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
            ]);

            return redirect()->route('kasir.suppliers.index')
                ->with('success', 'Supplier berhasil ditambahkan.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withInput()->withErrors(['nama_supplier' => 'Supplier ini sudah terdaftar.']);
            }
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Supplier $supplier)
    {
        if ($supplier->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Akses ditolak.');
        }

        return view('user.page.suppliers.edit', compact('supplier'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if ($supplier->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Akses ditolak.');
        }

        $outletId = Auth::user()->outlet_id;

        $request->validate([
            'nama_supplier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                })->ignore($supplier->id),
            ],
            'no_telp' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ], [
            'nama_supplier.unique' => 'Nama supplier sudah digunakan.',
        ]);

        try {
            $supplier->update([
                'nama_supplier' => $request->nama_supplier,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
            ]);

            return redirect()->route('kasir.suppliers.index')
                ->with('success', 'Data supplier diperbarui.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withInput()->withErrors(['nama_supplier' => 'Nama supplier sudah ada.']);
            }
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data.
     */
    public function destroy(Supplier $supplier)
    {
        if ($supplier->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Akses ditolak.');
        }

        // Opsional: Cek jika supplier sedang dipakai oleh produk
        if ($supplier->products()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Supplier ini masih terhubung dengan beberapa produk.');
        }

        $supplier->delete();

        return redirect()->route('kasir.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
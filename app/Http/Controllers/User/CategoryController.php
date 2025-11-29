<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        $categories = Category::where('outlet_id', Auth::user()->outlet_id)
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('user.page.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('user.page.categories.create');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $outletId = Auth::user()->outlet_id;

        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori ini sudah ada di outlet Anda.',
        ]);

        try {
            // 2. Simpan ke Database
            Category::create([
                'outlet_id' => $outletId,
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('kasir.categories.index')
                ->with('success', 'Kategori berhasil ditambahkan.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withInput()->withErrors(['nama_kategori' => 'Terjadi kesalahan: Kategori ini sudah ada.']);
            }
            
            // Error lain
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit(Category $category)
    {
        if ($category->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        return view('user.page.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        $outletId = Auth::user()->outlet_id;

        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                })->ignore($category->id),
            ],
        ], [
            'nama_kategori.unique' => 'Nama kategori ini sudah digunakan.',
        ]);

        try {
            $category->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('kasir.categories.index')
                ->with('success', 'Kategori berhasil diperbarui.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withInput()->withErrors(['nama_kategori' => 'Kategori ini sudah ada.']);
            }
            
            return back()->withInput()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus kategori.
     */
    public function destroy(Category $category)
    {
        if ($category->outlet_id !== Auth::user()->outlet_id) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Kategori ini masih digunakan oleh beberapa produk.');
        }

        $category->delete();

        return redirect()->route('kasir.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
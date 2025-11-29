<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\StockMovement; // <--- JANGAN LUPA IMPORT INI

class TransactionController extends Controller
{
    public function process(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        // 2. Ambil Keranjang
        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return response()->json(['status' => 'error', 'message' => 'Keranjang kosong!']);
        }

        DB::beginTransaction();

        try {
            // 3. Hitung Total Harga Belanja
            $totalHarga = 0;
            foreach ($cart as $details) {
                $totalHarga += $details['price'] * $details['qty'];
            }

            // 4. CEK APAKAH UANG CUKUP?
            if ($request->total_bayar < $totalHarga) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Uang pembayaran kurang! Total: Rp ' . number_format($totalHarga)
                ]);
            }

            // 5. Hitung Kembalian
            $kembalian = $request->total_bayar - $totalHarga;

            // 6. Buat Customer (First or Create)
            $customer = Customer::firstOrCreate(
                ['nama_pelanggan' => $request->nama_pelanggan]
            );

            // 7. Simpan Transaksi Header
            $transaction = Transaction::create([
                'outlet_id' => Auth::user()->outlet_id,
                'user_id' => Auth::id(),
                'customer_id' => $customer->id,
                'payment_method_id' => $request->payment_method_id,
                'nomor_invoice' => 'INV-' . time() . rand(100, 999),
                'total_harga' => $totalHarga,
                'total_bayar' => $request->total_bayar,
                'kembalian' => $kembalian,
            ]);

            // 8. Simpan Detail & Update Stok & Catat Movement
            foreach ($cart as $id => $details) {
                // Lock for Update untuk mencegah race condition saat transaksi bersamaan
                $product = Product::lockForUpdate()->find($id);

                // --- LOGIC PERBAIKAN STOK UNLIMITED ---
                // Hanya cek dan kurangi stok JIKA stok TIDAK NULL
                if (!is_null($product->stok)) {
                    // Cek ketersediaan
                    if ($product->stok < $details['qty']) {
                        DB::rollBack();
                        return response()->json(['status' => 'error', 'message' => 'Stok ' . $product->nama_produk . ' tidak mencukupi!']);
                    }
                    // Kurangi stok
                    $product->decrement('stok', $details['qty']);
                }
                // Jika NULL (Unlimited), lewati pengecekan dan pengurangan
                // ---------------------------------------

                // Simpan Detail Transaksi
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'quantity' => $details['qty'],
                    'harga_satuan' => $details['price'],
                    'subtotal_harga' => $details['price'] * $details['qty'],
                ]);

                // --- LOGIC BARU: CATAT STOCK MOVEMENT ---
                // Kita tetap mencatat penjualan di history meskipun barangnya unlimited
                StockMovement::create([
                    'product_id' => $id,
                    'user_id' => Auth::id(), // Kasir yang memproses
                    'tipe_gerakan' => 'penjualan',
                    'jumlah' => $details['qty'], // Jumlah keluar
                    'catatan' => 'Transaksi Penjualan #' . $transaction->nomor_invoice,
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi Berhasil!',
                'invoice' => $transaction->nomor_invoice,
                'kembalian' => $kembalian
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function printStruk($invoice)
    {
        $transaction = Transaction::with(['details.product', 'customer', 'user', 'outlet'])
                        ->where('nomor_invoice', $invoice)
                        ->firstOrFail();

        return view('user.page.struk', compact('transaction'));
    }
}
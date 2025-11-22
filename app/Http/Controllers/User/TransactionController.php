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

class TransactionController extends Controller
{
    public function process(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'total_bayar' => 'required|numeric|min:0', // VALIDASI BARU
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
                'total_bayar' => $request->total_bayar, // SIMPAN INI
                'kembalian' => $kembalian,              // SIMPAN INI
            ]);

            // 8. Simpan Detail & Kurangi Stok (Sama seperti sebelumnya)
            foreach ($cart as $id => $details) {
                $product = Product::lockForUpdate()->find($id);

                if ($product->stok < $details['qty']) {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Stok ' . $product->nama_produk . ' habis!']);
                }

                $product->decrement('stok', $details['qty']);

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'quantity' => $details['qty'],
                    'harga_satuan' => $details['price'],
                    'subtotal_harga' => $details['price'] * $details['qty'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi Berhasil!',
                'invoice' => $transaction->nomor_invoice,
                'kembalian' => $kembalian // Kirim info kembalian ke frontend
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

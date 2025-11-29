<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('user.page.cart', compact('cart', 'paymentMethods'));
    }

    // Menambahkan item ke session
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        // Ambil data produk dari database untuk cek stok real-time
        $product = Product::find($id);

        // Cek stok tersedia
        $currentQtyInCart = isset($cart[$id]) ? $cart[$id]['qty'] : 0;
        $requestedQty = $currentQtyInCart + 1;

        // PERBAIKAN DI SINI:
        // Cek stok hanya jika stok TIDAK NULL (Bukan Unlimited)
        if (!is_null($product->stok) && $requestedQty > $product->stok) {
            return response()->json([
                'status' => 'error_stock',
                'message' => 'Stok produk tidak mencukupi! Sisa stok: ' . $product->stok
            ]);
        }

        // Jika produk sudah ada, tambah quantity
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            // Jika belum ada, masukkan data baru
            $cart[$id] = [
                "name" => $request->name,
                "price" => $request->price,
                "image" => $request->image,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);

        $totalQty = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan!',
            'total_qty' => $totalQty
        ]);
    }

    // Update quantity (Tambah/Kurang)
    public function updateCart(Request $request)
    {
        if ($request->id && $request->qty) {
            $cart = session()->get('cart');
            $product = Product::find($request->id);

            // PERBAIKAN DI SINI JUGA:
            // Cek Stok sebelum update (Hanya jika bukan unlimited)
            if (!is_null($product->stok) && $request->qty > $product->stok) {
                return response()->json([
                    'status' => 'error_stock',
                    'message' => 'Maksimal stok tersedia hanya ' . $product->stok
                ]);
            }

            $cart[$request->id]['qty'] = $request->qty;
            session()->put('cart', $cart);

            $itemSubtotal = $cart[$request->id]['price'] * $cart[$request->id]['qty'];

            $grandTotal = 0;
            foreach ($cart as $item) {
                $grandTotal += $item['price'] * $item['qty'];
            }

            return response()->json([
                'status' => 'success',
                'item_subtotal' => $itemSubtotal,
                'grand_total' => $grandTotal
            ]);
        }
    }

    // Hapus item per baris
    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            // Hitung grand total baru
            $grandTotal = 0;
            foreach ($cart as $item) {
                $grandTotal += $item['price'] * $item['qty'];
            }

            return response()->json(['status' => 'success', 'grand_total' => $grandTotal]);
        }
    }

    // Hapus semua
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('kasir.cart.index');
    }
}
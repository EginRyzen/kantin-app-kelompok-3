<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Kita hanya mereturn view, data produk diambil dari localStorage via JS
        return view('user.page.cart');
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function index()
    {
        $outletId = Auth::user()->outlet_id;

        $movements = StockMovement::with(['product.category', 'product.supplier', 'product.outlet', 'user'])
            ->whereHas('product', function($query) use ($outletId) {
                $query->where('outlet_id', $outletId);
            })
            ->latest()
            ->paginate(15);

        // PASTIKAN BARIS DI BAWAH INI SESUAI DENGAN FOLDER KAMU
        return view('user.page.stock-movements.index', compact('movements'));
    }
}
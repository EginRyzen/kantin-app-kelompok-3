<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalOutlets = Outlet::count();
        $activeOutlets = Outlet::where('is_active', 1)->count(); //
        $inactiveOutlets = Outlet::where('is_active', 0)->count(); //

        $salesData = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_harga) as total_sales') //
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $salesData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });
        
        $chartData = $salesData->pluck('total_sales');

        return view('admin.page.dashboard', compact(
            'totalOutlets',
            'activeOutlets',
            'inactiveOutlets',
            'chartLabels',
            'chartData'
        ));
    }
}
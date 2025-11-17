<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlet;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlets = Outlet::latest()->paginate(10); 

        return view('admin.page.outlets.index', compact('outlets'));
    }

    public function toggleStatus(Outlet $outlet)
    {
        $outlet->is_active = !$outlet->is_active; 
        $outlet->save();

        return redirect()->route('admin.outlets.index')->with('success', 'Status outlet berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show(Outlet $outlet)
    {
        $outlet->load('cashiers');

        return view('admin.page.outlets.show', compact('outlet'));
    }
    
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'outlet_id',
        'category_id',
        'supplier_id',
        'nama_produk',
        'deskripsi',
        'harga_jual',
        'stok',
        'diskon-tipe',
        'diskon_nilai',
        'status',
    ];
}
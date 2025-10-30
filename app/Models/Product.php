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
        'image',
        'kode_produk',
        'deskripsi',
        'harga_jual',
        'stok',
        'diskon_tipe',
        'diskon_nilai',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
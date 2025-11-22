<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'harga_satuan',
        'subtotal_harga',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    // Relasi ke Produk (PENTING: agar details.product tidak error)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
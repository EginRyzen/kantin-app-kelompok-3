<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'outlet_id',
        'user_id',
        'customer_id',
        'payment_method_id',
        'nomor_invoice',
        'total_harga',
        'total_bayar',
        'kembalian',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    // RELASI 2: Transaksi milik satu customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // RELASI 3: Transaksi dibuat oleh satu user (kasir)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELASI 4: Transaksi menggunakan satu metode pembayaran
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    
    // RELASI 5: Transaksi milik outlet tertentu
    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }
}
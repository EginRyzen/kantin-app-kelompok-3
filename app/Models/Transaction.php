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
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';

    protected $fillable = [
        'product_id',
        'user_id',
        'tipe_gerakan',
        'jumlah',
        'catatan',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke User (Siapa yang melakukan input/pengurangan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
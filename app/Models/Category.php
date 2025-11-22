<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'outlet_id',
        'nama_kategori',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlets';

    protected $fillable = [
        'nama_outlet',
        'alamat',
        'is_active',
    ];

    /**
     * Mendefinisikan relasi ke semua user (termasuk admin/kasir)
     * yang terhubung dengan outlet ini.
     * Relasi ini melihat ke tabel 'users'
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Mendefinisikan relasi HANYA ke user yang berperan sebagai kasir.
     * Ini akan digunakan di halaman detail outlet Anda.
     * Relasi ini melihat ke tabel 'users'
     */
    public function cashiers()
    {

        return $this->hasMany(User::class)->where('role', 'kasir');
    }
}
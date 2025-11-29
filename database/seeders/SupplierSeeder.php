<?php

namespace Database\Seeders;

use App\Models\Supplier; // <-- 1. Import model
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Gunakan Model::create() untuk menambah data
        Supplier::create([
            'nama_supplier' => 'PT Indofood Sukses Makmur',
            'alamat' => 'Jl. Sudirman Kav. 76-78, Jakarta',
            'outlet_id' => 1,
            'no_telp' => '02157958822',
        ]);

        Supplier::create([
            'nama_supplier' => 'PT Wings Food',
            'alamat' => 'Jl. Tipar Cakung, Jakarta Timur',
            'outlet_id' => 1,
            'no_telp' => '0214602622',
        ]);

        Supplier::create([
            'nama_supplier' => 'Pemasok Sayur Segar Lokal',
            'alamat' => 'Pasar Induk Madiun', // Sesuaikan dengan lokasi
            'outlet_id' => 2,
            'no_telp' => '08123456789',
        ]);

        Supplier::create([
            'nama_supplier' => 'Agen Telur Pak Budi',
            'alamat' => 'Jl. Merpati No. 10',
            'outlet_id' => 1,
            'no_telp' => '085777888999',
        ]);
    }
}


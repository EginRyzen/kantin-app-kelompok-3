<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Outlet::create([
            'nama_outlet' => 'Kantin Pusat',
            'alamat' => 'Jl. Raya Kampus No. 1',
            'is_active' => true,
        ]);

        Outlet::create([
            'nama_outlet' => 'Kantin Asrama',
            'alamat' => 'Jl. Asrama No. 10',
            'is_active' => true,
        ]);
    }
}
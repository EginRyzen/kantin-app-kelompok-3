<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outletPusat = Outlet::where('nama_outlet', 'Kantin Pusat')->first();
        $outletAsrama = Outlet::where('nama_outlet', 'Kantin Asrama')->first();

        if ($outletPusat) {
            Category::create([
                'outlet_id' => $outletPusat->id,
                'nama_kategori' => 'Makanan Berat',
            ]);

            Category::create([
                'outlet_id' => $outletPusat->id,
                'nama_kategori' => 'Minuman Dingin',
            ]);
            Category::create([
                'outlet_id' => $outletPusat->id,
                'nama_kategori' => 'Snack',
            ]);
        }

        if ($outletAsrama) {
            Category::create([
                'outlet_id' => $outletAsrama->id,
                'nama_kategori' => 'Makanan Ringan',
            ]);

            Category::create([
                'outlet_id' => $outletAsrama->id,
                'nama_kategori' => 'Minuman Hangat',
            ]);
        }
    }
}

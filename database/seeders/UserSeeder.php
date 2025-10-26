<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@kantin.app',
            'password' => 'password123',
            'role' => 'admin',
            'outlet_id' => null,
            'email_verified_at' => now(),
        ]);


        User::create([
            'nama_lengkap' => 'Kasir Kantin Pusat',
            'username' => 'kasir_pusat',
            'email' => 'kasirpusat@kantin.app',
            'password' => 'password123',
            'role' => 'kasir',
            'outlet_id' => 1,
            'email_verified_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ✅ tambahkan ini
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus data sebelumnya
        User::truncate();

        // Tambah user admin dan kasir
        User::create([
            'name' => 'Admin',
            'email' => 'admin@bagstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@bagstore.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir'
        ]);

        // Jika ada seeder lain (misal ProductSeeder), bisa ditambahkan:
        // $this->call(ProductSeeder::class);
    }
}

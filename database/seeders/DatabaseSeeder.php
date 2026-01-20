<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
// ...
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@skillconnect.id',
            'password' => bcrypt('password123'), // Ganti password
            'role' => 'admin', // Kuncinya di sini
        ]);

        // Buat Akun User Biasa (Opsional untuk tes)
        User::create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@skillconnect.id',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);
    }
}

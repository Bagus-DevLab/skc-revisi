<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // ...
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@skillconnect.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@skillconnect.id'],
            [
                'name' => 'Siswa Teladan',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        $this->call(CourseSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Web Development Fullstack',
                'category' => 'Programming',
                'price' => 500000, // C1 (Lebih Murah = Skor Tinggi)
                'rating' => 4.8,    // C2 (Tinggi = Bagus)
                'students_count' => 850, // C3 (Banyak = Populer)
                'duration' => 12,   // C4 (Minggu)
                'difficulty_level' => 3, // C5 (Menengah)
                'description' => 'Belajar HTML, CSS, JS, dan Laravel dari nol.',
                'image' => 'courses/web-dev.jpg'
            ],
            [
                'title' => 'Digital Marketing Masterclass',
                'category' => 'Marketing',
                'price' => 350000, 
                'rating' => 4.5,
                'students_count' => 1200,
                'duration' => 8,
                'difficulty_level' => 2, // Lebih Mudah
                'description' => 'Kuasai FB Ads, Google Ads, dan SEO.',
                'image' => 'courses/digital-marketing.jpg'
            ],
            [
                'title' => 'UI/UX Design for Beginner',
                'category' => 'Design',
                'price' => 750000,
                'rating' => 4.9,
                'students_count' => 500,
                'duration' => 10,
                'difficulty_level' => 3,
                'description' => 'Desain aplikasi cantik dengan Figma.',
                'image' => 'courses/uiux.jpg'
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}

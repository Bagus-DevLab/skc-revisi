<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class LandingController extends Controller
{
 

public function index()
{
    $courses = Course::all();
    $categories = Course::distinct()->pluck('category');
    // 1. Ambil nilai MIN dan MAX untuk normalisasi
    $minPrice = Course::min('price') ?: 1;
    $maxRating = Course::max('rating') ?: 1;
    $maxStudents = Course::max('students_count') ?: 1;
    $maxDuration = Course::max('duration') ?: 1;
    $minDifficulty = Course::min('difficulty_level') ?: 1;

    // 2. Tentukan Bobot dari hasil AHP Excel kamu
    $weights = [
        'price'      => 0.515, // C1 (Cost: Semakin murah semakin bagus)
        'rating'     => 0.222, // C2 (Benefit)
        'students'   => 0.129, // C3 (Benefit)
        'duration'   => 0.074, // C4 (Benefit)
        'difficulty' => 0.039  // C5 (Cost: Semakin rendah level semakin bagus)
    ];

    // 3. Hitung Skor untuk setiap kursus
    $courseScores = $courses->map(function ($course) use ($minPrice, $maxRating, $maxStudents, $maxDuration, $minDifficulty, $weights) {
        
        // Normalisasi (Scale 0-1)
        // Cost: min / nilai
        $nPrice = $minPrice / ($course->price ?: 1);
        $nDifficulty = $minDifficulty / ($course->difficulty_level ?: 1);
        
        // Benefit: nilai / max
        $nRating = ($course->rating ?: 0) / $maxRating;
        $nStudents = ($course->students_count ?: 0) / $maxStudents;
        $nDuration = ($course->duration ?: 0) / $maxDuration;

        // Hitung Skor Akhir (Nilai x Bobot)
        $score = ($nPrice * $weights['price']) +
                 ($nRating * $weights['rating']) +
                 ($nStudents * $weights['students']) +
                 ($nDuration * $weights['duration']) +
                 ($nDifficulty * $weights['difficulty']);

        $course->ai_score = $score;
        return $course;
    });

    // 4. Urutkan berdasarkan skor tertinggi dan ambil yang terbaik
    $recommendedCourse = $courseScores->sortByDesc('ai_score')->first();

    return view('landing', compact('courses', 'recommendedCourse'));
}
}

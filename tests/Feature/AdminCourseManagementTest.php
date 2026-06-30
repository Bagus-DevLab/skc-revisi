<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCourseManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_course_from_web_form(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
            'title' => 'Laravel Fundamental',
            'category' => 'Web Development',
            'price' => 150000,
            'duration' => 12,
            'description' => 'Belajar Laravel dari dasar sampai membuat aplikasi sederhana.',
            'image' => UploadedFile::fake()->image('laravel.jpg', 800, 450),
            'rating' => 4.8,
            'students_count' => 120,
            'difficulty_level' => 2,
        ]);

        $response->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'title' => 'Laravel Fundamental',
            'category' => 'Web Development',
            'difficulty_level' => 2,
        ]);

        $course = Course::where('title', 'Laravel Fundamental')->firstOrFail();

        Storage::disk('public')->assertExists($course->image);
    }
}

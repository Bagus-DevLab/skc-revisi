<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_stats_use_successful_payments_and_course_image()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create([
            'difficulty_level' => '1',
            'image' => 'courses/example.jpg',
            'price' => 150000,
        ]);

        $user->courses()->attach($course->id, [
            'progress' => 30,
            'status' => 'active',
            'last_accessed_at' => now(),
        ]);

        Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => 150000,
            'status' => 'success',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/dashboard-stats');

        $response->assertOk()
            ->assertJsonPath('data.stats.total_investment', 150000)
            ->assertJsonPath('data.recent_courses.0.image', 'courses/example.jpg')
            ->assertJsonPath('data.recent_courses.0.image_url', asset('storage/courses/example.jpg'))
            ->assertJsonPath('data.last_course.image', 'courses/example.jpg')
            ->assertJsonPath('data.last_course.image_url', asset('storage/courses/example.jpg'));
    }
}

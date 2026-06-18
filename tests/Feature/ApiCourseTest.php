<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiCourseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_get_public_course_list()
    {
        Course::factory()->count(3)->create(['difficulty_level' => '1']);

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_single_course_details()
    {
        $course = Course::factory()->create(['difficulty_level' => '1']);
        Lesson::factory()->count(2)->create(['course_id' => $course->id]); // Assuming LessonFactory exists

        $response = $this->getJson('/api/courses/'.$course->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $course->id)
            ->assertJsonPath('data.title', $course->title)
            ->assertJsonPath('data.lesson_count', 2)
            ->assertJsonMissingPath('data.lessons');
    }

    public function test_authenticated_user_can_get_my_courses()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $user->courses()->attach($course->id, ['progress' => 50, 'status' => 'active']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-courses');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $course->id, 'title' => $course->title])
            ->assertJsonCount(1, 'data');
    }

    public function test_authenticated_user_can_get_my_certificates()
    {
        $user = User::factory()->create();
        $course1 = Course::factory()->create(['difficulty_level' => '1']);
        $course2 = Course::factory()->create(['difficulty_level' => '1']);
        $user->courses()->attach($course1->id, ['status' => 'finished']);
        $user->courses()->attach($course2->id, ['status' => 'active']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-certificates');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $course1->id])
            ->assertJsonMissing(['id' => $course2->id])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.certificate_url', fn ($url) => is_string($url) && str_contains($url, '/download-certificate/'.$course1->id.'/signed/'.$user->id));

        $this->get($response->json('data.0.certificate_url'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_authenticated_user_can_get_course_lessons()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $user->courses()->attach($course->id); // Enroll user in the course
        Lesson::factory()->count(3)->create(['course_id' => $course->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/courses/'.$course->id.'/lessons');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_unauthorized_user_cannot_get_course_lessons()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        Lesson::factory()->count(3)->create(['course_id' => $course->id]);

        // User not enrolled in the course
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/courses/'.$course->id.'/lessons');

        $response->assertStatus(403); // Or 404 depending on implementation
    }

    public function test_can_complete_lesson()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $user->courses()->attach($course->id, ['progress' => 90, 'status' => 'active']);
        $lesson = Lesson::factory()->create(['course_id' => $course->id]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/lessons/'.$lesson->id.'/complete');

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Progress berhasil diupdate')
            ->assertJsonPath('data.progress', 100)
            ->assertJsonPath('data.status', 'finished')
            ->assertJsonPath('data.is_completed', true)
            ->assertJsonPath('data.already_completed', false);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 100,
            'status' => 'finished',
        ]);
    }

    public function test_completing_same_lesson_twice_is_idempotent()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $user->courses()->attach($course->id, ['progress' => 0, 'status' => 'active']);
        $lesson = Lesson::factory()->create(['course_id' => $course->id]);
        Lesson::factory()->create(['course_id' => $course->id]);

        Sanctum::actingAs($user);

        $this->postJson('/api/lessons/'.$lesson->id.'/complete')
            ->assertOk()
            ->assertJsonPath('data.progress', 50)
            ->assertJsonPath('data.already_completed', false);

        $this->postJson('/api/lessons/'.$lesson->id.'/complete')
            ->assertOk()
            ->assertJsonPath('data.progress', 50)
            ->assertJsonPath('data.already_completed', true);
    }

    public function test_can_get_course_recommendations()
    {
        Course::factory()->create([
            'category' => 'Programming',
            'price' => 100000,
            'rating' => 4.5,
            'difficulty_level' => '1',
        ]);

        $response = $this->getJson('/api/recommendations?category=Programming&pref_price=5&pref_rating=3');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.category', 'Programming')
            ->assertJsonStructure(['data' => [['match_score', 'image_url', 'lesson_count']]]);
    }
}

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
        Course::factory()->count(3)->create();

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_course_details()
    {
        $course = Course::factory()->create();
        Lesson::factory()->count(2)->create(['course_id' => $course->id]); // Assuming LessonFactory exists

        $response = $this->getJson('/api/courses/' . $course->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $course->id, 'title' => $course->title])
                 ->assertJsonCount(2, 'lessons');
    }

    public function test_authenticated_user_can_get_my_courses()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->courses()->attach($course->id, ['progress' => 50, 'status' => 'active']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-courses');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $course->id, 'title' => $course->title])
                 ->assertJsonCount(1);
    }

    public function test_authenticated_user_can_get_my_certificates()
    {
        $user = User::factory()->create();
        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();
        $user->courses()->attach($course1->id, ['status' => 'finished']);
        $user->courses()->attach($course2->id, ['status' => 'active']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/my-certificates');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $course1->id])
                 ->assertJsonMissing(['id' => $course2->id])
                 ->assertJsonCount(1);
    }

    public function test_authenticated_user_can_get_course_lessons()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->courses()->attach($course->id); // Enroll user in the course
        Lesson::factory()->count(3)->create(['course_id' => $course->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/courses/' . $course->id . '/lessons');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_unauthorized_user_cannot_get_course_lessons()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        Lesson::factory()->count(3)->create(['course_id' => $course->id]);

        // User not enrolled in the course
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/courses/' . $course->id . '/lessons');

        $response->assertStatus(403); // Or 404 depending on implementation
    }

    public function test_can_complete_lesson()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->courses()->attach($course->id);
        $lesson = Lesson::factory()->create(['course_id' => $course->id]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/lessons/' . $lesson->id . '/complete');

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Lesson marked as complete (logic to be implemented).']);
    }
}

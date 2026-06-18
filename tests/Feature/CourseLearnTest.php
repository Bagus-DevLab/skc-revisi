<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseLearnTest extends TestCase
{
    use RefreshDatabase;

    public function test_finished_course_shows_certificate_link_instead_of_complete_button()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);

        $user->courses()->attach($course->id, [
            'progress' => 100,
            'status' => 'finished',
        ]);

        $response = $this->actingAs($user)->get(route('course.learn', $course));

        $response->assertOk()
            ->assertSee('Lihat Sertifikat')
            ->assertSee(route('certificate.download', $course->id))
            ->assertDontSee('Tandai Selesai &amp; Lanjut', false);
    }

    public function test_active_course_can_be_marked_complete_from_relative_post_form()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);

        $user->courses()->attach($course->id, [
            'progress' => 0,
            'status' => 'active',
        ]);

        $this->actingAs($user)
            ->get(route('course.learn', $course))
            ->assertOk()
            ->assertSee('action="/course/'.$course->id.'/complete-lesson"', false);

        $this->actingAs($user)
            ->post(route('course.complete-lesson', $course))
            ->assertRedirect(route('course.learn', $course, absolute: false));

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 10,
            'status' => 'active',
        ]);
    }
}

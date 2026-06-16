<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_all_courses_catalog()
    {
        $user = User::factory()->create();
        $ownedCourse = Course::factory()->create([
            'title' => 'Owned Laravel Course',
            'difficulty_level' => '1',
        ]);
        $availableCourse = Course::factory()->create([
            'title' => 'Available Design Course',
            'difficulty_level' => '1',
        ]);

        $user->courses()->attach($ownedCourse->id, [
            'progress' => 20,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('courses.index'));

        $response->assertOk()
            ->assertSee('Owned Laravel Course')
            ->assertSee('Available Design Course')
            ->assertSee('Dimiliki')
            ->assertSee(route('course.learn', $ownedCourse->id))
            ->assertSee(route('course.checkout', $availableCourse->id));
    }

    public function test_guest_is_redirected_from_courses_catalog()
    {
        $this->get(route('courses.index'))->assertRedirect(route('login'));
    }
}

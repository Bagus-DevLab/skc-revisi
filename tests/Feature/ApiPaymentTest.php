<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiPaymentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_authenticated_user_can_get_payment_history()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => 'Pemula']);
        Payment::factory()->count(5)->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/payment-history');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data'); // Assuming paginated response with 'data' key
    }

    public function test_unauthenticated_user_cannot_get_payment_history()
    {
        $response = $this->getJson('/api/payment-history');

        $response->assertStatus(401);
    }
}

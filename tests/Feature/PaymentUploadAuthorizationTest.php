<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentUploadAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_open_another_users_payment_upload_page()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $payment = Payment::factory()->create([
            'user_id' => $owner->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        $this->actingAs($otherUser)
            ->get(route('payment.upload', $payment->id))
            ->assertNotFound();
    }
}

<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPaymentApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_approving_payment_twice_does_not_duplicate_enrollment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.payments.approve', $payment->id))
            ->assertRedirect(route('admin.payments.index'));

        $this->actingAs($admin)
            ->post(route('admin.payments.approve', $payment->id))
            ->assertRedirect(route('admin.payments.index'));

        $this->assertDatabaseCount('enrollments', 1);
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
        ]);
    }
}

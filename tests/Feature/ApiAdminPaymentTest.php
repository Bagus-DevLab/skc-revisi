<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiAdminPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_api_rejects_payment_with_reason()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $course = Course::factory()->create(['difficulty_level' => '1']);
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        Sanctum::actingAs($admin);

        $this->postJson('/api/admin/payments/'.$payment->id.'/reject', [
            'rejection_reason' => 'Bukti pembayaran tidak jelas.',
        ])->assertOk();

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'rejected',
            'rejection_reason' => 'Bukti pembayaran tidak jelas.',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentHistoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_authenticated_user_can_view_payment_history()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('payment-history'));

        $response->assertStatus(200);
        $response->assertViewIs('payment-history');
    }

    public function test_payment_history_displays_payments()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(); // Assuming a CourseFactory exists
        
        $payment1 = Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'success',
            'amount' => 100000,
        ]);
        $payment2 = Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'amount' => 50000,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('payment-history'));

        $response->assertStatus(200);
        $response->assertSee('#INV-' . str_pad($payment1->id, 6, '0', STR_PAD_LEFT));
        $response->assertSee($course->title);
        $response->assertSee('Lunas');
        $response->assertSee('Menunggu');
    }

    public function test_rejected_payment_displays_rejection_reason()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'rejected',
            'rejection_reason' => 'Bukti pembayaran tidak jelas.',
            'amount' => 75000,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('payment-history'));

        $response->assertStatus(200);
        $response->assertSee('Gagal');
        $response->assertSee('Bukti pembayaran tidak jelas.');
    }

    public function test_rejected_payment_without_reason_displays_default_message()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'rejected',
            'rejection_reason' => null, // or ''
            'amount' => 75000,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('payment-history'));

        $response->assertStatus(200);
        $response->assertSee('Gagal');
        $response->assertSee('Tidak ada alasan penolakan');
    }
}

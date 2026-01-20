<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'payment_method' => $this->faker->randomElement(['BCA', 'Mandiri', 'Gopay']),
            'amount' => $this->faker->numberBetween(10000, 1000000),
            'status' => $this->faker->randomElement(['pending', 'success', 'rejected']),
            'proof_of_payment' => $this->faker->boolean(50) ? 'proofs/' . $this->faker->uuid() . '.jpg' : null,
            'rejection_reason' => $this->faker->boolean(20) ? $this->faker->sentence() : null,
        ];
    }
}

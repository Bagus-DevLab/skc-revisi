<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'category' => $this->faker->word(),
            'price' => $this->faker->numberBetween(50000, 500000),
            'duration' => $this->faker->numberBetween(1, 10) . ' hours',
            'description' => $this->faker->paragraph(),
            'image' => 'courses/' . $this->faker->uuid() . '.jpg',
            'rating' => $this->faker->randomFloat(1, 3, 5),
            'students_count' => $this->faker->numberBetween(10, 1000),
            'difficulty_level' => $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'video_url' => 'https://www.youtube.com/watch?v=' . $this->faker->unique()->lexify('?????????'),
            'content' => $this->faker->randomHtml(2, 3),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}

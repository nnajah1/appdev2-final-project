<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class likeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'user_name' => $this->faker->name(),
            'post_id' => function () {
                return \App\Models\Post::factory()->create()->id;
            },
            'post_user_name' => $this->faker->name(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

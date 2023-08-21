<?php

namespace Database\Factories;

use App\Models\Blogpost;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->sentence,
            'blogpost_id' => Blogpost::inRandomOrder()->first(),
            'user_id' => 1
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->sentence(),
            'music' => $this->faker->boolean(70) ? [  // 70% chance de ter música
                'nameMusic' => $this->faker->sentence(2),
                'nameArtist' => $this->faker->name(),
                'image' => $this->faker->imageUrl(640, 480, 'music', true),
                'colorCard' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            ] : null,
            'user_id' => User::factory(),
        ];
    }
}

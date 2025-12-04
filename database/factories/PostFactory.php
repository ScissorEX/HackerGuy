<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(3, true),
            // `slug` is generated in the model's creating boot method
            'user_id' => User::factory(),
            'published_at' => fake()->boolean(75) ? now()->subDays(fake()->numberBetween(0, 30)) : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'content' => fake()->sentences(4, true),
            'user_id' => User::factory(),
            'published_at' => fake()->boolean(60) ? now()->subDays(fake()->numberBetween(0, 30)) : null,
        ];
    }
}

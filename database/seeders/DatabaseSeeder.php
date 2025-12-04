<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        
        // Create 20 users
        $users = User::factory(20)->create();

        // Give each user 2 posts
        foreach ($users as $user) {
            Post::factory(2)->create(['user_id' => $user->id]);
        }

        // Gather all post ids to attach comments to
        $postIds = Post::pluck('id')->toArray();

        // For each user create 40 comments, each pointing to a random post
        foreach ($users as $user) {
            for ($i = 0; $i < 40; $i++) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $postIds[array_rand($postIds)],
                ]);
            }
        }
        User::factory()->create([
            'name' => 'mcdgonad',
            'email' => 'maxencedinel@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('megadoodoo888'),
            'remember_token' => Str::random(10),
        ]);
    }
}

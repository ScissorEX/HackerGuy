<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'General',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category, 'slug' => Str::slug($category)]);
        }

        $categoryId = Category::pluck('id')->toArray();
        
        $tags = ['Laravel', 'PHP', 'Web Development', 'Database', 'API', 'JavaScript', 'Vue.js', 'Design', 'Security'];
        foreach ($tags as $tag) {
            Tag::create(['name' => $tag, 'slug' => Str::slug($tag)]);
        }
        $tagIds = Tag::pluck('id')->toArray();
        
        $users = User::factory(20)->create();

        foreach ($users as $user) {
            $posts = Post::factory(2)->create(['user_id' => $user->id, 'category_id' => $categoryId[array_rand($categoryId)]]);
            foreach ($posts as $post) {
                $randomTagCount = rand(1, min(3, count($tagIds)));
                $shuffled = array_values($tagIds);
                shuffle($shuffled);
                $randomTags = array_slice($shuffled, 0, $randomTagCount);
                $post->tags()->sync($randomTags);
            }
        }

        // Gather all post ids to attach comments to
        $postIds = Post::pluck('id')->toArray();

        // For each user create 40 comments, each pointing to a random post
        foreach ($users as $user) {
            for ($i = 0; $i < 12; $i++) {
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

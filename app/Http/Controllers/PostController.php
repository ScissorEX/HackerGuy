<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::with('author')->where('published_at', '<=', now())->latest()->paginate(10);
        $posts = Post::with('author')->latest()->paginate(10);

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        if (auth('sanctum')->check()) {
            $post->load(['votes' => fn ($q) => $q->where('user_id', auth('sanctum')->id())]);
        }

        return response()->json($post->load('author', 'comments.author', 'comments.votes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:30',
        ]);

        $post = auth('sanctum')->user()->posts()->create($validated);

        $ids = [];
        if (isset($validated['tags'])) {
            foreach ($validated['tags'] as $thistag) {
                $tag = Tag::firstOrCreate(
                    ['name' => $thistag],
                    ['slug' => Str::slug($thistag)]
                );
                $ids[] = $tag->id;
            }

            $post->tags()->sync($ids);
        }

        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        if (auth('sanctum')->id() != $post->user_id) {
            return response()->json("unauthorized");
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $post->update($validated);

        if (isset($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }

            $post->tags()->sync($tagIds);
        }

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if (auth('sanctum')->id() != $post->user_id) {
            return response()->json("unauthorized");
        }

        $post->delete();
        return response()->json('comment deleted');
    }
}

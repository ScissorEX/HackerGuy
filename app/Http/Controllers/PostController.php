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
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $post = auth('sanctum')->user()->posts()->create($validated);

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

        return response()->json($post, 201);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
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
        $post->load('author:id,name', 'category:id,name', 'tags:id,name');

        $post->load(['comments' => fn ($q) => $q->with(['author:id,name'])->withcount([
            'votes as upvote' => fn ($q2) => $q2->where('vote', 1),
            'votes as downvote' => fn ($q2) => $q2->where('vote', -1),
        ])]);

        $post->loadCount([
            'votes as upvote' => fn ($q) => $q->where('vote', 1),
            'votes as downvote' => fn ($q) => $q->where('vote', -1),
        ]);

        if (auth('sanctum')->check()) {
            $id = auth('sanctum')->id();
            $post->uservote = $post->votes()->where('user_id', $id)->value('vote');

            foreach ($post->comments as $comment) {
                $comment->uservote = $comment->votes()->where('user_id', $id)->value('vote');
            }
        } else {
            $post->uservote = null;
            foreach ($post->comments as $comment) {
                $comment->uservote = null;
            }
        }

        PostResource::withoutWrapping();

        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
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
            return response()->json('unauthorized');
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
            return response()->json('unauthorized');
        }

        $post->delete();

        return response()->json('comment deleted');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');

        $posts = Post::where('title', 'LIKE', "%{$search}%")
            ->with('author')
            ->latest()
            ->limit(20)
            ->get();

        return response()->json($posts);
    }
}

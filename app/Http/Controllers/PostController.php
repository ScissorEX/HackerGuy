<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Jobs\EmbedPost;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $category = $request->query('category');
        $alltags = $request->query('tags');
        $tagsarray = $alltags ? array_map('trim', explode(',', $alltags)) : [];
        $posts = Post::with('author');

        if ($category) {
            $posts->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }
        if ($tagsarray) {
            foreach ($tagsarray as $tag) {
                $posts->whereHas('tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }

        return response()->json($posts->latest()->paginate(10));
    }

    public function show(Post $post)
    {
        $post->load('author:id,name,handle', 'category:id,name', 'tags:id,name');

        $post->load(['comments' => fn ($q) => $q->with(['author:id,name,handle'])->withcount([
            'votes as upvote' => fn ($q) => $q->where('vote', 1),
            'votes as downvote' => fn ($q) => $q->where('vote', -1),
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
            'category_id' => 'required|exists:categories,id',
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
        EmbedPost::dispatch($post->id);

        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

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
            foreach ($validated['tags'] as $tag) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tag],
                    ['slug' => Str::slug($tag)]
                );
                $tagIds[] = $tag->id;
            }

            $post->tags()->sync($tagIds);
        }
        EmbedPost::dispatch($post->id);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        DB::connection('pgsql')->delete('DELETE FROM post_embeddings WHERE post_id = ?', [$post->id]);

        return response()->json('post deleted');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.cohere.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.cohere.ai/v2/embed', [
                'model' => 'embed-v4.0',
                'texts' => [$search],
                'input_type' => 'search_query',
                'embedding_types' => ['float'],
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
        $embedding = $response->json('embeddings.float.0');
        $vector = '['.implode(',', $embedding).']';
        $closestposts = DB::connection('pgsql')->select('SELECT DISTINCT ON (post_id) post_id, chunk_text, embedding <=> ? AS distance 
                                                                    FROM post_embeddings ORDER BY post_id, distance LIMIT 50', [$vector]);

        $ids = collect($closestposts)->pluck('post_id')->toArray();
        $posts = Post::whereIn('id', $ids)->with('author')->get()->keyBy('id');

        $orderedresults = collect($closestposts)->map(function ($result) use ($posts) {
            $post = $posts[$result->post_id];
            if ($post) {
                $post->matching_chunk = $result->chunk_text;

                return $post;
            }
        })->filter();

        return response()->json($orderedresults);
    }
}

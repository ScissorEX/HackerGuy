<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        //$posts = Post::with('author')->where('published_at', '<=', now())->latest()->paginate(10);
        $posts = Post::with('author')->latest()->paginate(10);
        return response()->json($posts);
    }

    public function show(Post $post)
    {

    $post->loadCount([
        'votes as upvote_count' => fn($q) => $q->where('vote', 1),
        'votes as downvote_count' => fn($q) => $q->where('vote', -1),
    ]);
    
    if (auth()->check()) {
        $post->load(['votes' => fn($q) => $q->where('user_id', auth()->id())]);
    }
    
    return response()->json($post->load('author', 'comments.author'));
}

    public function store(Request $request)
    {
         $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        //ignore underfined error
        $post = auth()->user()->posts()->create($validated);
        
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

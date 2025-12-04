<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Post $post)
    {
        $comments = $post->comments()->with('author')->latest()->get();
        return response()->json($comments);
    }

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $comment = $post->comments()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id()
        ]);

        return response()->json($comment->load('author'), 201);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment->load('author'));
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}

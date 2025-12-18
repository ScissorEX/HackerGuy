<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth('sanctum')->id()
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

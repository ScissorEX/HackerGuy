<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth('sanctum')->id(),
        ]);

        return response()->json($comment->load('author'), 201);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment->load('author'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required',
        ]);

        $comment->update($validated);

        return response()->json($comment);

    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json('comment deleted');
    }
}

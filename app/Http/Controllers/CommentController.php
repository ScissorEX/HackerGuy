<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comment = Comment::with('author')->latest();
        return response()->json($comment);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);
        //ignore underfined error
        $comment = auth()->user()->comments()->create($validated);
        
        return response()->json($comment, 201);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment->load('author', 'comments'));
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

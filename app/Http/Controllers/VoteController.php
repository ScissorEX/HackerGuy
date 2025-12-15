<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function votePost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'vote' => 'required|in:1,-1',
        ]);
        $voteValue = $validated['vote'];
        $oldvote = Vote::where('user_id', auth()->id())
            ->where('voteable_id', $post->id)
            ->where('voteable_type', Post::class)
            ->first();

        if ($oldvote) {
            if ($voteValue == $oldvote->vote) {
                $oldvote->delete();
            } else {
                $oldvote->vote = $voteValue;
                $oldvote->save();
            }
        } else {
            $post->votes()->create([
                'user_id' => auth()->id(),
                'vote' => $voteValue,
            ]);
        }

        return response()->json(['message' => 'Vote recorded'], 200);
    }

    public function voteComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'vote' => 'required|in:1,-1',
        ]);
        $voteValue = $validated['vote'];
        $oldvote = Vote::where('user_id', auth()->id())
            ->where('voteable_id', $comment->id)
            ->where('voteable_type', Post::class)
            ->first();

        if ($oldvote) {
            if ($voteValue == $oldvote->vote) {
                $oldvote->delete();
            } else {
                $oldvote->vote = $voteValue;
                $oldvote->save();
            }
        } else {
            $comment->votes()->create([
                'user_id' => auth()->id(),
                'vote' => $voteValue,
            ]);
        }

        return response()->json(['message' => 'Vote recorded'], 200);
    }
}

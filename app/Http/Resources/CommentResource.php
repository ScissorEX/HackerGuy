<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'author' => $this->author->name,
            'upvote' => $this->upvote,
            'downvote' => $this->downvote,
            'uservote' => $this->uservote,
            'created_since' => $this->created_at->diffForHumans(),
            'was_updated' => $this->created_at != $this->updated_at,
        ];
    }
}

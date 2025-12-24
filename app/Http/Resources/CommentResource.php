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
            'upvote' => $this->upvotecount,
            'downvote' => $this->downvotecount,
            'uservote' => $this->uservote,
            'created_at' => $this->created_at->format('M d, Y h:i A'),
            'was_updated' => ($this->created_at != $this->updated_at),
        ];
    }
}

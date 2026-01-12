<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsercommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'upvote' => $this->upvote,
            'downvote' => $this->downvote,
            'created_since' => $this->created_at->diffForHumans(),
            'was_updated' => $this->created_at != $this->updated_at,
        ];
    }
}

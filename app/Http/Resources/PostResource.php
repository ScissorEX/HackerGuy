<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'author' => $this->author->name,
            'handle' => $this->author->handle,
            'category' => $this->category->name,
            'tags' => $this->tags->pluck('name')->toArray(),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'upvote' => $this->upvote,
            'downvote' => $this->downvote,
            'uservote' => $this->uservote,
            'created_since' => $this->created_at->diffForHumans(),
            'was_updated' => $this->created_at != $this->updated_at,
        ];
    }
}

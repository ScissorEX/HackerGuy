<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        'category' => $this->category->name,
        'tags' => $this->tags->pluck('name')->toArray(),
        'comments' => CommentResource::collection($this->whenLoaded('comments')),
        'upvote' => $this->upvote ?? 0,
        'downvote' => $this->downvote ?? 0,
        'uservote' => $this->uservote ?? null,
        'created_at' => $this->created_at->format('M d, Y h:i A'),
        'was_updated' => $this->created_at != $this->updated_at,
    ];
}
}
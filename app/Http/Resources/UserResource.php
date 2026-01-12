<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'handle' => $this->handle,
            'posts' => UserpostResource::collection($this->whenloaded('posts')),
            'comments' => UsercommentResource::collection($this->whenLoaded('comment')),
        ];
    }
}

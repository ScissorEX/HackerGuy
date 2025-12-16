<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id','content', 'user_id', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }
    public function votes(){
        return $this->morphMany(Vote::class,'voteable');
    }
    //votes count
    protected $appends = ['upvotecount', 'downvotecount', 'uservote'];
    protected $hidden = ['votes'];

    public function getUpvotecountAttribute()
    {
        return $this->votes->where('vote', 1)->count();
    }

    public function getDownvotecountAttribute()
    {
        return $this->votes->where('vote', -1)->count();
    }

    public function getUservoteAttribute()
    {
    if (!auth('sanctum')->check()) {
        return null;
    }
    return $this->votes->first()?->vote;
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'user_id', 'published_at', 'category_id'];

    protected $casts = ['published_at' => 'datetime'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    // relations
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function ispublished()
    {
        return $this->published_at != null && $this->published_at->isPast();
    }

    public function getUpvotecountAttribute()
    {
        return $this->votes()->where('vote', 1)->count();
    }

    public function getDownvotecountAttribute()
    {
        return $this->votes()->where('vote', -1)->count();
    }

    public function getUservoteAttribute()
    {
        if (! auth('sanctum')->check()) {
            return null;
        }

        return $this->votes->first()?->vote;
    }
}

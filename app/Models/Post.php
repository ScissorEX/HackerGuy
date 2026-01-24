<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Jobs\EmbedPost;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'user_id', 'category_id'];

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
}

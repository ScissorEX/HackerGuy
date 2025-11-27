<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'user_id', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    protected static function boot(){
        parent::boot();
        static::creating(function($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function ispublished(){
        return $this->published_at !== null && $this->published_at->isPast();
    }
}

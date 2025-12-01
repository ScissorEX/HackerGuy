<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id','content', 'user_id', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post(){
        return $this->hasOne(Post::class);
    }
}

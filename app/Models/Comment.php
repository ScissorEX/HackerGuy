<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id','title','content', 'user_id', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }
}

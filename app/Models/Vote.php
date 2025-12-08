<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    protected $fillable = ['user_id','voteable_type','voteable_id', 'vote', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function votable(){
        return $this->morphTo();
    }
}

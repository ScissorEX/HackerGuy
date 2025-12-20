<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public static function findSimilar($name)
    {
        return self::where('name', 'LIKE', "%{$name}%")
            ->limit(5)->get(['id', 'name', 'slug']);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

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

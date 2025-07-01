<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Post extends AppModel
{
    protected $fillable = [
        'title',
        'category_id',
        'thumbnail',
        'excerpt',
        'content',
        'status',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends AppModel
{
    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

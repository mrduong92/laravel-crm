<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Knowledge extends AppModel
{
    protected $table = 'knowledges';
    
    protected $fillable = [
        'type',
        'title',
        'content',
        'media_id'
    ];
}

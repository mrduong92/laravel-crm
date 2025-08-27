<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Knownledge extends AppModel
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'file'
    ];
}

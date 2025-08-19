<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Namu\WireChat\Traits\Chatable;
use Spatie\Multitenancy\Models\Tenant;

class Customer extends AppModel
{
    use Chatable;

    protected $fillable = [
        'assign_to',
        'name',
        'phone',
        'email',
        'external_id',
        'source',
    ];

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
}

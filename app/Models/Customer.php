<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Namu\WireChat\Traits\Chatable;
use Spatie\Multitenancy\Models\Tenant;

class Customer extends AppModel
{
    use Chatable;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'uid',
        'name',
        'email',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

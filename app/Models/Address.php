<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'street',
        'city',
        'state',
        'country',
        'zip_code',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}

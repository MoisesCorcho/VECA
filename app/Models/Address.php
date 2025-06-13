<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

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

    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $city = $this->city ? Str::ucfirst($this->city) : '';
                $state = $this->state ? Str::ucfirst($this->state) : '';
                $country = $this->country ? Str::ucfirst($this->country) : '';

                return trim(sprintf(
                    '%s, %s, %s, %s, %s',
                    $this->street,
                    $city,
                    $state,
                    $country,
                    $this->zip_code
                ));
            },
        );
    }
}

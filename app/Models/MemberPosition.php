<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}

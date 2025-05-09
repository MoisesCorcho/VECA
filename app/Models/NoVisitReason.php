<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NoVisitReason extends Model
{
    /** @use HasFactory<\Database\Factories\NoVisitReasonFactory> */
    use HasFactory;

    protected $fillable = [
        'reason',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'non_visit_reason_id');
    }
}

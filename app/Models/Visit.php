<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    /** @use HasFactory<\Database\Factories\VisitFactory> */
    use HasFactory;

    protected $fillable = [
        'visit_date',
        'rescheduled_date',
        'non_visit_description',
        'status',
        'organization_id',
        'user_id',
        'non_visit_reason_id',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'datetime',
            'rescheduled_date' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nonVisitReason(): BelongsTo
    {
        return $this->belongsTo(NoVisitReason::class, 'non_visit_reason_id');
    }
}

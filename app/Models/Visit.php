<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\VisitStatusEnum;

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
        'survey_id',
        'non_visit_reason_id',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'datetime',
            'rescheduled_date' => 'datetime',
            'status' => VisitStatusEnum::class,
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

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\VisitStatusEnum;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function surveyAnswer(): HasOne
    {
        return $this->hasOne(SurveyAnswer::class);
    }

    /**
     * Checks if the visit's status is equal to the given status.
     *
     * @param VisitStatusEnum $status The status to compare against the visit's status.
     * @return bool True if the visit's status matches the given status, false otherwise.
     */
    public function hasStatus(VisitStatusEnum $status): bool
    {
        return $this->status->hasStatus($status);
    }

    /**
     * Check if the visit originally had the given status.
     *
     * @param VisitStatusEnum $status The status to compare against the original status.
     * @return bool True if the original status matches the given status, false otherwise.
     */
    public function hadStatus(VisitStatusEnum $status): bool
    {
        return $this->getOriginal('status') === $status;
    }

    /**
     * Checks if the visit has a survey answer.
     *
     * @return bool True if the visit has a survey answer, false otherwise.
     */
    public function hasSurveyAnswer(): bool
    {
        return $this->surveyAnswer?->exists() ?? false;
    }

    /**
     * Checks if the visit's status is changing from 'VISITED' to another status,
     * while also ensuring it has an associated survey answer.
     *
     * @return bool True if the visit was 'VISITED', is no longer 'VISITED', and has a survey answer.
     */
    public function isRevertingVisitedStatusWithSurvey(): bool
    {
        return $this->hadStatus(VisitStatusEnum::VISITED)
            && ! $this->hasStatus(VisitStatusEnum::VISITED)
            && $this->hasSurveyAnswer();
    }

    /**
     * Checks if the visit's status is changing to the given status.
     *
     * @param VisitStatusEnum $status The status to check against.
     * @return bool True if the visit's status is changing to the given status.
     */
    public function isStatusChangingTo(VisitStatusEnum $status): bool
    {
        return ! $this->hadStatus($status) && $this->hasStatus($status);
    }

    /**
     * Checks if the visit should clear its non visit fields.
     *
     * A visit should clear its non visit fields if it was "not visited" or "canceled",
     * and it currently has a non visit description or reason.
     *
     * @return bool True if the visit should clear its non visit fields, false otherwise.
     */
    public function shouldClearNonVisitFields(): bool
    {
        return ! in_array($this->status, [VisitStatusEnum::NOT_VISITED, VisitStatusEnum::CANCELED], true)
            && ($this->non_visit_description || $this->non_visit_reason_id);
    }
}

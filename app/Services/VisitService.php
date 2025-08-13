<?php

namespace App\Services;

use App\Models\Visit;
use App\Enums\VisitStatusEnum;
use App\Exceptions\VisitStatusValidationException;

class VisitService
{
    public function validateNewVisit(Visit $visit): void
    {
        if ($visit->hasStatus(VisitStatusEnum::VISITED)) {
            $this->throwValidationError();
        }
    }

    public function validateVisitUpdate(Visit $visit): void
    {
        if ($visit->isStatusChangingTo(VisitStatusEnum::VISITED) && !$visit->hasSurveyAnswer()) {
            $this->throwValidationError();
        }

        $this->handleNonVisitFields($visit);
    }

    public function handleNonVisitFields(Visit $visit): void
    {
        if ($visit->shouldClearNonVisitFields()) {
            $this->clearNonVisitFields($visit);
        }
    }

    private function clearNonVisitFields(Visit $visit): void
    {
        $visit->update([
            'non_visit_reason_id' => null,
            'non_visit_description' => null,
        ]);
    }

    private function throwValidationError(): void
    {
        throw new VisitStatusValidationException();
    }
}

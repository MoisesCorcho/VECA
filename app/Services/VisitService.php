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
    }

    private function throwValidationError(): void
    {
        throw new VisitStatusValidationException();
    }
}

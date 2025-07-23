<?php

namespace App\Services;

use App\Models\Visit;
use App\Enums\VisitStatusEnum;

class SurveyAnswerService
{
    public function handleSurveyAnswerCleanup(Visit $visit): void
    {
        if ($visit->isRevertingVisitedStatusWithSurvey()) {
            $this->deleteSurveyAnswer($visit);
        }
    }

    private function deleteSurveyAnswer(Visit $visit): void
    {
        $visit->surveyAnswer->delete();
    }
}

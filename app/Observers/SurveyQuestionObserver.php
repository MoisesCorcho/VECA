<?php

namespace App\Observers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Services\SurveyQuestionService;

class SurveyQuestionObserver
{
    /**
     * Handle the SurveyQuestion "created" event.
     */
    public function saving(SurveyQuestion $surveyQuestion): void
    {
        $surveyQuestionService = app(SurveyQuestionService::class);

        $surveyQuestionService->validateHierarchy($surveyQuestion);
    }

    /**
     * Handle the SurveyQuestion "updated" event.
     */
    public function updating(SurveyQuestion $surveyQuestion): void
    {
        //
    }

    /**
     * Handle the SurveyQuestion "deleted" event.
     */
    public function deleted(SurveyQuestion $surveyQuestion): void
    {
        //
    }

    /**
     * Handle the SurveyQuestion "restored" event.
     */
    public function restored(SurveyQuestion $surveyQuestion): void
    {
        //
    }

    /**
     * Handle the SurveyQuestion "force deleted" event.
     */
    public function forceDeleted(SurveyQuestion $surveyQuestion): void
    {
        //
    }
}

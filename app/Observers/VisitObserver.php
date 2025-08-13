<?php

namespace App\Observers;

use App\Models\Visit;
use App\Services\VisitService;
use App\Services\SurveyAnswerService;

class VisitObserver
{
    public function __construct(
        protected VisitService $visitService,
        protected SurveyAnswerService $surveyAnswerService
    ) {}

    public function creating(Visit $visit): void
    {
        $this->visitService->validateNewVisit($visit);
    }

    public function updating(Visit $visit): void
    {
        $this->surveyAnswerService->handleSurveyAnswerCleanup($visit);
        $this->visitService->validateVisitUpdate($visit);
    }

    /**
     * Handle the Visit "updated" event.
     */
    public function updated(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "deleted" event.
     */
    public function deleted(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "restored" event.
     */
    public function restored(Visit $visit): void
    {
        //
    }

    /**
     * Handle the Visit "force deleted" event.
     */
    public function forceDeleted(Visit $visit): void
    {
        //
    }
}

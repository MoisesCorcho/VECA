<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Survey;
use App\Models\Visit;

class SurveyResponsePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.survey-response-page';

    // Remove the page from the sidebar
    protected static bool $shouldRegisterNavigation = false;

    public ?Survey $survey = null;
    public ?Visit $visit = null;

    public static function getUrlWithSurvey(Survey $survey, Visit $visit): string
    {
        return static::getUrl(['survey_id' => $survey->id, 'visit_id' => $visit]);
    }

    public function mount(): void
    {
        $surveyId = request()->query('survey_id');
        $visitId = request()->query('visit_id');

        if ($surveyId && $visitId) {
            $this->visit = Visit::find($visitId);
            $this->survey = Survey::find($surveyId);
        }
    }
}

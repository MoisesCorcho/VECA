<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Survey;

class SurveyResponsePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.survey-response-page';

    // Remove the page from the sidebar
    protected static bool $shouldRegisterNavigation = false;

    public ?Survey $survey = null;

    public static function getUrlWithSurvey(Survey $survey): string
    {
        return static::getUrl(['survey_id' => $survey->id]);
    }

    public function mount(): void
    {
        $surveyId = request()->query('survey_id');
        if ($surveyId) {
            $this->survey = Survey::find($surveyId);
        }
    }
}

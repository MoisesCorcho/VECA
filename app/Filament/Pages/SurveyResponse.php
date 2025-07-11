<?php

namespace App\Filament\Pages;

use App\Models\Survey;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SurveyResponse extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.survey-response';

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

<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;
use Illuminate\View\View;
use App\Enums\SurveyQuestionsTypeEnum;
use Filament\Notifications\Notification;
use App\Models\Visit;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;
use App\Services\SurveyAnswerService;

class SurveyAnswerForm extends Component
{
    public Survey $survey;
    public Visit $visit;
    public array $answers = [];

    #[Computed]
    public function surveyQuestions(): Collection
    {
        return $this->survey->questions()->with('parent')->get();
    }

    //Enums
    public $surveyQuestionsTypeEnum;

    public function mount(Survey|null $survey = null, Visit|null $visit = null): void
    {
        if ($survey && $visit) {
            $this->survey = $survey;
            $this->visit = $visit;
        }

        $this->surveyQuestionsTypeEnum = SurveyQuestionsTypeEnum::class;

        $this->fillAnswersArray();
    }

    public function getSurveyAnswerServiceProperty(): SurveyAnswerService
    {
        return app(SurveyAnswerService::class);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function rules(): array
    {
        return $this->buildSurveyValidationRules();
    }

    /**
     * Builds the dynamic validation rules for the survey answers
     * based on question dependencies.
     */
    private function buildSurveyValidationRules(): array
    {
        $rules = [];

        foreach ($this->surveyQuestions as $question) {

            // case 0: The question is a task trigger
            if ($question->is_task_trigger) {
                $rules['answers.' . $question->id] = 'nullable';
                continue;
            }

            // Case 1: The question is a top-level question (no parent).
            // It should always be required.
            if (is_null($question->parent_id)) {
                $rules['answers.' . $question->id] = 'required';
                continue;
            }

            // Case 2: The question has a parent and is dependent.
            $parentQuestion = $question->parent;

            // If the parent relationship is broken,
            // the dependent question cannot be answered, so it's not required.
            if (!$parentQuestion) {
                $rules['answers.' . $question->id] = 'nullable';
                continue;
            }

            // Get the user's answer to the parent question.
            $parentAnswer = $this->answers[$parentQuestion->id] ?? null;

            // Check if the parent's answer matches the value that triggers this question's visibility.
            if ($parentAnswer == $question->triggering_answer) {
                $rules['answers.' . $question->id] = 'required';
            } else {
                $rules['answers.' . $question->id] = 'nullable';
            }
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'required' => 'This field is required.',
        ];
    }

    public function save(): void
    {
        $this->reestructureCheckboxAnswers();
        $this->validate();

        try {
            $this->surveyAnswerService->saveSurveyAnswer($this->survey, $this->visit, $this->answers);
        } catch (\Throwable $th) {
            Notification::make()
                ->danger()
                ->title('Error saving answer')
                ->body($th->getMessage())
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Success')
            ->body('Answer saved successfully')
            ->send();

        $this->redirectRoute('filament.user.pages.calendar');
    }

    public function fillAnswersArray(): void
    {
        $answers = [];
        foreach ($this->survey->questions as $question) {
            $answers[$question->id] = null;

            if ($question->type == SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value) {
                foreach ($question->data as $value => $label) {
                    $answers[$question->id][$label] = null;
                }
            }
        }
        $this->answers = $answers;
    }

    public function reestructureCheckboxAnswers(): void
    {
        $checkboxQuestions = $this->survey->questions->where('type', SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value)->pluck('id')->toArray();

        foreach ($this->answers as $questionId => $answer) {
            if (in_array($questionId, $checkboxQuestions)) {
                $options = [];

                foreach ($this->answers[$questionId] as $answer => $isSelected) {
                    if ($isSelected) {
                        array_push($options, $answer);
                    }
                }
                $this->answers[$questionId] = $options;
            }
        }
    }

    public function render(): View
    {
        return view('livewire.survey-answer-form');
    }
}

<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\SurveyQuestionAnswer;
use App\Enums\SurveyQuestionsTypeEnum;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use App\Models\Visit;
use App\Enums\VisitStatusEnum;

class SurveyAnswerForm extends Component
{
    public Survey $survey;
    public Visit $visit;
    public array $answers = [];

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

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function rules(): array
    {
        return [
            'answers.*' => 'required',
        ];
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

        $savedAnswer = $this->survey->answers()->create([
            'date' => now(),
            'user_id' => Auth::id(),
        ]);

        $answers = [];

        foreach ($this->answers as $questionId => $answer) {
            $checkboxQuestions = $this->survey->questions->where('type', SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value)->pluck('id')->toArray();

            if (in_array($questionId, $checkboxQuestions)) {
                SurveyQuestionAnswer::create([
                    'survey_answer_id' => $savedAnswer->id,
                    'survey_question_id' => $questionId,
                    'answer' => $answer,
                ]);
            } else {
                $answers[] = [
                    'survey_answer_id' => $savedAnswer->id,
                    'survey_question_id' => $questionId,
                    'answer' => $answer,
                ];
            }
        }

        SurveyQuestionAnswer::insert($answers);

        $this->visit->update([
            'status' => VisitStatusEnum::VISITED
        ]);

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

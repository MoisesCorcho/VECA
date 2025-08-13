<?php

namespace App\Services;

use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
use App\Enums\VisitStatusEnum;
use Illuminate\Support\Facades\Auth;
use App\Enums\SurveyQuestionsTypeEnum;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;


class SurveyAnswerService
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function saveSurveyAnswer(Survey $survey, Visit $visit, array $answers): void
    {
        DB::transaction(function () use ($survey, $visit, $answers) {
            $savedAnswer = $survey->answers()->create([
                'date' => now(),
                'user_id' => Auth::id(),
                'visit_id' => $visit->id
            ]);

            $preparedAnswers = [];

            foreach ($answers as $questionId => $answer) {
                $question = $survey->questions->find($questionId);

                if ($question && $question->type === SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value) {
                    SurveyQuestionAnswer::create([
                        'survey_answer_id' => $savedAnswer->id,
                        'survey_question_id' => $questionId,
                        'answer' => $answer,
                    ]);
                } else {
                    $preparedAnswers[] = [
                        'survey_answer_id' => $savedAnswer->id,
                        'survey_question_id' => $questionId,
                        'answer' => is_null($answer) ? json_encode("") : json_encode($answer),
                    ];
                }
            }

            SurveyQuestionAnswer::insert($preparedAnswers);

            $visit->update([
                'status' => VisitStatusEnum::VISITED,
            ]);

            $this->taskService->createTasksFromSurveyAnswer($savedAnswer);
        });
    }

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

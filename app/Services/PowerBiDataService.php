<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Organization;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrganizationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\PowerBiDataResource;
use App\Models\SurveyAnswer;

final class PowerBiDataService
{
    public function getAllData(): JsonResponse
    {
        $data = [
            'users' => $this->getUsersQuery(),
            'organizations' => $this->getOrganizationsQuery(),
            'surveys' => $this->getSurveysAsJson(),
        ];

        return response()->json(
            new PowerBiDataResource($data)
        );
    }

    public function getUsers(): JsonResponse
    {
        return response()->json(
            UserResource::collection($this->getUsersQuery())
        );
    }

    public function getOrganizations(): JsonResponse
    {
        return response()->json(
            OrganizationResource::collection($this->getOrganizationsQuery())
        );
    }

    private function getUsersQuery(): Collection
    {
        return User::query()
            ->orderBy('name')
            ->role('Seller')
            ->get();
    }

    private function getOrganizationsQuery(): Collection
    {
        return Organization::query()
            ->orderBy('name')
            ->get();
    }


    public function getSurveysAsJson(): array
    {
        $allAnswers = SurveyAnswer::with([
            'survey:id,title',
            'user:id',
            'surveyQuestionAnswers.surveyQuestion:id,question,is_task_trigger'
        ])->get();

        $groupedBySurveyTitle = $allAnswers->groupBy('survey.title');

        $transformedData = $groupedBySurveyTitle->map(function ($answersInGroup) {
            return $answersInGroup->map(function ($surveyAnswer) {

                $questionsAndAnswers = $surveyAnswer->surveyQuestionAnswers->mapWithKeys(function ($qa) {
                    $questionText = $qa->surveyQuestion->question ?? 'Question not found';
                    return [$questionText => $qa->answer];
                });

                // Check if the answer to the question with is_task_trigger is NOT empty
                $hasTaskTriggerQuestion = $surveyAnswer->surveyQuestionAnswers->contains(function ($qa) {

                    return $qa->surveyQuestion->is_task_trigger && !empty($qa->answer);
                });

                $additionalData = [
                    'fecha'      => $surveyAnswer->date,
                    'sellerId'   => $surveyAnswer->user_id,
                    'has_task_trigger_question' => $hasTaskTriggerQuestion,
                ];

                return $questionsAndAnswers->merge($additionalData);
            });
        });

        return $transformedData->toArray();
    }
}

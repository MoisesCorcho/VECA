<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Auth;

final class SurveyQuestionService
{
    final public function validateHierarchy(SurveyQuestion $surveyQuestion): void
    {
        if (! $surveyQuestion->parent_id) {
            return;
        }

        try {
            $parent = SurveyQuestion::findOrFail($surveyQuestion->parent_id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Parent genre does not exist.');
        }

        if ($surveyQuestion->hasCircularReference($surveyQuestion->parent_id)) {
            throw new Exception('Circular reference detected.');
        }

        if (! $parent->canHaveChildren()) {
            throw new Exception('Maximum depth level reached.');
        }
    }


    public static function getOptionsLabel(string $entity)
    {
        $entity = new $entity();

        return array_combine($entity->getFillable(), $entity->getFillable());
    }

    public static function getDatabaseOptions(string $entity, SurveyQuestion $question, array $answers): Collection | SupportCollection
    {
        return match ($entity) {
            Organization::class => self::getOrganizationOptions($question),
            Member::class => self::getMemberOptions($question, $answers),
            MemberPosition::class => self::getMemberPositionOptions($question),
        };
    }

    private static function getOrganizationOptions(SurveyQuestion $question): Collection
    {
        $organizations = Organization::where('user_id', Auth::user()->id)->select('id', $question->options_label_column)->get();

        if ($organizations->isEmpty()) {
            return collect([
                (object) [
                    "id" => 'not_found',
                    $question->options_label_column => __("No organizations for this user found.")
                ]
            ]);
        }

        return $organizations;
    }

    private static function getMemberOptions(SurveyQuestion $question, array $answers): Collection | SupportCollection
    {
        $organizationQuestion = $question?->survey?->questions()->where('options_model', Organization::class)->first();

        if (! $organizationQuestion) {
            return collect([
                (object) [
                    "id" => "not_found",
                    $question->options_label_column => __("Configuration error: Organization question not found.")
                ]
            ]);
        }

        $members = Member::where('organization_id', $answers[$organizationQuestion->id] ?? null)
            ->select('id', $question->options_label_column)
            ->get();

        if ($members->isEmpty()) {
            return collect([
                (object) [
                    "id" => "not_found",
                    $question->options_label_column => __("No members found for this organization.")
                ]
            ]);
        }

        return $members;
    }

    private static function getMemberPositionOptions(SurveyQuestion $question): Collection | SupportCollection
    {
        $memberPositions = MemberPosition::all();

        if ($memberPositions->isEmpty()) {
            return collect([
                (object) [
                    "id" => "not_found",
                    $question->options_label_column => __("No members positions found.")
                ]
            ]);
        }

        return $memberPositions;
    }

    public function HandleChangesInOptionsSource(SurveyQuestion $question): void
    {
        if ($question->isDirty('options_source')) {
            $this->cleanupDatabaseOptionFields($question);
            $this->cleanupDataField($question);
        }
    }

    private function cleanupDatabaseOptionFields(SurveyQuestion $question): void
    {
        if ($question->isOptionsSourceChangingTo('static')) {
            $question->updateQuietly([
                'options_model' => null,
                'options_label_column' => null,
            ]);
        }
    }

    private function cleanupDataField(SurveyQuestion $question): void
    {
        if ($question->isOptionsSourceChangingTo('database')) {
            $question->updateQuietly([
                'data' => null
            ]);
        }
    }
}

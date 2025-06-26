<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

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
}

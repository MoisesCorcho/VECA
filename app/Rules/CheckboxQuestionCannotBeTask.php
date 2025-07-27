<?php

namespace App\Rules;

use Closure;
use App\Enums\SurveyQuestionsTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckboxQuestionCannotBeTask implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) return;

        collect($value)->each(function ($question) use ($fail) {
            if ($question['type'] === SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value && $question['is_task_trigger']) {
                $fail('Checkbox questions cannot be marked to generate pending tasks.');
            }
        });
    }
}

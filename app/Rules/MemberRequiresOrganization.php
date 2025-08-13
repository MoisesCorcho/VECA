<?php

namespace App\Rules;

use Closure;
use App\Enums\ModelOptionSourceEnum;
use Illuminate\Contracts\Validation\ValidationRule;

class MemberRequiresOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            return;
        }

        $organizationQuestion = collect($value)
            ->where('options_model', ModelOptionSourceEnum::ORGANIZATION->value);

        $memberQuestion = collect($value)
            ->where('options_model', ModelOptionSourceEnum::MEMBER->value);

        if ($organizationQuestion->isEmpty() && $memberQuestion->isNotEmpty()) {

            $memberQuestionsTitles = collect($memberQuestion)
                ->pluck('question');

            $fail("The Member option in the question {$memberQuestionsTitles} requires at least one Organization question.");
        }
    }
}

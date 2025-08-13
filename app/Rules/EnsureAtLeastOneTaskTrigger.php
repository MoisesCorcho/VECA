<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnsureAtLeastOneTaskTrigger implements ValidationRule
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

        $triggerCount = collect($value)
            ->where('is_task_trigger', true)
            ->count();

        if ($triggerCount < 1) {
            $fail('At least one question must be marked to generate pending tasks.');
        }
    }
}

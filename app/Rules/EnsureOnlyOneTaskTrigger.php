<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnsureOnlyOneTaskTrigger implements ValidationRule
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

        if ($triggerCount > 1) {
            $fail('Only one question can be marked to generate pending tasks.');
        }
    }
}

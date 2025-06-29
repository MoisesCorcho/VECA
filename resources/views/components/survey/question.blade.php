@props(['surveyQuestionsTypeEnum', 'answers'])

<div class="mb-5">
    @switch($question->type)
        @case($surveyQuestionsTypeEnum::TYPE_TEXT->value)
            <x-forms.input :question="$question" type="text" />
        @break

        @case($surveyQuestionsTypeEnum::TYPE_TEXTAREA->value)
            <x-forms.text-area :question="$question" />
        @break

        @case($surveyQuestionsTypeEnum::TYPE_SELECT->value)
            <x-forms.select :question="$question" :answers="$answers" />
        @break

        @case($surveyQuestionsTypeEnum::TYPE_RADIO->value)
            <x-forms.radio-group :question="$question" />
        @break

        @case($surveyQuestionsTypeEnum::TYPE_CHECKBOX->value)
            <x-forms.checkbox-group :question="$question" />
        @break

        @case($surveyQuestionsTypeEnum::TYPE_DATE->value)
            <x-forms.input :question="$question" type="date" />
        @break

        @default
            <p class="mt-3 text-sm text-red-500 p-2 bg-red-50 dark:bg-red-900/20 rounded">
                Unsupported question type
            </p>
    @endswitch

    @error("answers.$question->id")
        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

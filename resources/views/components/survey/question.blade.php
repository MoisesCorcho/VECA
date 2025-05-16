@props(['surveyQuestionsTypeEnum'])

<div class="mb-5">
    @switch($question->type)
        @case($surveyQuestionsTypeEnum::TYPE_TEXT->value)
            <x-filament::input.wrapper class="w-full">
                <x-filament::input type="text" wire:model.live="answers.{{ $question->id }}" class="w-full"
                    placeholder="Put your answer here..." />
            </x-filament::input.wrapper>
            @error("answers.$question->id")
                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        @break

        @case($surveyQuestionsTypeEnum::TYPE_TEXTAREA->value)
            <x-forms.text-area wire:model.live="answers.{{ $question->id }}" class="w-full text-sm"
                placeholder="Put your answer here..." rows="4"></x-forms.text-area>
            @error("answers.$question->id")
                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        @break

        @case($surveyQuestionsTypeEnum::TYPE_SELECT->value)
            <x-filament::input.wrapper class="w-full">
                <x-filament::input.select wire:model.live="answers.{{ $question->id }}" class="w-full">
                    <option value="">{{ __('Select an option') }}</option>
                    @foreach ($question->data ?? [] as $optionValue => $optionLabel)
                        <option value="{{ $optionLabel }}">
                            {{ $optionLabel }}
                        </option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
            @error("answers.$question->id")
                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        @break

        @case($surveyQuestionsTypeEnum::TYPE_RADIO->value)
            <x-forms.radio-group :question-id="$question->id" :options="$question->data ?? []" />
            @error("answers.$question->id")
                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        @break

        @case($surveyQuestionsTypeEnum::TYPE_CHECKBOX->value)
            <div class="space-y-3">
                @foreach ($question->data as $value => $label)
                    <div class="flex items-center gap-x-2">
                        <x-filament::input.checkbox wire:model.live="answers.{{ $question->id }}.{{ $label }}"
                            id="checkbox-{{ $question->id }}-{{ $loop->index }}" />
                        <label for="checkbox-{{ $question->id }}-{{ $loop->index }}" class="text-sm">
                            {{ $label }}
                        </label>
                        @error("answers.$question->id")
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        @break

        @case($surveyQuestionsTypeEnum::TYPE_DATE->value)
            <x-filament::input.wrapper class="w-full">
                <x-filament::input type="date" wire:model.live="answers.{{ $question->id }}" class="w-full" />
            </x-filament::input.wrapper>
            @error("answers.$question->id")
                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        @break

        @default
            <p class="mt-3 text-sm text-red-500 p-2 bg-red-50 dark:bg-red-900/20 rounded">
                Unsupported question type
            </p>
    @endswitch
</div>

<div>
    <x-filament::section icon="heroicon-o-document-duplicate" icon-color="info">
        <x-slot name="heading">
            {{ $survey->title }}
        </x-slot>

        @if ($survey->description)
            <x-slot name="description">
                {{ $survey->description }}
            </x-slot>
        @endif

        <form wire:submit.prevent="save" class="space-y-4">
            @foreach ($survey->questions as $question)
                @if (!$question->parent_id || ($question->parent_id && $answers[$question->parent_id] == $question->triggering_answer))
                    <x-filament::section>
                        <x-slot name="heading">
                            {{ $question->question ?? 'Question without title' }}
                        </x-slot>

                        @if ($question->description)
                            <x-slot name="description">
                                {{ $question->description }}
                            </x-slot>
                        @endif

                        <x-survey.question :question="$question" :surveyQuestionsTypeEnum="$surveyQuestionsTypeEnum" :answers="$answers"></x-survey.question>

                        {{-- Content --}}
                    </x-filament::section>
                @endif
            @endforeach

            <x-filament::button wire:click="save" icon="heroicon-m-inbox-arrow-down" icon-position="after">
                Save Answer
            </x-filament::button>
        </form>
    </x-filament::section>

</div>

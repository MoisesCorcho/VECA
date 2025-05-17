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
                <x-filament::section>
                    <x-slot name="heading">
                        {{ $question->question ?? 'Question without title' }}
                    </x-slot>

                    @if ($question->description)
                        <x-slot name="description">
                            {{ $question->description }}
                        </x-slot>
                    @endif

                    {{-- Content --}}
                    <x-survey.question :question="$question" :surveyQuestionsTypeEnum="$surveyQuestionsTypeEnum"></x-survey.question>
                </x-filament::section>
            @endforeach

            <x-filament::button wire:click="save" icon="heroicon-m-inbox-arrow-down" icon-position="after">
                Save Answer
            </x-filament::button>
        </form>
    </x-filament::section>

</div>

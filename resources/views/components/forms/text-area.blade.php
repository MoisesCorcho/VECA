@props(['question'])

<textarea
    {{
        $attributes->class([
            'w-full',
            'rounded',
            'py-3',
            'px-[14px]',
            'text-base',
            'text-body-color',
            'border',
            'border-[#f0f0f0]',
            'bg-white',
            'outline-none',
            'focus-visible:shadow-none',
            'focus:border-primary',
            'dark:bg-gray-800',
            'dark:text-gray-100',
            'dark:placeholder-gray-400',
            'dark:border-gray-700',
            'dark:focus:border-primary',
        ])
    }}
    wire:model.live="answers.{{ $question->id }}" 
    class="w-full text-sm"
    placeholder="Put your answer here..." 
    rows="4"
></textarea>

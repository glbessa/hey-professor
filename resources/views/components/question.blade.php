@props([
    'question'
])

<div class="rounded dark:bg-gray-800/50 dark:text-gray-400 bg-white shadow-lg p-3 text-black mb-4">
    {{ $question->question }}
</div>
@props([
    'question'
])

<div class="rounded dark:bg-gray-800/50 dark:text-gray-400 bg-white shadow-lg p-3 text-black mb-4 flex justify-between items-center">
    <span>{{ $question->question }}</span>
    <div class="flex row">
        <x-form put :action="route('question.like', $question)" class="mr-5">
            <button>
                <x-icons.thumb-up class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                <span>{{ $question->likes }}</span>
            </button>
        </x-form>
        <x-form put :action="route('question.unlike', $question)">
            <button>
                <x-icons.thumb-down class="w-5 h-5 text-red-500 hover:text-red-300 cursor-pointer"/>    
                <span>{{ $question->unlikes }}</span>
            </button>
        </x-form>
    </div>
</div>
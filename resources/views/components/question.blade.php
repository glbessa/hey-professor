@props([
    'question',
    'editable' => false,
    'publishable' => false,
    'deletable' => false,
    'archivable' => false,
    'restorable' => false,
])

<div class="rounded dark:bg-gray-800/50 dark:text-gray-400 bg-white shadow-lg p-3 text-black mb-4 flex justify-between items-center">
    <span>{{ $question->question }}</span>
    <div class="flex row items-center">
        <x-form put :action="route('questions.like', $question)" class="mr-5">
            <button>
                <x-icons.thumb-up class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                <span>{{ $question->votes_sum_like ?: 0 }}</span>
            </button>
        </x-form>
        <x-form put :action="route('questions.unlike', $question)">
            <button>
                <x-icons.thumb-down class="w-5 h-5 text-red-500 hover:text-red-300 cursor-pointer"/>
                <span>{{ $question->votes_sum_unlike ?: 0 }}</span>
            </button>
        </x-form>

        @if($editable)
            <a href="{{ route('questions.edit', $question) }}" class="ml-5">
                <x-icons.pencil-square class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
            </a>
        @endif
        @if($publishable)
            <x-form put :action="route('questions.publish', $question)" class="ml-5">
                <button>
                    <x-icons.arrow-up-tray class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                </button>
            </x-form>
        @endif
        @if($archivable)
            <x-form patch :action="route('questions.archive', $question)" class="ml-5">
                <button>
                    <x-icons.archive-box-arrow-down class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                </button>
            </x-form>
        @endif
        @if($restorable)
            <x-form patch :action="route('questions.restore', $question)" class="ml-5">
                <button>
                    <x-icons.archive-box-x-mark class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                </button>
            </x-form>
        @endif
        @if($deletable)
            <x-form delete :action="route('questions.destroy', $question)" class="ml-5">
                <button>
                    <x-icons.trash class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                </button>
            </x-form>
        @endif
    </div>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>

    <x-container>
        <div>
            @foreach($questions as $q)
                <x-question :question="$q">
                </x-question>
            @endforeach
            {{ $questions->links() }}
        </div>
    </x-container>
</x-app-layout>

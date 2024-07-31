<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>

    <x-container>
        <form method="get" action="{{ route('dashboard') }}" class="flex flex-row w-full items-center mb-2">
            <x-text-input type="text" name="search" id="txtSearch" value="{{ request()->search }}" class="w-full mr-2"/>
            <x-buttons.primary type="submit">Search</x-buttons.primary>
        </form>

        <div class="dark:text-gray-300 text-center flex flex-col justify-center">
            @if($questions->isEmpty())
                <div class="mb-2 flex justify-center">
                    <x-draws.not-found width="400"/>
                </div>
                <div class="dark:text-gray-400">
                    Question not found!
                </div>

            @else
                @foreach($questions as $q)
                    <x-question :question="$q">
                    </x-question>
                @endforeach
                {{ $questions->withQueryString()->links() }}
            @endif
        </div>
    </x-container>
</x-app-layout>

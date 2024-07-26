<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-container>
        <x-form :action="route('question.store')">
            <x-textarea label="Question" name="question"/>
            <x-buttons.primary>Save</x-buttons.primary>
            <x-buttons.reset>Reset</x-buttons.reset>
        </x-form>

        <hr class="border-gray-700 border-dashed my-4"/>

        {{-- listagem --}}
        <div>List of questions</div>
        
        <div>
            @foreach($questions as $q)
                <x-question :question="$q">
                </x-question>
            @endforeach
        </div>
    </x-container>
</x-app-layout>

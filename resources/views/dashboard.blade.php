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
    </x-container>
</x-app-layout>

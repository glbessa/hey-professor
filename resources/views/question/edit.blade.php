<x-app-layout>
    <x-container>
        <x-form :action="route('questions.update', $question)" put>
            <x-textarea label="Question" name="question" :value="$question->question"/>
            <x-buttons.primary>Save</x-buttons.primary>
            <x-buttons.reset>Reset</x-buttons.reset>
        </x-form>
    </x-container>
</x-app-layout>

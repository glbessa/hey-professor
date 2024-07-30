<x-app-layout>
    <x-container>
        <x-form :action="route('questions.store')">
            <x-textarea label="Question" name="question"/>
            <x-buttons.primary>Save</x-buttons.primary>
            <x-buttons.reset>Reset</x-buttons.reset>
        </x-form>

        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Drafts') }}
            @foreach($questions as $q)
                @if($q->draft == true)
                    <x-question :question="$q" editable publishable deletable/>
                @endif
            @endforeach
        </div>

        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Published') }}
            @foreach($questions as $q)
                @if($q->draft == false)
                    <x-question :question="$q" deletable/>
                @endif
            @endforeach
        </div>
    </x-container>
</x-app-layout>

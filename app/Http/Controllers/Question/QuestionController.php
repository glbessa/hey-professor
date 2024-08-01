<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Rules\{EndWithQuestionMarkRule, SameQuestionRule};
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions'         => auth()->user()->questions,
            'archivedQuestions' => auth()->user()->questions()->onlyTrashed()->get(),
        ]);
    }

    public function store(): RedirectResponse
    {
        //dd(request()->all());

        request()->validate([
            'question' => [
                'required',
                'min:10',
                new EndWithQuestionMarkRule(),
                new SameQuestionRule(),
            ],
        ]);

        auth()->user()->questions()->create([
            'question' => request()->question,
        ]);

        return back();
    }

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        request()->validate([
            'question' => [
                'required',
                'min:10',
                new EndWithQuestionMarkRule(),
                new SameQuestionRule(),
            ],
        ]);

        $question->update([
            'question' => request()->question,
        ]);
        $question->save();

        return to_route('questions.index');
    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }

    public function restore(int $id): RedirectResponse
    {
        $question = Question::withTrashed()->findOrFail($id);

        $this->authorize('destroy', $question);

        $question->restore();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return to_route('questions.index');
    }
}

<?php

namespace App\Http\Controllers\Question;

use App\Models\Question;
use Closure;
use App\Http\Controllers\Controller;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        //dd(request()->all());

        Question::query()->create(
            request()->validate([
                'question' => [
                    'required',
                    'min:10',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if ($value[strlen($value) - 1] != '?') {
                            $fail('Are you sure that is a question? It is missing the question mark in the end.');
                        }
                    },
                ],
            ])
        );

        return to_route('dashboard');
    }
}

<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Request};
use Symfony\Component\HttpFoundation\Response;

class PublishController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Question $question): RedirectResponse
    {
        $this->authorize('publish', $question);
        #abort_unless(auth()->user()->can('publish', $question), Response::HTTP_FORBIDDEN);

        $question->publish();

        return back();
    }
}

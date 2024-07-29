<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to edit a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id]);

    actingAs($user);

    get(route('questions.edit', $question))->assertSuccessful();
});

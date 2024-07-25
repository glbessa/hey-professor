<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, put};

it('should be able to like a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    actingAs($user);

    put(route('question.like', $question))->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'user_id'     => $user->id,
        'like'        => 1,
        'unlike'      => 0,
    ]);

});

it('should be able to unlike a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    actingAs($user);

    put(route('question.unlike', $question))->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'user_id'     => $user->id,
        'like'        => 0,
        'unlike'      => 1,
    ]);
});

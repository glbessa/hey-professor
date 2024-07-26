<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it("should be able to publish a question", function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->create([
            'created_by' => $user->id,
        ]);

    actingAs($user);

    put(route('question.publish', $question))->assertRedirect();

    $question->refresh();

    expect($question)->draft->toBeFalse();
});

it('should make sure that only the person who has created the question can publish the question', function () {
    $user      = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create([
        'created_by' => $user->id,
    ]);

    actingAs($wrongUser);

    put(route('question.publish', $question))->assertForbidden();

    actingAs($user);

    put(route('question.publish', $question))->assertRedirect();
});

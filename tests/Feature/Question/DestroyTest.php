<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete};

it('should be able to destroy a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id]);

    actingAs($user);

    delete(route('questions.destroy', $question))->assertRedirect();

    assertDatabaseMissing('questions', [
        'id' => $question->id,
    ]);
});

it('should be able to destroy a question only if user has created that question', function () {
    $user      = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $user->id]);

    actingAs($wrongUser);

    delete(route('questions.destroy', $question))->assertForbidden();

    actingAs($user);

    delete(route('questions.destroy', $question))->assertRedirect();

    assertDatabaseMissing('questions', [
        'id' => $question->id,
    ]);
});

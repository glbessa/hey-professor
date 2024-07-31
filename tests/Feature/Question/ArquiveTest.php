<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted, patch};

it('should be able to arquive a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id]);

    actingAs($user);

    patch(route('questions.archive', $question))
        ->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->not->toBeNull();
});

it('should be able to unarquive a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'deleted_at' => now()]);

    actingAs($user);

    patch(route('questions.restore', $question->id))
        ->assertRedirect();

    assertNotSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->toBeNull();
});

it('should be able to arquive only the creator user', function () {
    $user      = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $user->id]);

    actingAs($wrongUser);

    patch(route('questions.archive', $question))
        ->assertForbidden();

    actingAs($user);

    patch(route('questions.archive', $question))
        ->assertRedirect();
});

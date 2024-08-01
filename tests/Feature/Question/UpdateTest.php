<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

it('should update question in the database', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($user);

    put(route('questions.update', $question), [
        'question' => 'Updated question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question->question)->toBe('Updated question?');
});

it('should be able to create a question bigger than 255 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($user);

    $request = put(route('questions.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
    ]);

});

it('should check if question ends with ? mark', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($user);

    $request = put(route('questions.update', $question), [
        'question' => str_repeat('*', 20),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

it('should have at least 10 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($user);

    $request = put(route('questions.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

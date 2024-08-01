<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to edit a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($user);

    get(route('questions.edit', $question))->assertSuccessful();
});

it('should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($user);

    get(route('questions.edit', $question))->assertViewIs('question.edit');
});

it('should not allow editing if it is a draft', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id, 'draft' => false]);

    actingAs($user);

    get(route('questions.edit', $question))
        ->assertForbidden();
});

it('should allow editing only for the creator', function () {
    $user      = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['created_by' => $user->id, 'draft' => true]);

    actingAs($wrongUser);

    get(route('questions.edit', $question))->assertForbidden();

    actingAs($user);

    get(route('questions.edit', $question))->assertSuccessful();
});

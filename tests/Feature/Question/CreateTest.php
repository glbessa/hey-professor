<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it("should be able to create a question bigger than 255 characters", function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('questions.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
    ]);

});

it("should check if question ends with ? mark", function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route("questions.store"), [
        'question' => str_repeat('*', 20),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);
    assertDatabaseCount('questions', 0);
});

it("should have at least 10 characters", function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route("questions.store"), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

it('should create a draft all the time', function () {
    $user = User::factory()->create();

    actingAs($user);

    post(route('questions.store'), [
        'question' => str_repeat('*', 20) . '?',
    ]);

    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 20) . '?',
        'draft'    => true,
    ]);
});

test('only authenticated users can create a question', function () {
    post(route('questions.store'), [
        'question' => str_repeat('*', 20) . '?',
    ])->assertRedirect(route('login'));
});

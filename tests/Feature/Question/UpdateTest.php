<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

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

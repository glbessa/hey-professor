<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to list all my questions', function () {
    $otherUser      = User::factory()->create();
    $otherQuestions = Question::factory()->count(5)->for($otherUser, 'createdBy')->create();

    $user      = User::factory()->create();
    $questions = Question::factory()->count(5)->create(['created_by' => $user->id]);

    actingAs($user);

    $response = get(route('questions.index'));

    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

    /** @var Question $q */
    foreach ($otherQuestions as $q) {
        $response->assertDontSee($q->question);
    }
});

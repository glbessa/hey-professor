<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to search a question by text', function () {
    $user = User::factory()->create();
    Question::factory()->create(['question' => 'Something else?', 'draft' => false]);
    Question::factory()->create(['question' => 'My question is?', 'draft' => false]);

    actingAs($user);

    get(route('dashboard', ['search' => 'question']))
        ->assertDontSee('Something else?')
        ->assertSee('My question is?');
});

<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    $questions = Question::factory()->count(5)->create([
        'draft' => false,
    ]);
    $user = User::factory()->create();

    actingAs($user);
    $response = get(route('dashboard'));

    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

});

it('should paginate the results', function () {
    $user = User::factory()->create();
    Question::factory()->count(20)->create(['draft' => false]);

    actingAs($user);

    $response = get(route('dashboard'))
        ->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});

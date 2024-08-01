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

it('should order by like and unlike, most liked should be on top and most unliked should be on bottom', function () {
    $user      = User::factory()->create();
    $otherUser = User::factory()->create();
    Question::factory()->count(5)->create(['draft' => false]);

    $mostLikedQuestion = Question::find(3);
    $user->like($mostLikedQuestion);

    $mostUnlikedQuestion = Question::find(1);
    $otherUser->unlike($mostUnlikedQuestion);

    actingAs($user);

    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {
            //dd($questions);

            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(1);

            return true;
        });

});

<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    public function update(User $user, Question $question): bool
    {
        return $question->createdBy->is($user) && $question->draft;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function publish(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }
}

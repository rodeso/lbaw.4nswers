<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

class AnswerPolicy
{
    // Can a user update a answer
    public function update(User $user, Answer $answer)
    {
        return $user->id === $answer->author_id;
    }

    // Can a user delete a answer
    public function delete(User $user, Answer $answer)
    {
        return $user->id === $answer->author_id || $user()->is_mod;
    }
}

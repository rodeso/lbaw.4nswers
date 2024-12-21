<?php

namespace App\Policies;
use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    // Can a user update a question
    public function update(User $user, Question $question)
    {
        return ($user->id === $question->author_id) && !($user->is_blocked);
    }

    // Can a user update tags a question
    public function updateTags(User $user, Question $question)
    {
        return (($user->id === $question->author_id) || ($user->is_mod)) && !($user->is_blocked);
    }

    // Can a user close a question
    public function close(User $user, Question $question)
    {
        return $user->id === $question->author_id;
    }

    // Can a user choose an answer for that question
    public function choose(User $user, Question $question)
    {
        return $user->id === $question->author_id;
    }

    // Can a user delete a question
    public function delete(User $user, Question $question)
    {
        return $user->id === $question->author_id || $user->is_mod;
    }
 
}

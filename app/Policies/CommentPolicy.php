<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    // Can a user update a comment
    public function update(User $user, Comment $comment)
    {
        return ($user->id === $comment->author_id) && !($user->is_blocked);
    }

    // Can a user delete a comment
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id || $user->is_mod;
    }
}

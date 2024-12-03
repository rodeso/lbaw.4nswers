<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';
    protected $fillable = ['answer_id', 'author_id', 'post_id'];

    public $timestamps = false; // Disable timestamps that laravel automatically creates and we dont need

    /**
     * Relationship: Comment belongs to an Answer.
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    /**
     * Relationship: Comment belongs to a Post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Relationship: Comment belongs to a User (author).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Access moderator notification through post
     */
    public function moderatorNotification()
    {
        return $this->post->hasOne(ModeratorNotification::class, 'post_id');
    }
}




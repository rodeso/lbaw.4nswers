<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';
    protected $fillable = ['chosen', 'question_id', 'author_id', 'post_id'];
    protected $casts = [
        'chosen' => 'boolean',
    ];

    public $timestamps = false; // Disable timestamps that laravel automatically creates and we dont need

    /**
     * Relationship: Answer belongs to a Question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Relationship: Answer belongs to a Post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Relationship: Answer belongs to a User (author).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function auraVote()
    {
        return $this->hasMany(AuraVote::class);
    }
    // Access moderator notification through post
    public function moderatorNotification()
    {
        return $this->post->hasOne(ModeratorNotification::class, 'post_id');
    }
    
    // Relationship with AuraVote
    public function auraVotes()
    {
        return $this->hasMany(AuraVote::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamps that laravel automatically creates and we dont need

    protected $table = 'question';
    protected $fillable = ['title', 'urgency', 'time_end', 'closed', 'author_id', 'post_id'];
    protected $casts = [
        'time_end' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tags', 'question_id', 'tag_id');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function popularityVotes()
    {
        return $this->hasMany(PopularityVote::class);
    }
    public function moderatorNotification()
    {
        return $this->post->hasOne(ModeratorNotification::class, 'post_id');
    }
    

}

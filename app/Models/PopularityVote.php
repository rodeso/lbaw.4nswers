<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularityVote extends Model
{
    use HasFactory;

    public $timestamps = false; //reminder to recheck this later

    protected $table = 'popularity_vote';
    protected $fillable = ['is_positive', 'user_id', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

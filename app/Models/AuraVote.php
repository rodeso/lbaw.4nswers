<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuraVote extends Model
{
    use HasFactory;

    public $timestamps = false; //reminder to recheck this later

    protected $table = 'aura_vote';
    protected $fillable = ['is_positive', 'user_id', 'answer_id'];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

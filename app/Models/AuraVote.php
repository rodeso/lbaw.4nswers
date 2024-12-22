<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuraVote extends Model
{
    use HasFactory;

    protected $table = 'aura_vote'; // Ensure the correct table name
    protected $fillable = [
        'user_id',
        'answer_id',
        'is_positive',
    ];

    public $timestamps = false; // Set to false if you don’t have timestamps (created_at, updated_at) in the table

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

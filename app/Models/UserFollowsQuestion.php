<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowsQuestion extends Model
{
    use HasFactory;

    protected $table = 'user_follows_question'; // Explicitly set the table name
    protected $fillable = ['user_id', 'question_id']; // Allow mass assignment for these fields

    public $timestamps = false; // Disable timestamps if your table doesn't have created_at/updated_at
}

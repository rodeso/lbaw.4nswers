<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $table = 'post';

    protected $fillable = [
        'body', 
        'time_stamp', 
        'deleted', 
        'edited', 
        'edit_time'
    ];

    protected $casts = [
        'time_stamp' => 'datetime',
        'edit_time' => 'datetime'
    ];

    // Disable automatic timestamps
    public $timestamps = false;
    // Define custom timestamp fields
    const CREATED_AT = 'time_stamp';  // Use time_stamp as the created_at equivalent
    const UPDATED_AT = 'edit_time';   // Use edit_time as the updated_at equivalent

    // Relationship to a Question (if the Post is a Question)
    public function question()
    {
        return $this->hasOne(Question::class, 'post_id');
    }

    // Relationship to an Answer (if the Post is an Answer)
    public function answer()
    {
        return $this->hasOne(Answer::class, 'post_id');
    }
}



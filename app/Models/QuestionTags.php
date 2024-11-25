<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTags extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamps that laravel automatically creates and we dont need

    protected $table = 'question_tags';
    protected $fillable = ['question_id', 'tag_id'];
    
}

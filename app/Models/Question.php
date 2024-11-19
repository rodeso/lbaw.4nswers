<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'question';
    protected $fillable = ['title', 'urgency', 'time_end', 'closed', 'author_id', 'post_id'];
    protected $casts = [
        'time_end' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}

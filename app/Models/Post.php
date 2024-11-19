<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $table = 'post';
    protected $fillable = ['body', 'time_stamp', 'deleted', 'edited', 'edit_time'];

    public function question()
    {
        return $this->hasOne(Question::class, 'post_id');
    }
}


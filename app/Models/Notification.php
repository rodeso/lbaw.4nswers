<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $fillable = ['content', 'time_stamp', 'post_id', 'user_id'];

    public $timestamps = false; // Disable automatic timestamps

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function moderatorNotification()
    {
        return $this->hasOne(ModeratorNotification::class, 'notification_id');
    }
}


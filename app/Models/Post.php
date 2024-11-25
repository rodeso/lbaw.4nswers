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

    public $timestamps = false; // Disable automatic Laravel timestamps

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

    // Relationship to Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'post_id');
    }

    // Relationship to ModeratorNotifications through Notifications
    public function moderatorNotifications()
    {
        return $this->hasManyThrough(
            ModeratorNotification::class,
            Notification::class,
            'post_id',          // Foreign key on the notifications table
            'notification_id',  // Foreign key on the moderator_notifications table
            'id',               // Local key on the posts table
            'id'                // Local key on the notifications table
        );
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->whereRaw(
            "to_tsvector('english', body) @@ plainto_tsquery('english', ?)",
            [$searchTerm]
        );
    }
}



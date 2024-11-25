<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeratorNotification extends Model
{
    use HasFactory;

    protected $table = 'moderator_notification';
    protected $fillable = ['notification_id', 'reason'];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}



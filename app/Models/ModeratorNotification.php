<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeratorNotification extends Model
{
    use HasFactory;

    protected $table = 'moderator_notification';
    
    protected $primaryKey = 'notification_id';
    public $incrementing = false; // Since notification_id is not auto-incrementing
    protected $keyType = 'integer';

    protected $fillable = ['notification_id', 'reason'];

    public $timestamps = false; // Disable automatic timestamps

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}



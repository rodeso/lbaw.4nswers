<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerNotification extends Model
{
    use HasFactory;

    protected $table = 'answer_notification';
    protected $fillable = ['notification_id', 'user_'];

    protected $primaryKey = 'notification_id';
    public $incrementing = false; // Since notification_id is not auto-incrementing
    protected $keyType = 'integer';

    public $timestamps = false; // Disable automatic timestamps

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportNotification extends Model
{
    use HasFactory;

    protected $table = 'report_notification';
    
    protected $primaryKey = 'notification_id';
    public $incrementing = false; // Since notification_id is not auto-incrementing
    protected $keyType = 'integer';

    protected $fillable = ['notification_id', 'report'];

    public $timestamps = false; // Disable automatic timestamps

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}



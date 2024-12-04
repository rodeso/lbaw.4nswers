<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin'; // Specify the table name

    // Specify any fillable attributes if needed
    protected $fillable = ['user_id']; 

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

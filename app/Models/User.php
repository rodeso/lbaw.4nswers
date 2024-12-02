<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'lbaw24112.user';
    protected $fillable = [
        'name', 'nickname', 'email', 'password', 'birth_date', 
        'aura', 'profile_picture', 'created', 'deleted', 'is_mod'
    ];

    protected $hidden = [
        'password',
        'remember_token', // Not used?
    ];

    protected $casts = [
        'birth_date' => 'date',
        'aura' => 'integer',
        'deleted' => 'boolean',
        'is_mod' => 'boolean',
        'created' => 'date',
    ];

    public $timestamps = false; // Disable timestamps that laravel automatically creates and we dont need

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Define the user's authored content
    public function questions()
    {
        return $this->hasMany(Question::class, 'author_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $fillable = ['name', 'nickname', 'email', 'password', 'birth_date', 'aura', 'profile_picture', 'created', 'deleted', 'is_mod'];
    protected $casts = [
        'birth_date' => 'date',
        'aura' => 'integer',
        'deleted' => 'boolean',
        'is_mod' => 'boolean',
        'created' => 'date',
    ];
    

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
  
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}

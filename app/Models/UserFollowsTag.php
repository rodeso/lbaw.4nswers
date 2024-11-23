<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowsTag extends Model
{
    use HasFactory;

    protected $table = 'user_follows_tag';

    protected $fillable = ['user_id', 'tag_id'];

    public $timestamps = false;
}
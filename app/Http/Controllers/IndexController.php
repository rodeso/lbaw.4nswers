<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\UserFollowsTag;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questions = Question::with(['tags', 'post'])->get();
        $tags = Tag::all();
        $user_tags = $user 
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if $user is null
        return view('index', compact('user','questions', 'tags', 'user_tags'));
    }
}


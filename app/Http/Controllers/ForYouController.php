<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\Tag;
use App\Models\UserFollowsTag;


class ForYouController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get logged-in user
        $questions = Question::with(['tags', 'post'])->get();
        $tags = Tag::all();
        $user_tags = Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get();
        return view('foryou', compact('user', 'questions', 'tags', 'user_tags'));
    }
}

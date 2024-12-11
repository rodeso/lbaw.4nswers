<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\Tag;
use App\Models\UserFollowsTag;
use App\Models\User;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get logged-in user
        $users = User::orderBy('aura', 'desc')->get();
        $questions = Question::with(['tags', 'post'])->get();
        $tags = Tag::all();
        $user_tags = $user 
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', $user->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if $user is null
        return view('admin-dashboard', compact('user', 'users', 'questions', 'tags', 'user_tags'));
    }
}

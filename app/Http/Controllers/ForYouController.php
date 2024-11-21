<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\Tag;


class ForYouController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get logged-in user
        $questions = Question::with(['tags', 'post'])->get();
        $tags = Tag::all();
        return view('foryou', compact('user', 'questions', 'tags'));
    }
}

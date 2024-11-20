<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $questions = Question::with(['tags', 'post'])->get();
        $tags = Tag::all();

        return view('index', compact('questions', 'tags'));
    }
}


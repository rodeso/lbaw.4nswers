<?php

// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        // Retrieve all questions with their related post data
        $questions = Question::with('post')->get();

        return view('index', compact('questions'));
    }
}

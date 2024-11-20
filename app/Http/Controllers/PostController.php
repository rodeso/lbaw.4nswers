<?php

// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($id)
    {
        // Retrieve the specific question with its related post data
        $question = Question::with('post')->findOrFail($id);
    
        // Pass the question to the view
        return view('post', compact('question'));
    }    
}

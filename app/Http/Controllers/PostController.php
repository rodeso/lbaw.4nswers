<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($id)
    {
        // Retrieve the specific question with its related data
        $question = Question::with(['post', 'answers.post', 'tags', 'author', 'answers.author'])->findOrFail($id);
    
        // Extract tags separately
        $user_tags = $question->tags;
    
        // Pass the question and tags to the view
        return view('post', compact('question', 'user_tags'));
    }
    
}



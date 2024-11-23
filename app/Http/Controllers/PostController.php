<?php

// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($id)
    {
        // Retrieve the specific question with its related data
        $question = Question::with(['post', 'answers.post', 'tags'])->findOrFail($id);
    
        // Extract tags separately if needed
        $user_tags = $question->tags;
    
        return view('post', compact('question', 'user_tags'));
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

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


    public function storeAnswer(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:4096',
            'question_id' => 'required|exists:question,id',
        ]);

        // Create the post associated with the answer
        $post = Post::create([
            'body' => $request->body,
            'time_stamp' => now(), // Set creation timestamp
        ]);

        // Create the answer with the post_id
        $answer = new Answer([
            'body' => $validated['body'],
            'author_id' => Auth::id(),
            'question_id' => $validated['question_id'],
            'post_id' => $post->id,  // Link the answer to the created post
        ]);
        
        // Save the answer
        $answer->save();

        // Optionally update the 'edit_time' when the post is updated
        $post->edit_time = now(); // Set the edit_time to current time
        $post->save();

        // Redirect or return success response
        return redirect()->route('question.show', ['id' => $validated['question_id']]);
    }

    
}



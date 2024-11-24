<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Tag;
use App\Models\UserFollowsTag;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id)
    {
        // Retrieve the specific question with its related data
        $question = Question::with(['post', 'answers.post', 'tags', 'author', 'answers.author'])->findOrFail($id);
    
        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if logged in user is null
    
        // Pass the question and tags to the view
        return view('post', compact('question', 'user_tags'));
    }

    public function showNewQuestion()
    {
        // Tags that user follows
        $user_tags = Auth::user()
            ? Tag::whereIn('id', UserFollowsTag::where('user_id', Auth::user()->id)->pluck('tag_id'))->get()
            : collect(); // Return an empty collection if logged in user is null
        
        // Extract all the tags
        $tags = Tag::all();
    
        // Pass the tags to the view
        return view('new-question', compact('tags', 'user_tags'));
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

    public function storeQuestion(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:4096',
            'urgency' => 'required|string|in:Red,Orange,Yellow,Green', // Validate against allowed values
        ]);

        // Create the associated post first
        $post = Post::create([
            'body' => $validated['body'],
            'time_stamp' => now(),
        ]);

        // Define urgency levels with corresponding durations in hours
        $urgencyDurations = [
            'Red' => 3,
            'Orange' => 5,
            'Yellow' => 10,
            'Green' => 24,
        ];
        // Calculate `time_end` 
        $timeEnd = now()->addHours($urgencyDurations[$validated['urgency']]);

        // Create the question
        $question = Question::create([
            'title' => $validated['title'],
            'urgency' => $validated['urgency'],
            'author_id' => Auth::id(),
            'post_id' => $post->id,
            'time_end' => $timeEnd,
            'closed' => false,
        ]);

        // Redirect to the newly created question page
        return redirect()->route('question.show', $question->id)->with('success', 'Your question has been posted successfully.');
    }


    
}



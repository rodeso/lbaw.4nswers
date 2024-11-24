<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Post;
use App\Models\PopularityVote;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id)
    {
        // Retrieve the specific question with its related data
        $question = Question::with(['post', 'answers.post', 'tags', 'author', 'answers.author'])->findOrFail($id);
    
        // Extract tags separately
        $user_tags = $question->tags;
    
        // Get the user's vote (if they have voted)
        $userVote = null;
        if (auth()->check()) {
            $userVote = PopularityVote::where('user_id', auth()->id())
                ->where('question_id', $id)
                ->value('is_positive');
        }
    
        // Pass the question, tags, and userVote to the view
        return view('post', compact('question', 'user_tags', 'userVote'));
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

    public function vote(Request $request, $questionId)
    {
        $userId = auth()->id();
        $voteType = $request->input('vote'); // 'upvote' or 'downvote'
    
        // Check if the user has already voted
        $existingVote = PopularityVote::where('user_id', $userId)
            ->where('question_id', $questionId)
            ->first();
    
        if ($existingVote) {
            // If the user clicks the same button twice, remove the vote (undo)
            if (($voteType === 'upvote' && $existingVote->is_positive) ||
                ($voteType === 'downvote' && !$existingVote->is_positive)) {
                $existingVote->delete();
    
                // Return the updated vote count
                $totalVotes = PopularityVote::where('question_id', $questionId)
                    ->where('is_positive', true)->count()
                    - PopularityVote::where('question_id', $questionId)
                    ->where('is_positive', false)->count();
    
                return response()->json(['totalVotes' => $totalVotes]);
            }
    
            // Otherwise, update the vote
            $existingVote->is_positive = ($voteType === 'upvote');
            $existingVote->save();
        } else {
            // Create a new vote if none exists
            PopularityVote::create([
                'user_id' => $userId,
                'question_id' => $questionId,
                'is_positive' => ($voteType === 'upvote'),
            ]);
        }
    
        // Calculate total votes
        $totalVotes = PopularityVote::where('question_id', $questionId)
            ->where('is_positive', true)->count()
            - PopularityVote::where('question_id', $questionId)
            ->where('is_positive', false)->count();
    
        return response()->json(['totalVotes' => $totalVotes]);
    }

}


